<?php 
// Settings Page
function meaAccessibility_admin_thm() {
  if (!current_user_can('manage_options')) {
    return;
  }
  if (isset($_POST['meaAccessibility_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['meaAccessibility_settings_nonce'])), 'meaAccessibility_settings_nonce')) {
    update_option('meaAccessibility_selected_position', sanitize_text_field($_POST['meaAccessibility_selected_position']));
    update_option('meaAccessibility_background_color', sanitize_hex_color($_POST['meaAccessibility_background_color']));
    update_option('meaAccessibility_divider_line_color', sanitize_hex_color($_POST['meaAccessibility_divider_line_color']));
    update_option('meaAccessibility_plugin_logo_color', sanitize_hex_color($_POST['meaAccessibility_plugin_logo_color']));
    update_option('meaAccessibility_accent_color', sanitize_hex_color($_POST['meaAccessibility_accent_color']));
    update_option('meaAccessibility_buttons_hover_color', sanitize_hex_color($_POST['meaAccessibility_buttons_hover_color']));
    update_option('meaAccessibility_buttons_color', sanitize_hex_color($_POST['meaAccessibility_buttons_color']));
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
                      <label for="meaAccessibility_copyright_text"><?php esc_html_e('Enable Developed by label', 'meacodes-accessibility-tools'); ?></label>
                      <p class="meaAccessibility_description"><?php esc_html_e('Please turn the Developed by label on to support us and help the project move forward. ', 'meacodes-accessibility-tools'); ?></p>
                      <p class="meaAccessibility_description"><?php esc_html_e('You can also buy us a coffee on the', 'meacodes-accessibility-tools'); ?> <a href="admin.php?page=mea-settings-donation"><?php esc_html_e('Donation page.', 'meacodes-accessibility-tools'); ?></a>
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
          <p><?php esc_html_e('To find out which plugin features are used to solve which accessibility issues for your site, you can refer to the ', 'meacodes-accessibility-tools'); ?> <a href="admin.php?page=mea-settings-help"><?php esc_html_e('help section.', 'meacodes-accessibility-tools'); ?></a></p>
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
          <p><?php  esc_html_e('Customize the plugins appearance to match your taste and needs using the style settings. For more information on each appearance variable, refer to the', 'meacodes-accessibility-tools'); ?> <a href="admin.php?page=mea-settings-help"><?php esc_html_e('help section.', 'meacodes-accessibility-tools'); ?></a></p>
          <div class="meaAccessibility_table-column">
            <table class="form-table meaAccessibility_style-tooltips-fa">
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
                <th scope="row"><?php esc_html_e('Plugin Logo Color: ', 'meacodes-accessibility-tools'); ?></th>
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
    </script>
  </div>
  <div class="meaAccessibility_plugin_version"><p><?php esc_html_e('Accessibility Tools Version: ', 'meacodes-accessibility-tools'); ?><?php echo esc_html(meaAccessibility_PLUGIN_VERSION); ?></p></div>
  <div class="meaAccessibility_admin-copyright">
    <p><?php esc_html_e('Developed by', 'meacodes-accessibility-tools'); ?></p>
    <a href="https://www.meacodes.com" target="_blank"><img src="<?php echo esc_attr($meaAccessibility_admin_copyright); ?>"></a>
  </div>
<?php
}  
// Help Page
function meaAccessibility_help_page() {
  $meaAccessibility_admin_copyright = esc_url(plugins_url('admin/img/mealogo.png', dirname(__FILE__)));
  ?>
  <div class="wrap meaAccessibility_help-page">
      <h1 class="wp-heading-inline" style="color: #207f97 !important;"><?php esc_html_e('Meacodes Accessibility Tools Help', 'meacodes-accessibility-tools'); ?></h1>
      <div class="meaAccessibility_help-section">
          <h2><?php esc_html_e('Introduction', 'meacodes-accessibility-tools'); ?></h2>
          <p><?php esc_html_e('Welcome to the Meacodes Accessibility Tools! Elevate the accessibility of your WordPress site effortlessly with a range of features designed for an inclusive online experience.', 'meacodes-accessibility-tools'); ?></p>
      </div>
      <div class="meaAccessibility_help-section">
          <h2><?php esc_html_e('Features', 'meacodes-accessibility-tools'); ?></h2>
          <p><?php esc_html_e('Discover the powerful accessibility features that come with this plugin:', 'meacodes-accessibility-tools'); ?></p>
          <?php
          $meaAccessibility_features = array(
              esc_html__('Font Customization', 'meacodes-accessibility-tools') => array(
                  esc_html__('Font Size', 'meacodes-accessibility-tools') => esc_html__('Modify the size of text for improved readability.', 'meacodes-accessibility-tools'),
                  esc_html__('Line Height', 'meacodes-accessibility-tools') => esc_html__('Set the spacing between lines for enhanced legibility.', 'meacodes-accessibility-tools'),
                  esc_html__('Letter Spacing', 'meacodes-accessibility-tools') => esc_html__('Customize letter spacing for optimal text clarity.', 'meacodes-accessibility-tools'),
              ),
              esc_html__('Dyslexia-Friendly Options', 'meacodes-accessibility-tools') => array(
                  esc_html__('Dyslexia Mask', 'meacodes-accessibility-tools') => esc_html__('Apply a mask to minimize visual distractions.', 'meacodes-accessibility-tools'),
              ),
              esc_html__('Visual Adjustments', 'meacodes-accessibility-tools') => array(
                  esc_html__('Grayscale Page', 'meacodes-accessibility-tools') => esc_html__('Convert the page to grayscale for a simplified look.', 'meacodes-accessibility-tools'),
                  esc_html__('Contrast', 'meacodes-accessibility-tools') => esc_html__('Increase the contrast for better visibility.', 'meacodes-accessibility-tools'),
                  esc_html__('Negative', 'meacodes-accessibility-tools') => esc_html__('Invert colors for a unique viewing experience.', 'meacodes-accessibility-tools'),
              ),
              esc_html__('Link Styling', 'meacodes-accessibility-tools') => array(
                  esc_html__('Underlined Links', 'meacodes-accessibility-tools') => esc_html__('Add underlines to links for clarity.', 'meacodes-accessibility-tools'),
                  esc_html__('Highlight Links', 'meacodes-accessibility-tools') => esc_html__('Emphasize links to draw attention.', 'meacodes-accessibility-tools'),
              ),
              esc_html__('Image Presentation', 'meacodes-accessibility-tools') => array(
                  esc_html__('Grayscale Images', 'meacodes-accessibility-tools') => esc_html__('Convert images to grayscale.', 'meacodes-accessibility-tools'),
                  esc_html__('Black and White Page', 'meacodes-accessibility-tools') => esc_html__('Transform the entire page to black and white.', 'meacodes-accessibility-tools'),
              ),
          );
          foreach ($meaAccessibility_features as $meaAccessibility_feature => $meaAccessibility_subfeatures) {
              ?>
              <div class="meaAccessibility_feature">
                  <h3><?php echo esc_html($meaAccessibility_feature); ?></h3>
                  <p><?php echo esc_html__('Enhance the reading experience for users with dyslexia:', 'meacodes-accessibility-tools'); ?></p>
                  <ul>
                      <?php
                      foreach ($meaAccessibility_subfeatures as $meaAccessibility_subfeature => $meaAccessibility_description) {
                          ?>
                          <li><strong><?php echo esc_html($meaAccessibility_subfeature); ?>:</strong> <?php echo esc_html($meaAccessibility_description); ?></li>
                          <?php
                      }
                      ?>
                  </ul>
              </div>
              <?php
          }
          ?>
      </div>
      <div class="meaAccessibility_help-section">
          <h2><?php esc_html_e('How to Use', 'meacodes-accessibility-tools'); ?></h2>
          <p><?php esc_html_e('Unlock the full potential of the Accessibility Plugin in just a few simple steps:', 'meacodes-accessibility-tools'); ?></p>
          <ol>
              <li><?php esc_html_e('Navigate to the ', 'meacodes-accessibility-tools'); ?><strong><?php esc_html_e('Settings', 'meacodes-accessibility-tools'); ?></strong> <?php esc_html_e('menu in your WordPress dashboard.', 'meacodes-accessibility-tools'); ?></li>
              <li><?php esc_html_e('Click on', 'meacodes-accessibility-tools'); ?> <strong><?php esc_html_e('Mea Accessibility', 'meacodes-accessibility-tools'); ?></strong> <?php esc_html_e('to access the settings page.', 'meacodes-accessibility-tools'); ?></li>
              <li><?php esc_html_e('Explore each feature and customize settings according to your preferences.', 'meacodes-accessibility-tools'); ?></li>
              <li><?php esc_html_e('And click on ', 'meacodes-accessibility-tools'); ?><strong><?php esc_html_e('Save Changes.', 'meacodes-accessibility-tools'); ?></strong></li>
          </ol>
      </div>
      <div class="meaAccessibility_help-section">
          <h2><?php esc_html_e('Need Further Assistance?', 'meacodes-accessibility-tools'); ?></h2>
          <p><?php esc_html_e('A blue question mark icon ( ? ) is placed next to the settings sections that need further clarification. By hovering your mouse over it, more detailed instructions will be displayed to help you understand the settings better.', 'meacodes-accessibility-tools'); ?></p>
      </div>
      <div class="meaAccessibility_help-section">
          <h2><?php esc_html_e('Translation Notice', 'meacodes-accessibility-tools'); ?></h2>
          <p><?php esc_html_e('We strive to provide accurate translations for our plugin in multiple languages. However, due to the automated nature of the translation process, there may be instances of inaccuracies or errors in certain translations.', 'meacodes-accessibility-tools'); ?></p>
          <p><?php esc_html_e('Your feedback and contributions play a crucial role in improving translation quality and ensuring a better user experience for everyone. If you encounter any incorrect translations or have suggestions for improvement, we encourage you to get involved:', 'meacodes-accessibility-tools'); ?></p>
          <ul>
              <li><?php esc_html_e('Report any translation issues or inaccuracies you encounter.', 'meacodes-accessibility-tools'); ?></li>
              <li><?php esc_html_e('Contribute your own translations or corrections to help enhance the overall quality.', 'meacodes-accessibility-tools'); ?></li>
          </ul>
          <p><?php esc_html_e('Your participation not only benefits you but also the entire community of users who speak the same language.', 'meacodes-accessibility-tools'); ?></p>
          <p><?php esc_html_e('Thank you for helping us improve! You can send your .po files to us by use this email:', 'meacodes-accessibility-tools'); ?></p>
          <p>translation@meacodes.com</p>
      </div>
  </div>
  <div class="meaAccessibility_plugin_version"><p><?php esc_html_e('Accessibility Tools Version: ', 'meacodes-accessibility-tools'); ?><?php echo esc_html(meaAccessibility_PLUGIN_VERSION); ?></p></div>
  <div class="meaAccessibility_admin-copyright">
      <p><?php esc_html_e('Developed by', 'meacodes-accessibility-tools'); ?></p>
      <a href="https://www.meacodes.com" target="_blank"><img src="<?php echo esc_attr($meaAccessibility_admin_copyright); ?>"></a>
  </div>
  <?php
}

// Donation Page
function meaAccessibility_donation_page() {
  $meaAccessibility_admin_copyright = esc_url(plugins_url('admin/img/mealogo.png', dirname(__FILE__)));
  ?>
  <div class="wrap">
      <h1 style="color: #207f97 !important;"><?php esc_html_e('Donation', 'meacodes-accessibility-tools'); ?></h1>
      <p><?php esc_html_e('With your support, we can make the online world more inclusive for everyone.', 'meacodes-accessibility-tools'); ?></p>
      <p><?php esc_html_e('The Accessibility Plugin aims to create an easier and more inclusive online experience for everyone, especially users with disabilities. This plugin is available for free to everyone so that no one is deprived of its benefits.', 'meacodes-accessibility-tools'); ?></p>
      <h3><?php esc_html_e('By donating, you can help us:', 'meacodes-accessibility-tools'); ?></h3>
      <ul>
          <li><span style="font-weight:bold"><?php esc_html_e('Improve and develop the plugin: ', 'meacodes-accessibility-tools'); ?></span><?php esc_html_e('With your donations, we can add new features to the plugin and improve its performance', 'meacodes-accessibility-tools'); ?></li>
          <li><span style="font-weight:bold"><?php esc_html_e('Support and troubleshooting: ', 'meacodes-accessibility-tools'); ?></span><?php esc_html_e('With your support, we can continuously help users solve their problems and fix any bugs in the plugin', 'meacodes-accessibility-tools'); ?></li>
          <li><span style="font-weight:bold"><?php esc_html_e('Awareness and education: ', 'meacodes-accessibility-tools'); ?></span><?php esc_html_e('With your donations, we can raise awareness about web accessibility and provide the necessary training', 'meacodes-accessibility-tools'); ?></li>
      </ul>
      <h4><?php esc_html_e('Any amount, no matter how small, can help us along the way.', 'meacodes-accessibility-tools'); ?></h4>
      <h1 class="wp-heading-inline"><?php esc_html_e('Support Us', 'meacodes-accessibility-tools'); ?></h1>
      <div class="wrap meaAccessibility_donation-page">
          <div class="meaAccessibility_donation-container">
              <?php
              $meaAccessibility_bitcoin = esc_url(plugins_url('admin/img/btc.jpg', dirname(__FILE__)));
              $meaAccessibility_usdt = esc_url(plugins_url('admin/img/usdt.jpg', dirname(__FILE__)));
              $meaAccessibility_usdc = esc_url(plugins_url('admin/img/usdc.jpg', dirname(__FILE__)));
              $meaAccessibility_stripe = esc_url(plugins_url('admin/img/stripe.png', dirname(__FILE__)));
              $meaAccessibility_shaparak = esc_url(plugins_url('admin/img/shaparak.png', dirname(__FILE__)));
              $meaAccessibility_donation_options = array(
                  'Bitcoin (BTC)' => array(
                      'image' => $meaAccessibility_bitcoin,
                      'link' => 'https://link.trustwallet.com/send?coin=0&address=bc1qmjmspgfjulsye6d2km39ac97mq49asxlwkrfal',
                      'text' => esc_html__('donate us via Trust Wallet', 'meacodes-accessibility-tools'),
                      'description' => esc_html__('Your supports in Bitcoin is highly appreciated ', 'meacodes-accessibility-tools'),
                  ),
                  'USDT' => array(
                      'image' => $meaAccessibility_usdt,
                      'link' => 'https://link.trustwallet.com/send?coin=195&address=THoDjXh4ayxSibWgLZRMQM4GX6nTXRaCtU&token_id=TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t',
                      'text' => esc_html__('donate us via Trust Wallet', 'meacodes-accessibility-tools'),
                      'trc_20' => 'TRC20',
                      'description' => esc_html__('Contribute using USDT for a seamless donation process ', 'meacodes-accessibility-tools'),
                  ),
                  'USDC' => array(
                      'image' => $meaAccessibility_usdc,
                      'link' => 'https://link.trustwallet.com/send?coin=20000714&address=0x51b5507A859bF4eB8f5faBbfbc2026E4afed0a02&token_id=0x8AC76a51cc950d9822D68b83fE1Ad97B32Cd580d',
                      'text' => esc_html__('donate us via Trust Wallet', 'meacodes-accessibility-tools'),
                      'bep_20' => 'BEP20',
                      'description' => esc_html__('Your generosity in USDC is valuable to us. Thank you for supporting web accessibility! ', 'meacodes-accessibility-tools'),
                  ),
                  'Stripe' => array(
                      'image' => $meaAccessibility_stripe,
                      'link' => 'https://reymit.ir/meacodes-accessibility?int',
                      'text' => esc_html__('donate us with Stripe', 'meacodes-accessibility-tools'),
                      'description' => esc_html__('Support us securely through Stripe. Every contribution makes a positive impact! ', 'meacodes-accessibility-tools'),
                  ),
                  'شاپرک' => array(
                      'image' => $meaAccessibility_shaparak,
                      'link' => 'https://reymit.ir/meacodes-accessibility',
                      'text' => 'اهدا با کارت های عضو شبکه شتاب',
                      'description' => 'از اهدای شما از طریق شاپرک بسیار سپاسگزاریم ',
                  ),
              );
              foreach ($meaAccessibility_donation_options as $meaAccessibility_donation_option => $meaAccessibility_details) {
                  ?>
                  <div class="meaAccessibility_donation-option">
                      <h2><?php echo esc_html($meaAccessibility_donation_option); ?></h2>
                      <?php if (isset($meaAccessibility_details['trc_20'])) : ?>
                          <p class="meaAccessibility_description"><?php echo esc_html($meaAccessibility_details['trc_20']); ?></p>
                      <?php elseif (isset($meaAccessibility_details['bep_20'])) : ?>
                          <p class="meaAccessibility_description"><?php echo esc_html($meaAccessibility_details['bep_20']); ?></p>
                      <?php endif; ?>
                      <?php if (isset($meaAccessibility_details['image'])) : ?>
                          <a href="<?php echo esc_url($meaAccessibility_details['link']); ?>" target="_blank"><img src="<?php echo esc_url($meaAccessibility_details['image']); ?>"></a>
                      <?php endif; ?>
                      <p><a href="<?php echo esc_url($meaAccessibility_details['link']); ?>" target="_blank"><?php echo esc_html($meaAccessibility_details['text']); ?></a></p>
                      <p><?php echo esc_html($meaAccessibility_details['description']); ?> &#x2764;&#xfe0f; </p>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
  </div>
  <div class="meaAccessibility_plugin_version"><p><?php esc_html_e('Accessibility Tools Version: ', 'meacodes-accessibility-tools'); ?><?php echo esc_html(meaAccessibility_PLUGIN_VERSION); ?></p></div>
  <div class="meaAccessibility_admin-copyright">
      <p><?php esc_html_e('Developed by', 'meacodes-accessibility-tools'); ?></p>
      <a href="https://www.meacodes.com" target="_blank"><img src="<?php echo esc_attr($meaAccessibility_admin_copyright); ?>"></a>
  </div>
  <?php
}