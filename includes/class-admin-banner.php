<?php
/**
 * Admin Banner Class for Meacodes Accessibility Tools
 *
 * @package Meacodes_Accessibility_Tools
 * @since 1.0.6
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Meacodes_Admin_Banner
 *
 * Handles the display and dismissal of promotional banner in WordPress admin
 */
class Meacodes_Admin_Banner {

    /**
     * Transient key for banner dismissal
     *
     * @var string
     */
    private $dismissal_key = '_meacodes_banner_dismissed';

    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_init', array($this, 'init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_ajax_meacodes_dismiss_banner', array($this, 'dismiss_banner'));
    }

    /**
     * Initialize the banner functionality
     */
    public function init() {
        // Only show banner to users who can manage options
        if (!current_user_can('manage_options')) {
            return;
        }

        // Hook into admin header to display banner
        add_action('in_admin_header', array($this, 'maybe_display_banner'));
    }

    /**
     * Enqueue necessary assets
     *
     * @param string $hook Current admin page hook
     */
    public function enqueue_assets($hook) {
        // Only load on admin pages
        if (!is_admin()) {
            return;
        }

        // Enqueue CSS
        wp_enqueue_style(
            'meacodes-banner-css',
            plugin_dir_url(dirname(__FILE__)) . 'assets/admin/css/meacodes-banner.css',
            array(),
            meaAccessibility_get_asset_version()
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'meacodes-banner-js',
            plugin_dir_url(dirname(__FILE__)) . 'assets/admin/js/meacodes-banner.js',
            array('jquery'),
            meaAccessibility_get_asset_version(),
            true
        );

        // Localize script for AJAX
        wp_localize_script('meacodes-banner-js', 'meacodesBanner', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('meacodes_banner_nonce'),
            'action' => 'meacodes_dismiss_banner'
        ));
    }

    /**
     * Check if banner should be displayed
     *
     * @return bool
     */
    private function should_display_banner() {
        // Check if user has dismissed the banner
        $dismissed = get_transient($this->dismissal_key);
        
        if ($dismissed) {
            return false;
        }

        return true;
    }

    /**
     * Display the banner if conditions are met
     */
    public function maybe_display_banner() {
        if (!$this->should_display_banner()) {
            return;
        }

        $this->render_banner();
    }

    /**
     * Render the banner HTML
     */
    private function render_banner() {
        $badge_url = plugin_dir_url(dirname(__FILE__)) . 'assets/admin/img/badge.png';
        $campaign_url = 'https://meacodes.com';
        
        ?>
        <div id="meacodes-promo-banner" class="meacodes-banner" role="alert" aria-live="polite">
            <div class="meacodes-banner-content">
                <button type="button" class="meacodes-banner-close" aria-label="<?php esc_attr_e('Close banner', 'meacodes-accessibility-tools'); ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                <div class="meacodes-banner-message">
                    <h3><?php esc_html_e('🎉 Congratulations!', 'meacodes-accessibility-tools'); ?></h3>
                    <p>
                        <?php 
                        printf(
                            /* translators: %s: Plugin name */
                            esc_html__('Because you\'re using the %s plugin, you\'ve earned an exclusive badge for a 3-month Pro Version 2 subscription — launching soon!', 'meacodes-accessibility-tools'),
                            '<strong>Meacodes Accessibility Tools</strong>'
                        );
                        ?>
                    </p>
                    
                    <p><strong><?php esc_html_e('The upcoming version introduces advanced features like:', 'meacodes-accessibility-tools'); ?></strong></p>
                    
                    <div class="meacodes-features-grid">
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Modern Mobile First Responsive Design', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Smart Site Search Engine', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Professional Keyboard Navigation', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Page Structure Overview', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Smart Screen Reader Integration', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Auto Translate – Seamless Multilingual Experience', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Flexible Fonts — Google & Custom Options', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Endless Customization', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Fully Customizable Appearance & Theme Control', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Effortless Dark & Light Mode Customization', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Personalized Accessibility Profiles for Every User', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Advanced Analytics & Accessibility Insights', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('Comprehensive WCAG 2.1 Issue Detection & Solutions', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Complete Accessibility Issue Summary for Your Website', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                        <div class="meacodes-feature-row">
                            <span class="meacodes-feature-item"><?php esc_html_e('WordPress Performance & Security Score', 'meacodes-accessibility-tools'); ?></span>
                            <span class="meacodes-feature-item"><?php esc_html_e('Real-Time Website Performance Analysis', 'meacodes-accessibility-tools'); ?></span>
                        </div>
                    </div>
                    
                    <p>
                        <strong><?php esc_html_e('💎 Register your website now in our Airdrop Campaign to claim your exclusive rewards and upcoming discounts!', 'meacodes-accessibility-tools'); ?></strong>
                    </p>
                    
                    <p>
                        <a href="<?php echo esc_url($campaign_url); ?>" class="meacodes-banner-button" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e('👉 Join Campaign at Meacodes.com', 'meacodes-accessibility-tools'); ?>
                        </a>
                    </p>
                </div>
                
                <div class="meacodes-banner-image">
                    <img src="<?php echo esc_url($badge_url); ?>" alt="<?php esc_attr_e('Meacodes Pro Badge', 'meacodes-accessibility-tools'); ?>" />
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Handle banner dismissal via AJAX
     */
    public function dismiss_banner() {
        // Verify nonce
        $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        if (!wp_verify_nonce($nonce, 'meacodes_banner_nonce')) {
            wp_die(esc_html__('Security check failed', 'meacodes-accessibility-tools'));
        }

        // Check user capabilities
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Insufficient permissions', 'meacodes-accessibility-tools'));
        }

        // Set transient for 24 hours (86400 seconds)
        set_transient($this->dismissal_key, true, 86400);

        wp_send_json_success(array(
            'message' => esc_html__('Banner dismissed successfully', 'meacodes-accessibility-tools')
        ));
    }
}
