<?php
/**
 * Admin interface class
 *
 * @package MeacodesQuickScan
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * MeacodesQuickScan_Admin class
 */
class MeacodesQuickScan_Admin {
    
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
        $this->init_hooks();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Removed add_admin_menu hook - settings are managed in main plugin settings page
        // Removed register_settings hook - settings are registered in main plugin file
        add_action('wp_dashboard_setup', array($this, 'add_dashboard_widget'));
        add_action('wp_ajax_meacodes_run_manual_scan', array($this, 'ajax_run_manual_scan'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Add dashboard widget
     */
    public function add_dashboard_widget() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        try {
            wp_add_dashboard_widget(
                'meacodes_quickscan_dashboard',
                __('Accessibility Quick Scan', 'meacodes-accessibility-tools'),
                array($this, 'dashboard_widget_content')
            );
        } catch (Exception $e) {
            // If widget registration fails, don't break the dashboard
        }
    }
    
    /**
     * Dashboard widget content
     */
    public function dashboard_widget_content() {
        try {
            // Get the latest scan results directly from transient
            $summary = get_transient('meacodes_quickscan_summary');
            
            // Check if scheduler class exists and get status safely
            $status = array(
                'running' => false,
                'last_scan' => null,
                'next_scan' => null,
                'error' => null
            );
            
            if (class_exists('MeacodesQuickScan_Scheduler')) {
                try {
                    $scheduler = MeacodesQuickScan_Scheduler::get_instance();
                    if (method_exists($scheduler, 'get_scan_status')) {
                        $status = $scheduler->get_scan_status();
                    }
                } catch (Exception $e) {
                    $status['error'] = __('Unable to get scan status:', 'meacodes-accessibility-tools') . ' ' . $e->getMessage();
                }
            } else {
                $status['error'] = __('MeacodesQuickScan_Scheduler class not found', 'meacodes-accessibility-tools');
            }
        } catch (Exception $e) {
            // If anything fails, show a safe error message
            echo '<div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; padding: 15px; color: #721c24;">';
            echo '<strong>' . esc_html__('Error:', 'meacodes-accessibility-tools') . '</strong> ' . esc_html__('Unable to load accessibility scan data:', 'meacodes-accessibility-tools') . ' ' . esc_html($e->getMessage());
            echo '</div>';
            return;
        }
        
        try {
        ?>
        <div id="meacodes-accessibility-widget" style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            
            <?php if ($status['running']): ?>
                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 8px; padding: 20px; border: 1px solid #90caf9;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <div style="width: 20px; height: 20px; border: 2px solid #1976d2; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite; margin-right: 10px;"></div>
                        <strong style="color: #1976d2; font-size: 16px;"><?php esc_html_e('Scan is currently running...', 'meacodes-accessibility-tools'); ?></strong>
                    </div>
                    <p style="margin: 0; color: #424242; font-size: 14px;"><?php esc_html_e('Please wait while we scan your website for accessibility issues.', 'meacodes-accessibility-tools'); ?></p>
                </div>
            <?php elseif ($summary && is_array($summary) && isset($summary['last_run'])): ?>
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; border: 1px solid #dee2e6; margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3 style="margin: 0; color: #495057; font-size: 18px; font-weight: 600;"><?php esc_html_e('Accessibility Quick Scan', 'meacodes-accessibility-tools'); ?></h3>
                        <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><?php esc_html_e('Completed', 'meacodes-accessibility-tools'); ?></span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                        <div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #007cba;">
                            <strong style="color: #007cba; display: block; margin-bottom: 5px; font-size: 14px;"><?php esc_html_e('Last Scan', 'meacodes-accessibility-tools'); ?></strong>
                            <span style="color: #6c757d; font-size: 13px;"><?php 
                                try {
                                    $last_scan_time = new DateTime($summary['last_run']);
                                    $last_scan_time->setTimezone(new DateTimeZone(wp_timezone_string()));
                                    echo esc_html($last_scan_time->format('M j, Y H:i T'));
                                } catch (Exception $e) {
                                    echo esc_html($summary['last_run']);
                                }
                            ?></span>
                        </div>
                        <div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #6f42c1;">
                            <strong style="color: #6f42c1; display: block; margin-bottom: 5px; font-size: 14px;"><?php esc_html_e('Pages Scanned', 'meacodes-accessibility-tools'); ?></strong>
                            <span style="color: #6c757d; font-size: 13px;"><?php echo esc_html(isset($summary['pages_scanned']) ? $summary['pages_scanned'] : 0); ?> <?php esc_html_e('pages', 'meacodes-accessibility-tools'); ?> (<?php echo esc_html(isset($summary['duration_seconds']) ? $summary['duration_seconds'] : 0); ?>s)</span>
                        </div>
                    </div>
                    
                    <div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #dc3545;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <strong style="color: #dc3545; font-size: 14px;"><?php esc_html_e('Accessibility Issues Found', 'meacodes-accessibility-tools'); ?></strong>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=meaAccessibility_settings_page&tab=scan#scan-results-display')); ?>" 
                               style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);"
                               onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(220, 53, 69, 0.4)'"
                               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(220, 53, 69, 0.3)'">
                                <span style="margin-right: 4px;">📊</span>
                                <?php esc_html_e('View Details', 'meacodes-accessibility-tools'); ?>
                            </a>
                        </div>
                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                            <span style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 13px;">A: <?php echo esc_html(isset($summary['a']) ? $summary['a'] : 0); ?></span>
                            <span style="background: #fd7e14; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 13px;">AA: <?php echo esc_html(isset($summary['aa']) ? $summary['aa'] : 0); ?></span>
                            <span style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 13px;">AAA: <?php echo esc_html(isset($summary['aaa']) ? $summary['aaa'] : 0); ?></span>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-radius: 8px; padding: 20px; border: 1px solid #ffc107; margin-bottom: 15px;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <span style="font-size: 20px; margin-right: 10px;">⚠️</span>
                        <strong style="color: #856404; font-size: 16px;"><?php esc_html_e('No Scan Results Yet', 'meacodes-accessibility-tools'); ?></strong>
                    </div>
                    <p style="margin: 0; color: #856404; font-size: 14px;"><?php esc_html_e('Run your first accessibility scan to see results here.', 'meacodes-accessibility-tools'); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($status['error']): ?>
                <div style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-radius: 8px; padding: 15px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
                    <strong style="color: #721c24; display: block; margin-bottom: 5px;">⚠️ <?php esc_html_e('Error', 'meacodes-accessibility-tools'); ?></strong>
                    <span style="color: #721c24; font-size: 14px;"><?php echo esc_html($status['error']); ?></span>
                </div>
            <?php endif; ?>
            
            <!-- New Scan Button Section -->
            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; border: 1px solid #dee2e6; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0; color: #495057; font-size: 16px; font-weight: 600;"><?php esc_html_e('Quick Actions', 'meacodes-accessibility-tools'); ?></h4>
                </div>
                
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button id="dashboard-run-scan" type="button" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);" 
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(40, 167, 69, 0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(40, 167, 69, 0.3)'">
                        <span style="margin-right: 6px;">🔍</span>
                        <?php esc_html_e('Perform New Scan', 'meacodes-accessibility-tools'); ?>
                    </button>
                </div>
                
                <div id="dashboard-scan-status" style="margin-top: 15px; display: none;">
                    <!-- Scan status will be shown here -->
                </div>
            </div>
            
            <div style="background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%); border-radius: 8px; padding: 15px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
                <p style="margin: 0 0 10px 0; color: #155724; font-size: 14px; font-weight: 500;">
                    <strong><?php esc_html_e('Lightweight summary only.', 'meacodes-accessibility-tools'); ?></strong> <?php esc_html_e('Full page-by-page reports & fixes guides will be available in Pro v2.', 'meacodes-accessibility-tools'); ?>
                </p>
                <a href="https://meacodes.com" target="_blank" style="display: inline-flex; align-items: center; background: linear-gradient(135deg, #007cba 0%, #005a87 100%); color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s ease;">
                    <span style="margin-right: 6px;">🚀</span>
                    <?php esc_html_e('Read More / Join Airdrop', 'meacodes-accessibility-tools'); ?>
                </a>
            </div>
        </div>
        
        <style>
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
        
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanButton = document.getElementById('dashboard-run-scan');
            const statusDiv = document.getElementById('dashboard-scan-status');
            
            if (scanButton && statusDiv) {
                scanButton.addEventListener('click', function() {
                    const button = this;
                    const originalText = button.innerHTML;
                    
                    // Disable button and show loading state
                    button.disabled = true;
                    button.innerHTML = '<span style="margin-right: 6px;">⏳</span><?php echo esc_js(__('Scanning...', 'meacodes-accessibility-tools')); ?>';
                    button.style.backgroundColor = '#6c757d';
                    button.style.cursor = 'not-allowed';
                    
                    // Show status
                    statusDiv.style.display = 'block';
                    statusDiv.innerHTML = '<div style="background: #e3f2fd; border: 1px solid #90caf9; border-radius: 6px; padding: 15px; color: #1976d2; font-size: 14px;"><strong><?php echo esc_js(__('Scan in progress...', 'meacodes-accessibility-tools')); ?></strong> <?php echo esc_js(__('Please wait while we scan your website.', 'meacodes-accessibility-tools')); ?></div>';
                    
                    // Create AJAX request
                    const formData = new FormData();
                    formData.append('action', 'meacodes_run_manual_scan');
                    formData.append('nonce', '<?php echo esc_js(wp_create_nonce('meacodes_quickscan_nonce')); ?>');
                    formData.append('max_pages', '35'); // Default page limit
                    
                    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success - show success message and redirect to scan results
                            statusDiv.innerHTML = '<div style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px; padding: 15px; color: #155724; font-size: 14px;"><strong><?php echo esc_js(__('Scan completed successfully!', 'meacodes-accessibility-tools')); ?></strong> <?php echo esc_js(__('Redirecting to results...', 'meacodes-accessibility-tools')); ?></div>';
                            
                            // Redirect to scan results section after 2 seconds
                            setTimeout(function() {
                                // Build URL manually to avoid encoding issues
                                const baseUrl = '<?php echo esc_url(admin_url('admin.php')); ?>';
                                const redirectUrl = baseUrl + '?page=meaAccessibility_settings_page&tab=scan#scan-results-display';
                                window.location.replace(redirectUrl);
                            }, 2000);
                        } else {
                            // Error
                            statusDiv.innerHTML = '<div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 15px; color: #721c24; font-size: 14px;"><strong><?php echo esc_js(__('Scan failed:', 'meacodes-accessibility-tools')); ?></strong> ' + (data.data || '<?php echo esc_js(__('Unknown error occurred', 'meacodes-accessibility-tools')); ?>') + '</div>';
                            
                            // Re-enable button
                            button.disabled = false;
                            button.innerHTML = originalText;
                            button.style.backgroundColor = '';
                            button.style.cursor = '';
                        }
                    })
                    .catch(error => {
                        // Network or other error
                        statusDiv.innerHTML = '<div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 15px; color: #721c24; font-size: 14px;"><strong><?php echo esc_js(__('Scan failed:', 'meacodes-accessibility-tools')); ?></strong> <?php echo esc_js(__('Network error occurred', 'meacodes-accessibility-tools')); ?></div>';
                        
                        // Re-enable button
                        button.disabled = false;
                        button.innerHTML = originalText;
                        button.style.backgroundColor = '';
                        button.style.cursor = '';
                    });
                });
            }
        });
        </script>
        <?php
        } catch (Exception $e) {
            // If anything fails in the widget display, show a safe error message
            echo '<div style="background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; padding: 15px; color: #721c24;">';
            echo '<strong>' . esc_html__('Error:', 'meacodes-accessibility-tools') . '</strong> ' . esc_html__('Unable to display accessibility scan widget.', 'meacodes-accessibility-tools');
            echo '</div>';
        }
    }
    
    /**
     * AJAX handler for manual scan
     */
    public function ajax_run_manual_scan() {
        check_ajax_referer('meacodes_quickscan_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to run scans.', 'meacodes-accessibility-tools'));
        }
        
        $scheduler = MeacodesQuickScan_Scheduler::get_instance();
        $result = $scheduler->run_manual_scan();
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        } else {
            wp_send_json_success($result);
        }
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook === 'toplevel_page_meaAccessibility_settings_page' || $hook === 'index.php') {
            wp_enqueue_script('jquery');
            wp_localize_script('jquery', 'meacodesQuickscan', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('meacodes_quickscan_nonce'),
                'strings' => array(
                    'scanRunning' => __('Scan is running...', 'meacodes-accessibility-tools'),
                    'scanComplete' => __('Scan completed successfully!', 'meacodes-accessibility-tools'),
                    'scanFailed' => __('Scan failed. Please try again.', 'meacodes-accessibility-tools')
                )
            ));
            ?>
            <?php
        }
    }
}
