<?php 
// Settings Page
function meaAccessibility_admin_thm() {
  if (!current_user_can('manage_options')) {
    return;
  }
  if (isset($_POST['meaAccessibility_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['meaAccessibility_settings_nonce'])), 'meaAccessibility_settings_nonce')) {
    $selected_position = isset($_POST['meaAccessibility_selected_position']) ? sanitize_text_field(wp_unslash($_POST['meaAccessibility_selected_position'])) : '';
    $background_color = isset($_POST['meaAccessibility_background_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_background_color'])) : '';
    $divider_line_color = isset($_POST['meaAccessibility_divider_line_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_divider_line_color'])) : '';
    $plugin_logo_color = isset($_POST['meaAccessibility_plugin_logo_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_plugin_logo_color'])) : '';
    $accent_color = isset($_POST['meaAccessibility_accent_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_accent_color'])) : '';
    $buttons_hover_color = isset($_POST['meaAccessibility_buttons_hover_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_buttons_hover_color'])) : '';
    $buttons_color = isset($_POST['meaAccessibility_buttons_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_buttons_color'])) : '';
    $button_size = isset($_POST['meaAccessibility_button_size']) ? absint(wp_unslash($_POST['meaAccessibility_button_size'])) : 50;
    $button_border_radius = isset($_POST['meaAccessibility_button_border_radius']) ? absint(wp_unslash($_POST['meaAccessibility_button_border_radius'])) : 30;
    $button_margin = isset($_POST['meaAccessibility_button_margin']) ? absint(wp_unslash($_POST['meaAccessibility_button_margin'])) : 20;
    $button_icon_size = isset($_POST['meaAccessibility_button_icon_size']) ? absint(wp_unslash($_POST['meaAccessibility_button_icon_size'])) : 35;
    
    update_option('meaAccessibility_selected_position', $selected_position);
    update_option('meaAccessibility_background_color', $background_color);
    update_option('meaAccessibility_divider_line_color', $divider_line_color);
    update_option('meaAccessibility_plugin_logo_color', $plugin_logo_color);
    update_option('meaAccessibility_accent_color', $accent_color);
    update_option('meaAccessibility_buttons_hover_color', $buttons_hover_color);
    update_option('meaAccessibility_buttons_color', $buttons_color);
    update_option('meaAccessibility_button_size', $button_size);
    update_option('meaAccessibility_button_border_radius', $button_border_radius);
    update_option('meaAccessibility_button_margin', $button_margin);
    update_option('meaAccessibility_button_icon_size', $button_icon_size);
    wp_safe_redirect(admin_url('admin.php?page=mea-settings-help'));
    exit;
  }
  $meaAccessibility_selected_position = sanitize_key( get_option( 'meaAccessibility_selected_position', 'meaAccessibility_widgetBottomLeft' ) );
  $meaAccessibility_background_color_Obj = sanitize_hex_color( get_option( 'meaAccessibility_background_color', '#F8F3EE' ) );
  $meaAccessibility_labels_color_Obj = sanitize_hex_color( get_option( 'meaAccessibility_labels_color', '#373737' ) );
  $meaAccessibility_divider_line_color_Obj = sanitize_hex_color( get_option( 'meaAccessibility_divider_line_color', '#c4c4c4' ) );
  $meaAccessibility_plugin_logo_color_Obj = sanitize_hex_color( get_option( 'meaAccessibility_plugin_logo_color', '#3abddd' ) );
  $meaAccessibility_accent_color = sanitize_hex_color( get_option( 'meaAccessibility_accent_color', '#3abddd' ) );
  $meaAccessibility_buttons_hover_color = sanitize_hex_color( get_option( 'meaAccessibility_buttons_hover_color', '#207f97' ) );
  $meaAccessibility_buttons_color_Obj = sanitize_hex_color( get_option( 'meaAccessibility_buttons_color', '#3ABDDD' ) );
  $meaAccessibility_admin_copyright = esc_url( plugins_url( 'admin/img/mealogo.png', dirname( __FILE__ ) ) );
  
  $ajax_nonce = wp_create_nonce('meaAccessibility_ajax_nonce');
  wp_localize_script( 'meaAccessibilityModule', 'meaParams', array(
    'selectedPosition' => $meaAccessibility_selected_position,
    'errorMessage' => esc_html__( 'jQuery is not loaded!', 'meacodes-accessibility-tools' ),
    'ajaxNonce' => $ajax_nonce,
) );
  ?>
  <div class="wrap meaAccessibility_admin">
    <h1 class="meaAccessibility_nav-tab-wrapper">
      <a href="#" class="meaAccessibility_nav-tab meaAccessibility_nav-tab-active"><?php esc_html_e('General', 'meacodes-accessibility-tools'); ?></a>
      <a href="#" class="meaAccessibility_nav-tab"><?php esc_html_e('Features', 'meacodes-accessibility-tools'); ?></a>
      <a href="#" class="meaAccessibility_nav-tab"><?php esc_html_e('Style', 'meacodes-accessibility-tools'); ?></a>
    </h1>
    
    <!-- Airdrop Campaign Banner -->
    <div class="meaAccessibility_airdrop_banner">
      <div class="meaAccessibility_airdrop_content">
        <span class="meaAccessibility_airdrop_icon">🎉</span>
        <span class="meaAccessibility_airdrop_text">
          <strong><?php esc_html_e('Airdrop Campaign Active!', 'meacodes-accessibility-tools'); ?></strong>
          <?php esc_html_e('Join our exclusive airdrop and earn rewards. Limited time offer!', 'meacodes-accessibility-tools'); ?>
        </span>
        <a href="https://meacodes.com" target="_blank" rel="noopener noreferrer" class="meaAccessibility_airdrop_button">
          <?php esc_html_e('Join Now', 'meacodes-accessibility-tools'); ?>
        </a>
      </div>
    </div>
    
    <!-- Attention Banner (Cache notice) -->
    <div class="meaAccessibility_attention_banner" role="status" aria-live="polite">
      <div class="meaAccessibility_attention_content">
        <span class="meaAccessibility_attention_icon">⚠️</span>
        <span class="meaAccessibility_attention_text">
          <strong><?php esc_html_e('Attention', 'meacodes-accessibility-tools'); ?></strong>
          <?php esc_html_e('We updated the plugin button logic to enable more customization. If after updating it does not work on your site, this is likely a cache issue. Please clear your server and browser cache, then refresh the page.', 'meacodes-accessibility-tools'); ?>
        </span>
      </div>
    </div>
    <div class="meaAccessibility_tab-content">
      <!-- Tab 1 - General -->
      <form method="post" action="options.php">
        <div class="meaAccessibility_tab-pane meaAccessibility_active">
          <h1><?php esc_html_e('General Settings', 'meacodes-accessibility-tools'); ?></h1>
            <?php settings_fields('meaAccessibility_settings_group'); ?>
            <?php do_settings_sections('meaAccessibility_settings_group'); ?>
            <div class="meaAccessibility_admin-content">
              <div class="meaAccessibility_table-column">
                <table class="form-table">
                  <tr valign="top">
                    <th scope="row"><?php esc_html_e('Enable or Disable Meacodes Accessibility Tools:', 'meacodes-accessibility-tools'); ?></th>
                    <td>
                      <label class="meaAccessibility_toggle-switch">
                        <input type="checkbox" id="meaAccessibility_status_plugin" name="meaAccessibility_status_plugin" value="1" <?php checked(get_option('meaAccessibility_status_plugin', true)); ?>>
                        <span class="meaAccessibility_slider"></span>
                      </label>
                    </td>                  
                  </tr>
                  <tr valign="top">
                    <th scope="row"><?php esc_html_e('Plugin Name:', 'meacodes-accessibility-tools'); ?></th>
                    <td>                     
                    <input type="text" id="meaAccessibility_header_text" name="meaAccessibility_header_text" value="<?php echo esc_attr(get_option('meaAccessibility_header_text', __('Accessibility', 'meacodes-accessibility-tools'))); ?>">
                    <p class="meaAccessibility_description" style="font-weight: bold;">Accessibility:</p>
                    <p class="meaAccessibility_description"><?php esc_html_e('This means that the plugin name is a default and automatic translation of the word Accessibility.', 'meacodes-accessibility-tools'); ?></p>
                    <th class="meaAccessibility_tooltip-trigger" style="margin-left: -170px !important;">
                      <div class="meaAccessibility_tooltip">
                        <?php esc_html_e('This name will be displayed opposite the plugin icon in the header section when the accessibility plugin is opened by the user on your website.', 'meacodes-accessibility-tools'); ?>
                        <ul>
                          <li><?php esc_html_e('If you do not want any text to be displayed in that section, Clear default name and save changes.', 'meacodes-accessibility-tools'); ?></li>
                          <li><?php esc_html_e('If your site is multilingual (using Polylang), keep in mind that if you change this name, the name you choose will be displayed without translation and fixed in all languages unless you rebuild the plugins language file with Polylang and enter the translation of the chosen name. Also, if you want the chosen name to revert to the default name and be displayed translated in any language, reset settings once.', 'meacodes-accessibility-tools'); ?></li>
                        </ul>
                      </div>
                    </th>
                  </tr>
                  <tr valign="top">
                    <th scope="row"><?php esc_html_e('Enable or Disable GDPR Notice:', 'meacodes-accessibility-tools'); ?></th>
                    <td>
                      <label class="meaAccessibility_toggle-switch">
                        <input type="checkbox" id="meaAccessibility_privacy_notice_Fe" name="meaAccessibility_privacy_notice_Fe" value="1" <?php checked(get_option('meaAccessibility_privacy_notice_Fe', true)); ?>>
                        <span class="meaAccessibility_slider"></span>
                      </label>
                    </td>
                  </tr>
                  <tr valign="top">
                    <th scope="row"><?php esc_html_e('Developed by label:', 'meacodes-accessibility-tools'); ?></th>
                    <td>
                      <input type="checkbox" id="meaAccessibility_copyright_text" name="meaAccessibility_copyright_text" value="1" <?php checked(get_option('meaAccessibility_copyright_text', false)); ?>>
                      <label for="meaAccessibility_copyright_text"><?php esc_html_e('Enable "Developed by" label', 'meacodes-accessibility-tools'); ?></label>
                      <p class="meaAccessibility_description"><?php esc_html_e('Please turn the Developed by label on to support us and help the project move forward. ', 'meacodes-accessibility-tools'); ?></p>
                      <p class="meaAccessibility_description"><?php esc_html_e('You can also buy us a coffee on the', 'meacodes-accessibility-tools'); ?> <a href="<?php echo esc_url('https://nowpayments.io/donation/meacodes'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Donation page.', 'meacodes-accessibility-tools'); ?></a>
                      <?php esc_html_e('Thanks for your supports. ', 'meacodes-accessibility-tools'); ?> &#x1F496; </p>
                    </td>
                  </tr>
        
                </table>
              </div>
            </div>
            <script>
              jQuery(document).ready(function($) {
                $('#reset_settings').click(function() {
                  $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                      action: 'reset_settings_action'
                    },
                    success: function(response) {
                      location.reload();
                    }
                  });
                });
              });
            </script>
        </div>
        <!-- Tab 2 - Features -->
        <div class="meaAccessibility_tab-pane">
          <h1><?php esc_html_e('Features', 'meacodes-accessibility-tools'); ?></h1>
          <p><?php esc_html_e('The Accessibility plugin provides a set of tools and features to create an easier and more inclusive user experience for users with various needs. You can enable or disable each of these features individually.', 'meacodes-accessibility-tools'); ?>
          <div class="meaAccessibility_table-column">
            <table class="form-table">
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Font Size Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_font_size_Fe" name="meaAccessibility_font_size_Fe" value="1" <?php checked(get_option('meaAccessibility_font_size_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Line Height Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_line_height_Fe" name="meaAccessibility_line_height_Fe" value="1" <?php checked(get_option('meaAccessibility_line_height_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Letter Spacing Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_letter_spacing_Fe" name="meaAccessibility_letter_spacing_Fe" value="1" <?php checked(get_option('meaAccessibility_letter_spacing_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Dyslexia Mask Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_dyslexia_mask_Fe" name="meaAccessibility_dyslexia_mask_Fe" value="1" <?php checked(get_option('meaAccessibility_dyslexia_mask_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Grayscale Page Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_grayscale_page_Fe" name="meaAccessibility_grayscale_page_Fe" value="1" <?php checked(get_option('meaAccessibility_grayscale_page_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Contrast Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_contrast_Fe" name="meaAccessibility_contrast_Fe" value="1" <?php checked(get_option('meaAccessibility_contrast_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Negative Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_negativ_Fe" name="meaAccessibility_negativ_Fe" value="1" <?php checked(get_option('meaAccessibility_negativ_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Underlined Links Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_underlined_links_Fe" name="meaAccessibility_underlined_links_Fe" value="1" <?php checked(get_option('meaAccessibility_underlined_links_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Highlight Links Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_highlight_links_Fe" name="meaAccessibility_highlight_links_Fe" value="1" <?php checked(get_option('meaAccessibility_highlight_links_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Grayscale Images Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_grayscale_images_Fe" name="meaAccessibility_grayscale_images_Fe" value="1" <?php checked(get_option('meaAccessibility_grayscale_images_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Black and white Feature:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                  <label class="meaAccessibility_toggle-switch">
                    <input type="checkbox" id="meaAccessibility_black_white_Fe" name="meaAccessibility_black_white_Fe" value="1" <?php checked(get_option('meaAccessibility_black_white_Fe', true)); ?>>
                    <span class="meaAccessibility_slider"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <!-- Tab 3 - Style -->
        <div class="meaAccessibility_tab-pane">
          <h1><?php esc_html_e('Style Settings', 'meacodes-accessibility-tools'); ?></h1>
          <p><?php  esc_html_e('Customize the plugins appearance to match your taste and needs using the style settings.', 'meacodes-accessibility-tools'); ?></p>
          <div class="meaAccessibility_table-column">
            <table class="form-table meaAccessibility_style-tooltips-fa">
            <tr valign="top">
              <th scope="row"><?php esc_html_e('Plugin Button Size:', 'meacodes-accessibility-tools'); ?></th>
              <td>
                <input type="range" id="meaAccessibility_button_size" name="meaAccessibility_button_size" min="24" max="68" value="<?php echo esc_attr(get_option('meaAccessibility_button_size', 50)); ?>" class="meaAccessibility_range_slider">
                <span class="meaAccessibility_range_value"><?php echo esc_html(get_option('meaAccessibility_button_size', 50)); ?>px</span>
              </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php esc_html_e('Plugin Button Border Radius:', 'meacodes-accessibility-tools'); ?></th>
              <td>
                <input type="range" id="meaAccessibility_button_border_radius" name="meaAccessibility_button_border_radius" min="0" max="50" value="<?php echo esc_attr(get_option('meaAccessibility_button_border_radius', 30)); ?>" class="meaAccessibility_range_slider">
                <span class="meaAccessibility_range_value"><?php echo esc_html(get_option('meaAccessibility_button_border_radius', 30)); ?>%</span>
              </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php esc_html_e('Plugin Button Margin:', 'meacodes-accessibility-tools'); ?></th>
              <td>
                <input type="number" id="meaAccessibility_button_margin" name="meaAccessibility_button_margin" min="0" max="50" value="<?php echo esc_attr(get_option('meaAccessibility_button_margin', 20)); ?>" class="meaAccessibility_number_input">
                <span class="meaAccessibility_input_suffix">px</span>
              </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php esc_html_e('Plugin Button Icon Size:', 'meacodes-accessibility-tools'); ?></th>
              <td>
                <input type="range" id="meaAccessibility_button_icon_size" name="meaAccessibility_button_icon_size" min="16" max="58" value="<?php echo esc_attr(get_option('meaAccessibility_button_icon_size', 35)); ?>" class="meaAccessibility_range_slider">
                <span class="meaAccessibility_range_value"><?php echo esc_html(get_option('meaAccessibility_button_icon_size', 35)); ?>px</span>
              </td>
            </tr>
            <tr valign="top">
              <th scope="row"><?php esc_html_e('Positionable by User:', 'meacodes-accessibility-tools'); ?></th>
              <td>
                <label class="meaAccessibility_toggle-switch">
                  <input type="checkbox" id="meaAccessibility_enable_movable_plugin" name="meaAccessibility_enable_movable_plugin" value="1" <?php checked(get_option('meaAccessibility_enable_movable_plugin', false)); ?>>
                  <span class="meaAccessibility_slider"></span>
                </label>
              </td>
              <th class="meaAccessibility_tooltip-trigger">
                  <div class="meaAccessibility_tooltip"><?php esc_html_e('Enabling this option allows users to freely move the accessibility plugin around the page on desktop devices. Please note that this feature is not available on mobile devices.', 'meacodes-accessibility-tools'); ?></div>
                </th>
            </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Plugin Position:', 'meacodes-accessibility-tools'); ?></th>
                <td>
                <select name="meaAccessibility_selected_position">
                  <?php
                    $meaAccessibility_positions = array(
                    'meaAccessibility_widgetBottomLeft' => esc_html__('Bottom Left Corner', 'meacodes-accessibility-tools'),
                    'meaAccessibility_widgetBottomRight' => esc_html__('Bottom Right Corner', 'meacodes-accessibility-tools'),
                    'meaAccessibility_widgetTopLeft' => esc_html__('Top Left Corner', 'meacodes-accessibility-tools'),
                    'meaAccessibility_widgetTopRight' => esc_html__('Top Right Corner', 'meacodes-accessibility-tools'),
                    );
                    $meaAccessibility_selected_position = get_option('meaAccessibility_selected_position');
                    foreach ($meaAccessibility_positions as $value => $label) {
                      echo sprintf(
                        "<option value='%s' %s>%s</option>",
                        esc_attr($value),
                        selected($meaAccessibility_selected_position, $value, false),
                        esc_html($label)
                      );
                    }
                  ?>
                </select>
                </td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Background Color: ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="meaAccessibility_background_color" name="meaAccessibility_background_color" value="<?php echo esc_attr($meaAccessibility_background_color_Obj); ?>"></td>
                <th class="meaAccessibility_tooltip-trigger">
                  <div class="meaAccessibility_tooltip"><?php esc_html_e('Background color of plugin and logo border.', 'meacodes-accessibility-tools'); ?></div>
                </th>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Labels Color: ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="meaAccessibility_labels_color" name="meaAccessibility_labels_color" value="<?php echo esc_attr($meaAccessibility_labels_color_Obj); ?>"></td>
                <th class="meaAccessibility_tooltip-trigger">
                  <div class="meaAccessibility_tooltip"><?php esc_html_e('Color of the labels or name of each feature and Plugin name to.', 'meacodes-accessibility-tools'); ?></div>
                </th>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Divider Line Color: ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="header‌Brd_meaAcc" name="meaAccessibility_divider_line_color" value="<?php echo esc_attr($meaAccessibility_divider_line_color_Obj); ?>"></td>
                <th class="meaAccessibility_tooltip-trigger">
                  <div class="meaAccessibility_tooltip"><?php esc_html_e('Color of plugin header & features section divider.', 'meacodes-accessibility-tools'); ?></div>
                </th>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Plugin button Color: ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="meaAccessibility_plugin_logo_color" name="meaAccessibility_plugin_logo_color" value="<?php echo esc_attr($meaAccessibility_plugin_logo_color_Obj); ?>"></td>
                  <th class="meaAccessibility_tooltip-trigger">
                    <div class="meaAccessibility_tooltip"><?php esc_html_e('Color Scheme for Plugin Logo.', 'meacodes-accessibility-tools'); ?></div>
                  </th>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Accent Color: ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="mainColor_meaaAc" name="meaAccessibility_accent_color" value="<?php echo esc_attr($meaAccessibility_accent_color); ?>"></td>
                <th class="meaAccessibility_tooltip-trigger">
                  <div class="meaAccessibility_tooltip">
                    <?php esc_html_e('Color scheme for:', 'meacodes-accessibility-tools'); ?>                         
                    <ul>
                      <li><?php esc_html_e('Active features and their toggle buttons on hover.', 'meacodes-accessibility-tools'); ?></li>
                      <li><?php esc_html_e('Dyslexia reading mask bars', 'meacodes-accessibility-tools'); ?></li>
                    </ul>                   
                  </div>
                </th>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('‌Buttons Color (Reset/Close):', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="meaAccessibility_buttons_color" name="meaAccessibility_buttons_color" value="<?php echo esc_attr($meaAccessibility_buttons_color_Obj); ?>"></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php esc_html_e('Buttons Hover Color (Reset/Close): ', 'meacodes-accessibility-tools'); ?></th>
                <td><input type="color" id="meaAccessibility_buttons_hover_color" name="meaAccessibility_buttons_hover_color" value="<?php echo esc_attr($meaAccessibility_buttons_hover_color); ?>"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="meaAccessibility_admin-submit">
          <?php submit_button(); ?>
          <button type="button" id="reset_settings" class="button button-secondary" style="margin-right: 20px; margin-left: 20px; margin-top: 5px;"><?php esc_html_e('Reset settings', 'meacodes-accessibility-tools'); ?></button>
        </div>            
      </form>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.meaAccessibility_nav-tab');
        const tabContents = document.querySelectorAll('.meaAccessibility_tab-pane');
        tabs.forEach((tab, index) => {
          tab.addEventListener('click', function (event) {
            event.preventDefault();
            tabs.forEach((t) => t.classList.remove('meaAccessibility_nav-tab-active'));
            tab.classList.add('meaAccessibility_nav-tab-active');      
            tabContents.forEach((content) => content.classList.remove('meaAccessibility_active'));
            tabContents[index].classList.add('meaAccessibility_active');
          });
        });
      });
      
      // Range slider value updates
      jQuery('.meaAccessibility_range_slider').on('input', function() {
        var value = jQuery(this).val();
        var suffix = jQuery(this).attr('name') === 'meaAccessibility_button_border_radius' ? '%' : 'px';
        jQuery(this).siblings('.meaAccessibility_range_value').text(value + suffix);
      });
    </script>
  </div>
  <div class="meaAccessibility_admin-copyright">
    <a href="https://www.meacodes.com" target="_blank"><img src="<?php echo esc_attr($meaAccessibility_admin_copyright); ?>"></a>
    <p><a href="https://www.meacodes.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Meacodes Development Solutions', 'meacodes-accessibility-tools'); ?></a></p>
  </div>
  <div class="meaAccessibility_plugin_version"><p><?php esc_html_e('Accessibility Tools Version: ', 'meacodes-accessibility-tools'); ?><?php echo esc_html(meaAccessibility_PLUGIN_VERSION); ?></p></div>
<?php
}