<?php
/*
Plugin Name: Meacodes Accessibility Tools
Plugin URI: https://www.meacodes.com/accessibility
Description:This is an accessibility tools for people with disabilities to use the web easily.
Version: 1.0.2
Author: Meacodes
Author URI: https://www.meacodes.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: meacodes-accessibility-tools
Domain Path: /languages
*/
defined('ABSPATH') || exit;
define('meaAccessibility_PLUGIN_VERSION', '1.0.2');
register_activation_hook( __FILE__, 'meaAccessibility_activation_function' );
// Set default options
function meaAccessibility_activation_function() {
  // Ensure the current user has the capability to activate plugins
  if (!current_user_can('activate_plugins')) {
      return;
  }
  // Set default options
  add_option('meaAccessibility_selected_position', 'meaAccessibility_widgetBottomLeft');
  add_option('meaAccessibility_background_color', '#F8F3EE');
  add_option('meaAccessibility_labels_color', '#373737');
  add_option('meaAccessibility_divider_line_color', '#c4c4c4');
  add_option('meaAccessibility_plugin_logo_color', '#3abddd');
  add_option('meaAccessibility_accent_color', '#3abddd');
  add_option('meaAccessibility_buttons_hover_color', '#207f97');
  add_option('meaAccessibility_buttons_color', '#3ABDDD');
}
// Enqueue necessary scripts and styles for the plugin
function meaAccessibility_enqueue_plugin_assets() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('meaAccessibility_set-cookie-script', plugin_dir_url(__FILE__) . 'assets/js/meaAccessibility_setCookie_script.js', array(), '1.0', true);
  wp_enqueue_script('meaAccessibilityModule', plugin_dir_url(__FILE__) . 'assets/js/meaAccessibilityModule.js', array('jquery'), '1.0', true);
  $meaAccessibility_selected_position = sanitize_text_field(get_option('meaAccessibility_selected_position', 'meaAccessibility_widgetBottomLeft'));
  $ajax_nonce = wp_create_nonce('meaAccessibility_ajax_nonce');
  wp_localize_script('meaAccessibilityModule', 'meaParams', array(
    'selectedPosition' => $meaAccessibility_selected_position,
    'errorMessage' => 'jQuery is not loaded!',
    'ajaxNonce' => $ajax_nonce,
  ));
  global $meaAccessibility_background_color_Obj;
  $meaAccessibility_background_color_Obj = esc_attr(get_option('meaAccessibility_background_color', '#F8F3EE'));
  global $meaAccessibility_labels_color_Obj;
  $meaAccessibility_labels_color_Obj = esc_attr(get_option('meaAccessibility_labels_color', '#373737'));
  global $meaAccessibility_divider_line_color_Obj;
  $meaAccessibility_divider_line_color_Obj = esc_attr(get_option('meaAccessibility_divider_line_color', '#c4c4c4'));
  global  $meaAccessibility_plugin_logo_color_Obj;
  $meaAccessibility_plugin_logo_color_Obj = esc_attr(get_option('meaAccessibility_plugin_logo_color', '#3abddd'));
  global $meaAccessibility_accent_color_Obj;
  $meaAccessibility_accent_color_Obj = esc_attr(get_option('meaAccessibility_accent_color', '#3abddd'));
  global $meaAccessibility_buttons_hover_color_Obj;
  $meaAccessibility_buttons_hover_color_Obj = esc_attr(get_option('meaAccessibility_buttons_hover_color', '#207f97'));
  global $meaAccessibility_buttons_color_Obj;
  $meaAccessibility_buttons_color_Obj = esc_attr(get_option('meaAccessibility_buttons_color', '#3ABDDD'));
  wp_enqueue_style('themeCss', plugin_dir_url(__FILE__) . 'assets/Themes/Default_blue/theme.css', array(), meaAccessibility_PLUGIN_VERSION);
  wp_enqueue_style('generalCss', plugin_dir_url(__FILE__) . 'assets/Themes/Default_blue/general.css', array(), meaAccessibility_PLUGIN_VERSION);
  if (is_rtl()) {
    wp_enqueue_style('general-rtl', plugin_dir_url(__FILE__) . 'assets/Themes/Default_blue/general-rtl.css', array(), meaAccessibility_PLUGIN_VERSION);
    wp_enqueue_style('theme-rtl', plugin_dir_url(__FILE__) . 'assets/Themes/Default_blue/theme-rtl.css', array(), meaAccessibility_PLUGIN_VERSION);
  }
  $meaAccessibility_enable_movable_plugin = get_option('meaAccessibility_enable_movable_plugin', true);
    if ($meaAccessibility_enable_movable_plugin) {
        wp_enqueue_script('dragElementScript', plugin_dir_url(__FILE__) . 'assets/js/drag_meaAc_plugin.js', array(), '1.0', true);
    }
}
add_action('plugins_loaded', 'meaAccessibility_load_textdomain');
function meaAccessibility_load_textdomain() {
    load_plugin_textdomain('meacodes-accessibility-tools', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
function meaAccessibility_add_admin_menu() {
  add_menu_page(
    __('Meacodes Accessibility Tools', 'meacodes-accessibility-tools'),
    __('Mea Accessibility', 'meacodes-accessibility-tools'),
    'manage_options',
    'meaAccessibility_settings_page',
    'meaAccessibility_settings_page_callback',
    plugin_dir_url(__FILE__) . 'assets/Themes/Default_blue/img/accessibility_icon.svg',
    80
);
add_submenu_page(
  'meaAccessibility_settings_page',
  __('Settings', 'meacodes-accessibility-tools'),
  __('Settings', 'meacodes-accessibility-tools'),
  'manage_options',
  'meaAccessibility_settings_page',
);
add_submenu_page(
    'meaAccessibility_settings_page',
    __('Help', 'meacodes-accessibility-tools'),
    __('Help', 'meacodes-accessibility-tools'),
    'manage_options',
    'mea-settings-help',
    'meaAccessibility_help_page_callback'
);
add_submenu_page(
    'meaAccessibility_settings_page',
    __('Donation', 'meacodes-accessibility-tools'),
    __('Donation', 'meacodes-accessibility-tools'),
    'manage_options',
    'mea-settings-donation',
    'meaAccessibility_donation_page_callback'
);
}
require_once(plugin_dir_path(__FILE__) . 'assets/Themes/Default_blue/theme.php');
require_once plugin_dir_path(__FILE__) . 'assets/admin/admin-theme.php';
function meaAccessibility_enqueue_admin_assets() {
  wp_enqueue_style('mea-admin-styles', plugin_dir_url(__FILE__) . 'assets/admin/css/meacodes_acc_admin.css', array(), meaAccessibility_PLUGIN_VERSION);
  if (is_rtl()) {
    wp_enqueue_style('mea-admin-rtl-styles', plugin_dir_url(__FILE__) . 'assets/admin/css/meacodes_acc_admin-rtl.css', array(), meaAccessibility_PLUGIN_VERSION);
  }
}
add_action('admin_enqueue_scripts', 'meaAccessibility_enqueue_admin_assets');
// Callback function to render plugin settings page
function meaAccessibility_settings_page_callback() {
  ?><?php meaAccessibility_admin_thm(); ?><?php
}
// Help page callback
function meaAccessibility_help_page_callback() {
  ?><?php meaAccessibility_help_page(); ?><?php
}
// Donation page callback
function meaAccessibility_donation_page_callback() {
  ?><?php meaAccessibility_donation_page(); ?><?php
}
function meaAccessibility_reset_settings_callback() {
  update_option('meaAccessibility_selected_position', 'meaAccessibility_widgetBottomLeft');
  update_option('meaAccessibility_background_color', '#F8F3EE');
  update_option('meaAccessibility_labels_color', '#373737');
  update_option('meaAccessibility_divider_line_color', '#c4c4c4');
  update_option('meaAccessibility_plugin_logo_color', '#3abddd');
  update_option('meaAccessibility_accent_color', '#3abddd');
  update_option('meaAccessibility_buttons_hover_color', '#207f97');
  update_option('meaAccessibility_buttons_color', '#3ABDDD');
  update_option('meaAccessibility_header_text', 'Accessibility');
  update_option('meaAccessibility_font_size_Fe', 'true');
  update_option('meaAccessibility_font_size_Fe', '1');
  update_option('meaAccessibility_line_height_Fe', 'true');
  update_option('meaAccessibility_line_height_Fe', '1');
  update_option('meaAccessibility_letter_spacing_Fe', 'true');
  update_option('meaAccessibility_letter_spacing_Fe', '1');
  update_option('meaAccessibility_dyslexia_mask_Fe', 'true');
  update_option('meaAccessibility_dyslexia_mask_Fe', '1');
  update_option('meaAccessibility_grayscale_page_Fe', 'true');
  update_option('meaAccessibility_grayscale_page_Fe', '1');
  update_option('meaAccessibility_contrast_Fe', 'true');
  update_option('meaAccessibility_contrast_Fe', '1');
  update_option('meaAccessibility_negativ_Fe', 'true');
  update_option('meaAccessibility_negativ_Fe', '1');
  update_option('meaAccessibility_underlined_links_Fe', 'true');
  update_option('meaAccessibility_underlined_links_Fe', '1');
  update_option('meaAccessibility_highlight_links_Fe', 'true');
  update_option('meaAccessibility_highlight_links_Fe', '1');
  update_option('meaAccessibility_grayscale_images_Fe', 'true');
  update_option('meaAccessibility_grayscale_images_Fe', '1');
  update_option('meaAccessibility_black_white_Fe', 'true');
  update_option('meaAccessibility_black_white_Fe', '1');
  update_option('meaAccessibility_status_plugin', 'true');
  update_option('meaAccessibility_status_plugin', '1');
  update_option('meaAccessibility_privacy_notice_Fe', 'true');
  update_option('meaAccessibility_privacy_notice_Fe', '1');
  update_option('meaAccessibility_enable_movable_plugin', '0');
  wp_create_nonce('meaAccessibility_ajax_nonce');
  wp_send_json_success();
}
function meaAccessibility_admin_init() {
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_header_text', 'sanitize_text_field');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_selected_position');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_background_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_labels_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_divider_line_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_plugin_logo_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_accent_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_buttons_hover_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_buttons_color', 'sanitize_hex_color');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_copyright_text', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_font_size_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_line_height_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_letter_spacing_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_dyslexia_mask_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_grayscale_page_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_contrast_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_negativ_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_underlined_links_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_highlight_links_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_grayscale_images_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_black_white_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_status_plugin', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_privacy_notice_Fe', 'sanitize_boolean');
  register_setting('meaAccessibility_settings_group', 'meaAccessibility_enable_movable_plugin', 'sanitize_boolean');
}
add_action('admin_init', 'meaAccessibility_admin_init');
add_action('wp_ajax_update_selected_color', 'update_selected_color');
add_action('wp_ajax_nopriv_update_selected_color', 'update_selected_color');
// main Plugin
function meaAccessibility_plugin_html_to_footer() {
  global $meaAccessibility_background_color_Obj;
  global $meaAccessibility_labels_color_Obj;
  global $meaAccessibility_divider_line_color_Obj;
  global $meaAccessibility_plugin_logo_color_Obj;
  global $meaAccessibility_accent_color_Obj;
  global $meaAccessibility_buttons_hover_color_Obj;
  global $meaAccessibility_buttons_color_Obj;
?>
<style>
  .meaAccessibility_mainbg-admin {
    background-color: <?php echo esc_attr($meaAccessibility_background_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_properties > fieldset > legend,
  .meaAccessibility_widget .meaAccessibility_properties > fieldset .meaAccessibility_label {
    color: <?php echo esc_attr($meaAccessibility_labels_color_Obj); ?> !important;
  }
  .meaAccessibility_accessibility-text {
    color: <?php echo esc_attr($meaAccessibility_labels_color_Obj); ?> !important;
  }
  .meaAccessibility_copyright-text-color {
    color: <?php echo esc_attr($meaAccessibility_labels_color_Obj); ?> !important;
  }
  .meaAccessibility_widget.meaAccessibility_widgetOpen .meaAccessibility_enable_border {
    border-bottom: solid 1px <?php echo esc_attr($meaAccessibility_divider_line_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_propertiesToggle::before {
    background-color: <?php echo esc_attr($meaAccessibility_plugin_logo_color_Obj); ?> !important;
  }
  body.meaAccessibility_fontSizeS .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_fontSizeField::before, body.meaAccessibility_fontSizeL .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_fontSizeField::before, body.meaAccessibility_fontSizeXL .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_fontSizeField::before, body.meaAccessibility_fontSizeXXL .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_fontSizeField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_dyslexic .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_dyslexicField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_aUnderlined .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_aUnderlinedField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_aHighlight .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_aHighlightField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_grayscaleImg .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_grayscaleImgField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_letterSpacing1 .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_letterSpacingField::before, body.meaAccessibility_letterSpacing2 .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_letterSpacingField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  body.meaAccessibility_lineHeight1 .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_lineHeightField::before, body.meaAccessibility_lineHeight2 .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_lineHeightField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  html.meaAccessibility_contrast .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_contrastField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  html.meaAccessibility_negativ .meaAccessibility_widget .meaAccessibility_properties .meaAccessibility_negativField::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_rbSlider input[type=radio] + label:hover {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_rbSlider input[type=radio]:checked + label {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget.meaAccessibility_widgetCompact .meaAccessibility_fieldsetSwitch .meaAccessibility_switchBox input[type="checkbox"]:checked + label::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_switchBox input[type=checkbox] + label:hover::after {
    border-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_switchBox input[type=checkbox]:checked + label::after {
    border-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_widgetButton {
    background: <?php echo esc_attr($meaAccessibility_buttons_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_widgetButton:hover {
    background-color: <?php echo esc_attr($meaAccessibility_buttons_hover_color_Obj); ?> !important;
  }
  .meaAccessibility_widget .meaAccessibility_switchBox input[type=checkbox]:checked + label::before {
    background-color: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .top-inner-adhd-box {
    background: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }
  .bottom-inner-adhd-box {
    background: <?php echo esc_attr($meaAccessibility_accent_color_Obj); ?> !important;
  }

</style>
<?php
// Call Plugin on website
  meaAccessibility_main_thm(); ?>
<?php
  }
  add_action('wp_ajax_update_selected_color', 'update_selected_color');
  add_action('wp_ajax_reset_settings_action', 'meaAccessibility_reset_settings_callback');
  add_action('wp_ajax_nopriv_reset_settings_action', 'meaAccessibility_reset_settings_callback');
  add_action('wp_ajax_nopriv_update_selected_color', 'update_selected_color');
  add_action('admin_menu', 'meaAccessibility_add_admin_menu');
  add_action('wp_enqueue_scripts', 'meaAccessibility_enqueue_plugin_assets');
  add_action('admin_init', 'meaAccessibility_admin_init');
  add_action('wp_footer', 'meaAccessibility_plugin_html_to_footer');
?>
