<?php
/**
 * Scanner class for fetching pages and coordinating scans
 *
 * @package MeacodesQuickScan
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * MeacodesQuickScan_Scanner class
 */
class MeacodesQuickScan_Scanner {
    
    /**
     * Single instance
     */
    private static $instance = null;
    
    /**
     * Get single instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        // No hooks needed for this class
    }
    
    /**
     * Run a complete scan
     */
    public function run_scan() {
        $start_time = microtime(true);
        
        // Get page URLs
        $urls = $this->get_page_urls();
        
        if (empty($urls)) {
            // Try to get at least the home page
            $home_url = home_url();
            $urls = array($home_url);
        }
        
        // Limit URLs to max pages setting
        $max_pages = get_option('meacodes_quickscan_max_pages', 35);
        if (count($urls) > $max_pages) {
            $urls = array_slice($urls, 0, $max_pages);
        }
        
        // Initialize counters
        $results = array(
            'last_run' => current_time('c'),
            'pages_scanned' => 0,
            'a' => 0,
            'aa' => 0,
            'aaa' => 0,
            'failed_pages' => 0,
            'duration_seconds' => 0,
            'page_details' => array()
        );
        
        $checks = MeacodesQuickScan_Checks::get_instance();
        $delay = get_option('meacodes_quickscan_delay_between_requests', 500);
        $timeout = get_option('meacodes_quickscan_scan_timeout', 10);
        
        // Scan each page
        foreach ($urls as $url) {
            try {
                $html = $this->fetch_page_html($url, $timeout);
                if ($html) {
                    $page_results = $checks->check_page($html);
                    
                    $results['a'] += $page_results['a'];
                    $results['aa'] += $page_results['aa'];
                    $results['aaa'] += $page_results['aaa'];
                    $results['pages_scanned']++;
                    
                    // Store detailed page results
                    $results['page_details'][] = array(
                        'url' => $url,
                        'title' => $this->get_page_title($html),
                        'a' => $page_results['a'],
                        'aa' => $page_results['aa'],
                        'aaa' => $page_results['aaa'],
                        'issues' => $page_results['issues']
                    );
                } else {
                    $results['failed_pages']++;
                    $results['page_details'][] = array(
                        'url' => $url,
                        'title' => 'Failed to load',
                        'a' => 0,
                        'aa' => 0,
                        'aaa' => 0,
                        'issues' => array('Failed to load page')
                    );
                }
            } catch (Exception $e) {
                $results['failed_pages']++;
                // Log error for debugging (removed in production)
                $results['page_details'][] = array(
                    'url' => $url,
                    'title' => 'Error: ' . $e->getMessage(),
                    'a' => 0,
                    'aa' => 0,
                    'aaa' => 0,
                    'issues' => array('Error: ' . $e->getMessage())
                );
            }
            
            // Rate limiting
            if ($delay > 0) {
                usleep($delay * 1000); // Convert to microseconds
            }
        }
        
        $results['duration_seconds'] = round(microtime(true) - $start_time, 1);
        
        // Save results to transient
        set_transient('meacodes_quickscan_summary', $results, 7 * DAY_IN_SECONDS);
        
        
        return $results;
    }
    
    /**
     * Extract page title from HTML
     */
    private function get_page_title($html) {
        if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches)) {
            return trim(wp_strip_all_tags($matches[1]));
        }
        return 'Untitled';
    }
    
    /**
     * Get list of page URLs to scan
     */
    private function get_page_urls() {
        $max_pages = get_option('meacodes_quickscan_max_pages', 35);
        $urls = array();
        
        // Try sitemap first
        $sitemap_urls = $this->get_urls_from_sitemap();
        if (!empty($sitemap_urls)) {
            $urls = array_slice($sitemap_urls, 0, $max_pages);
        }
        
        // If sitemap didn't provide enough URLs, use REST API
        if (count($urls) < $max_pages) {
            $rest_urls = $this->get_urls_from_rest_api($max_pages - count($urls));
            $urls = array_merge($urls, $rest_urls);
        }
        
        // Remove duplicates and filter to same domain
        $urls = array_unique($urls);
        $urls = $this->filter_same_domain_urls($urls);
        
        // Filter out XML files and non-content URLs
        $urls = array_filter($urls, function($url) {
            return !preg_match('/\.xml$/', $url) && 
                   !preg_match('/\/wp-sitemap-/', $url) &&
                   !preg_match('/\/feed\//', $url) &&
                   !preg_match('/\/rss\//', $url);
        });
        
        return array_slice($urls, 0, $max_pages);
    }
    
    /**
     * Get URLs from sitemap.xml
     */
    private function get_urls_from_sitemap() {
        $sitemap_url = home_url('/sitemap.xml');
        $response = wp_remote_get($sitemap_url, array(
            'timeout' => 10,
            'user-agent' => 'Meacodes Quick Scan/1.0'
        ));
        
        if (is_wp_error($response)) {
            return array();
        }
        
        $body = wp_remote_retrieve_body($response);
        if (empty($body)) {
            return array();
        }
        
        $urls = array();
        
        // Simple XML parsing for sitemap
        if (preg_match_all('/<loc>(.*?)<\/loc>/', $body, $matches)) {
            foreach ($matches[1] as $url) {
                // Only include actual pages/posts, not XML files
                if (!preg_match('/\.xml$/', $url) && !preg_match('/\/wp-sitemap-/', $url)) {
                    $urls[] = esc_url_raw($url);
                }
            }
        }
        
        return $urls;
    }
    
    /**
     * Get URLs from REST API
     */
    private function get_urls_from_rest_api($limit = 50) {
        $urls = array();
        $per_page = min(100, $limit);
        $page = 1;
        
        // Get pages
        while (count($urls) < $limit) {
            $pages_url = rest_url('wp/v2/pages');
            $pages_url = add_query_arg(array(
                'per_page' => $per_page,
                'page' => $page,
                'status' => 'publish'
            ), $pages_url);
            
            $response = wp_remote_get($pages_url, array(
                'timeout' => 10,
                'user-agent' => 'Meacodes Quick Scan/1.0'
            ));
            
            if (is_wp_error($response)) {
                break;
            }
            
            $data = json_decode(wp_remote_retrieve_body($response), true);
            if (empty($data) || !is_array($data)) {
                break;
            }
            
            foreach ($data as $item) {
                if (isset($item['link'])) {
                    $urls[] = $item['link'];
                }
            }
            
            if (count($data) < $per_page) {
                break; // No more pages
            }
            
            $page++;
        }
        
        // Get posts if we still need more URLs
        if (count($urls) < $limit) {
            $page = 1;
            while (count($urls) < $limit) {
                $posts_url = rest_url('wp/v2/posts');
                $posts_url = add_query_arg(array(
                    'per_page' => $per_page,
                    'page' => $page,
                    'status' => 'publish'
                ), $posts_url);
                
                $response = wp_remote_get($posts_url, array(
                    'timeout' => 10,
                    'user-agent' => 'Meacodes Quick Scan/1.0'
                ));
                
                if (is_wp_error($response)) {
                    break;
                }
                
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (empty($data) || !is_array($data)) {
                    break;
                }
                
                foreach ($data as $item) {
                    if (isset($item['link'])) {
                        $urls[] = $item['link'];
                    }
                }
                
                if (count($data) < $per_page) {
                    break; // No more posts
                }
                
                $page++;
            }
        }
        
        return $urls;
    }
    
    /**
     * Filter URLs to same domain only
     */
    private function filter_same_domain_urls($urls) {
        $home_domain = parse_url(home_url(), PHP_URL_HOST);
        $filtered = array();
        
        foreach ($urls as $url) {
            $url_domain = parse_url($url, PHP_URL_HOST);
            if ($url_domain === $home_domain) {
                $filtered[] = $url;
            }
        }
        
        return $filtered;
    }
    
    /**
     * Fetch HTML content from a URL
     */
    private function fetch_page_html($url, $timeout = 10) {
        $response = wp_remote_get($url, array(
            'timeout' => $timeout,
            'user-agent' => 'Meacodes Quick Scan/1.0',
            'headers' => array(
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
            )
        ));
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $code = wp_remote_retrieve_response_code($response);
        if ($code !== 200) {
            return false;
        }
        
        return wp_remote_retrieve_body($response);
    }
    
    /**
     * Get scan statistics
     */
    public function get_scan_stats() {
        $summary = get_transient('meacodes_quickscan_summary');
        $error = get_option('meacodes_scan_last_error');
        
        return array(
            'summary' => $summary,
            'error' => $error,
            'running' => get_transient('meacodes_quickscan_running')
        );
    }
}
