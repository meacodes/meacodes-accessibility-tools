<?php
/**
 * Scheduler class for managing WP-Cron scans
 *
 * @package MeacodesQuickScan
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * MeacodesQuickScan_Scheduler class
 */
class MeacodesQuickScan_Scheduler {
    
    /**
     * Single instance
     */
    private static $instance = null;
    
    
    /**
     * Transient name for scan running flag
     */
    const SCAN_RUNNING_TRANSIENT = 'meacodes_quickscan_running';
    
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
        $this->init_hooks();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('wp_ajax_meacodes_run_manual_scan', array($this, 'handle_manual_scan_ajax'));
    }
    
    
    
    
    
    /**
     * Handle manual scan AJAX request
     */
    public function handle_manual_scan_ajax() {
        try {
            // Check nonce
            $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
            if (!wp_verify_nonce($nonce, 'meacodes_quickscan_nonce')) {
                wp_send_json_error(new WP_Error('invalid_nonce', __('Invalid nonce.', 'meacodes-accessibility-tools')));
            }
            
            if (!current_user_can('manage_options')) {
                wp_send_json_error(new WP_Error('no_permission', __('You do not have permission to run scans.', 'meacodes-accessibility-tools')));
            }
            
            if (get_transient(self::SCAN_RUNNING_TRANSIENT)) {
                wp_send_json_error(new WP_Error('scan_running', __('A scan is already running. Please wait for it to complete.', 'meacodes-accessibility-tools')));
            }
            
            // Set running flag
            set_transient(self::SCAN_RUNNING_TRANSIENT, true, 5 * MINUTE_IN_SECONDS);
            
            // Get max_pages from AJAX request or use default
            $max_pages = isset($_POST['max_pages']) ? absint($_POST['max_pages']) : 35;
            $max_pages = max(1, min(35, $max_pages)); // Limit between 1-35
            
            // Temporarily update the max_pages option for this scan
            $original_max_pages = get_option('meacodes_quickscan_max_pages', 35);
            update_option('meacodes_quickscan_max_pages', $max_pages);
            
            // Run scan immediately
            $scanner = MeacodesQuickScan_Scanner::get_instance();
            $result = $scanner->run_scan();
            
            // Restore original max_pages setting
            update_option('meacodes_quickscan_max_pages', $original_max_pages);
            
            // Clear running flag
            delete_transient(self::SCAN_RUNNING_TRANSIENT);
            
            if (is_wp_error($result)) {
                wp_send_json_error($result);
            }
            
            // Check if result is valid
            if (empty($result) || !is_array($result)) {
                $summary = get_transient('meacodes_quickscan_summary');
            } else {
                $summary = $result;
            }
            
            // Final check
            if (empty($summary)) {
                wp_send_json_error(new WP_Error('no_data', 'Scan completed but no data available'));
            }
            
            // Send the summary data directly as the response
            wp_send_json_success($summary);
        } catch (Exception $e) {
            delete_transient(self::SCAN_RUNNING_TRANSIENT);
            wp_send_json_error(new WP_Error('scan_error', $e->getMessage()));
        }
    }
        
    
    /**
     * Run manual scan immediately
     */
    public function run_manual_scan() {
        if (!current_user_can('manage_options')) {
            return new WP_Error('no_permission', __('You do not have permission to run scans.', 'meacodes-accessibility-tools'));
        }
        
        // Check if scan is already running
        if (get_transient(self::SCAN_RUNNING_TRANSIENT)) {
            return new WP_Error('scan_running', __('A scan is already running. Please wait for it to complete.', 'meacodes-accessibility-tools'));
        }
        
        // Set running flag
        set_transient(self::SCAN_RUNNING_TRANSIENT, true, 300); // 5 minutes
        
        try {
            $scanner = MeacodesQuickScan_Scanner::get_instance();
            $result = $scanner->run_scan();
            
            // Store results
            if ($result) {
                set_transient('meacodes_quickscan_summary', $result, DAY_IN_SECONDS);
                delete_option('meacodes_scan_last_error');
                return $result;
            }
        } catch (Exception $e) {
            update_option('meacodes_scan_last_error', $e->getMessage());
            return new WP_Error('scan_failed', $e->getMessage());
        } finally {
            // Clear running flag
            delete_transient(self::SCAN_RUNNING_TRANSIENT);
        }
        
        return new WP_Error('scan_failed', __('Scan failed to complete.', 'meacodes-accessibility-tools'));
    }
    
    /**
     * Check if scan is running
     */
    public function is_scan_running() {
        return (bool) get_transient(self::SCAN_RUNNING_TRANSIENT);
    }
    
    /**
     * Get scan status
     */
    public function get_scan_status() {
        $summary = get_transient('meacodes_quickscan_summary');
        $error = get_option('meacodes_scan_last_error');
        $running = $this->is_scan_running();
        $next_scan = $this->get_next_scan_time();
        
        return array(
            'running' => $running,
            'last_scan' => $summary ? $summary['last_run'] : null,
            'next_scan' => $next_scan,
            'error' => $error,
            'summary' => $summary
        );
    }
    
    /**
     * Get next scheduled scan time
     */
    public function get_next_scan_time() {
        // Since we removed auto-scan, there's no next scan time
        return null;
    }
}
