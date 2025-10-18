<?php 
// Settings Page
function meaAccessibility_admin_thm() {
  if (!current_user_can('manage_options')) {
    return;
  }
  if ((isset($_POST['meaAccessibility_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['meaAccessibility_settings_nonce'])), 'meaAccessibility_settings_nonce')) || 
      (isset($_POST['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'meaAccessibility_settings_group'))) {
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
    
    // Process all other settings
    $status_plugin = isset($_POST['meaAccessibility_status_plugin']) ? 1 : 0;
    $header_text = isset($_POST['meaAccessibility_header_text']) ? sanitize_text_field(wp_unslash($_POST['meaAccessibility_header_text'])) : '';
    $privacy_notice = isset($_POST['meaAccessibility_privacy_notice_Fe']) ? 1 : 0;
    $copyright_text = isset($_POST['meaAccessibility_copyright_text']) ? 1 : 0;
    $labels_color = isset($_POST['meaAccessibility_labels_color']) ? sanitize_hex_color(wp_unslash($_POST['meaAccessibility_labels_color'])) : '';
    $enable_movable_plugin = isset($_POST['meaAccessibility_enable_movable_plugin']) ? 1 : 0;
    
    // Process all feature checkboxes
    $font_size_fe = isset($_POST['meaAccessibility_font_size_Fe']) ? 1 : 0;
    $line_height_fe = isset($_POST['meaAccessibility_line_height_Fe']) ? 1 : 0;
    $letter_spacing_fe = isset($_POST['meaAccessibility_letter_spacing_Fe']) ? 1 : 0;
    $dyslexia_mask_fe = isset($_POST['meaAccessibility_dyslexia_mask_Fe']) ? 1 : 0;
    $grayscale_page_fe = isset($_POST['meaAccessibility_grayscale_page_Fe']) ? 1 : 0;
    $contrast_fe = isset($_POST['meaAccessibility_contrast_Fe']) ? 1 : 0;
    $negativ_fe = isset($_POST['meaAccessibility_negativ_Fe']) ? 1 : 0;
    $underlined_links_fe = isset($_POST['meaAccessibility_underlined_links_Fe']) ? 1 : 0;
    $highlight_links_fe = isset($_POST['meaAccessibility_highlight_links_Fe']) ? 1 : 0;
    $grayscale_images_fe = isset($_POST['meaAccessibility_grayscale_images_Fe']) ? 1 : 0;
    $black_white_fe = isset($_POST['meaAccessibility_black_white_Fe']) ? 1 : 0;
    
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
    
    // Update all other settings
    update_option('meaAccessibility_status_plugin', $status_plugin);
    update_option('meaAccessibility_header_text', $header_text);
    update_option('meaAccessibility_privacy_notice_Fe', $privacy_notice);
    update_option('meaAccessibility_copyright_text', $copyright_text);
    update_option('meaAccessibility_labels_color', $labels_color);
    update_option('meaAccessibility_enable_movable_plugin', $enable_movable_plugin);
    
    // Update all feature settings
    update_option('meaAccessibility_font_size_Fe', $font_size_fe);
    update_option('meaAccessibility_line_height_Fe', $line_height_fe);
    update_option('meaAccessibility_letter_spacing_Fe', $letter_spacing_fe);
    update_option('meaAccessibility_dyslexia_mask_Fe', $dyslexia_mask_fe);
    update_option('meaAccessibility_grayscale_page_Fe', $grayscale_page_fe);
    update_option('meaAccessibility_contrast_Fe', $contrast_fe);
    update_option('meaAccessibility_negativ_Fe', $negativ_fe);
    update_option('meaAccessibility_underlined_links_Fe', $underlined_links_fe);
    update_option('meaAccessibility_highlight_links_Fe', $highlight_links_fe);
    update_option('meaAccessibility_grayscale_images_Fe', $grayscale_images_fe);
    update_option('meaAccessibility_black_white_Fe', $black_white_fe);
    wp_safe_redirect(admin_url('admin.php?page=meaAccessibility_settings_page'));
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
      <a href="#" class="meaAccessibility_nav-tab"><?php esc_html_e('Scan', 'meacodes-accessibility-tools'); ?></a>
    </h1>
    
    <!-- Attention Banner (Cache notice) -->
    <div class="meaAccessibility_attention_banner" role="status" aria-live="polite">
      <div class="meaAccessibility_attention_content">
        <span class="meaAccessibility_attention_icon">⚠️</span>
        <span class="meaAccessibility_attention_text">
          <strong><?php esc_html_e('Attention', 'meacodes-accessibility-tools'); ?></strong>
          <?php esc_html_e('We updated the plugin button logic to enable more customization. If after updating it does not work on your site, this is likely a cache issue. Please clear your server and browser cache, then refresh the page.', 'meacodes-accessibility-tools'); ?>
        </span>
        <button type="button" id="meaAccessibility_attention_close" class="meaAccessibility_attention_close" aria-label="<?php esc_attr_e('Close notice', 'meacodes-accessibility-tools'); ?>">
          <span>×</span>
        </button>
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
                      <input type="checkbox" id="meaAccessibility_copyright_text" name="meaAccessibility_copyright_text" value="1" <?php checked(get_option('meaAccessibility_copyright_text', true)); ?>>
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
              document.addEventListener('DOMContentLoaded', function() {
                const resetButton = document.getElementById('reset_settings');
                if (resetButton) {
                  resetButton.addEventListener('click', function() {
                    fetch(ajaxurl, {
                      method: 'POST',
                      headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                      },
                      body: 'action=meaAccessibility_reset_settings&nonce=<?php echo esc_js(wp_create_nonce('meaAccessibility_reset_nonce')); ?>'
                    })
                    .then(response => response.json())
                    .then(data => {
                      location.reload();
                    })
                    .catch(error => {
                      console.error('Error:', error);
                    });
                  });
                }
              });
      
      // Attention Banner functionality
      document.addEventListener('DOMContentLoaded', function() {
        // Check if notice was closed before
        const noticeClosed = localStorage.getItem('meaAccessibility_attention_closed');
        const attentionBanner = document.querySelector('.meaAccessibility_attention_banner');
        const closeBtn = document.getElementById('meaAccessibility_attention_close');
        
        if (attentionBanner && noticeClosed) {
          attentionBanner.style.display = 'none';
        }
        
        if (closeBtn) {
          closeBtn.addEventListener('click', function() {
            if (attentionBanner) {
              attentionBanner.style.display = 'none';
              localStorage.setItem('meaAccessibility_attention_closed', 'true');
            }
          });
        }
      });
      
      // Manual Scan functionality
      document.addEventListener('DOMContentLoaded', function() {
        const runScanBtn = document.getElementById('run-manual-scan');
        const scanResults = document.getElementById('scan-results');
        
        if (runScanBtn) {
          runScanBtn.addEventListener('click', function() {
            const button = this;
            const originalText = button.textContent;
            
            button.disabled = true;
            button.textContent = '<?php echo esc_js(__('scanning please wait...', 'meacodes-accessibility-tools')); ?>';
            button.style.backgroundColor = '#f8f9fa';
            button.style.color = '#495057';
            button.style.borderColor = '#dee2e6';
            
            // Create AJAX request
            const formData = new FormData();
            formData.append('action', 'meacodes_run_manual_scan');
            formData.append('nonce', '<?php echo esc_js(wp_create_nonce('meacodes_quickscan_nonce')); ?>');
            
            // Get the page limit from the input field
            const pageLimitInput = document.getElementById('scan-page-limit');
            if (pageLimitInput) {
              formData.append('max_pages', pageLimitInput.value);
            }
            
            fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                const summary = data.data || data;
                
                const totalIssues = (summary.a || 0) + (summary.aa || 0) + (summary.aaa || 0);
                const pagesScanned = summary.pages_scanned || 0;
                
                // Clear any previous messages
                scanResults.innerHTML = '';
                
                // Update the scan results display without page refresh
                const scanResultsDisplay = document.getElementById('scan-results-display');
                if (scanResultsDisplay && data.data) {
                  const summary = data.data;
                  let lastScanText = '<?php esc_js(__('Just now', 'meacodes-accessibility-tools')); ?>';
                  if (summary.last_run) {
                    try {
                      const lastScan = new Date(summary.last_run);
                      if (!isNaN(lastScan.getTime())) {
                        lastScanText = lastScan.toLocaleString();
                      }
                    } catch (e) {
                      lastScanText = summary.last_run;
                    }
                  }
                  
                  let pageDetailsHtml = '';
                  if (summary.page_details && summary.page_details.length > 0) {
                    const pagesWithIssues = summary.page_details.filter(page => (page.a || 0) + (page.aa || 0) + (page.aaa || 0) > 0);
                    
                    if (pagesWithIssues.length > 0) {
                      pageDetailsHtml = '<div class="page-details" style="margin-top: 20px;">';
                      pageDetailsHtml += '<div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; border: 1px solid #dee2e6;">';
                      pageDetailsHtml += '<h4 style="margin: 0 0 15px 0; color: #495057; font-size: 16px; display: flex; align-items: center;">';
                      pageDetailsHtml += '<span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; margin-right: 10px; font-size: 12px;">' + pagesWithIssues.length + '</span>';
                      pageDetailsHtml += '<?php echo esc_js(__('Pages with Issues', 'meacodes-accessibility-tools')); ?></h4>';
                      pageDetailsHtml += '<div style="max-height: 400px; overflow-y: auto;">';
                      
                      pagesWithIssues.forEach(function(page) {
                        const totalIssues = (page.a || 0) + (page.aa || 0) + (page.aaa || 0);
                        pageDetailsHtml += '<div style="margin-bottom: 15px; padding: 15px; border-radius: 6px; background: white; border-left: 4px solid #dc3545; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
                        pageDetailsHtml += '<div style="display: flex; flex-direction: column; gap: 1rem; justify-content: between; align-items: flex-start; margin-bottom: 10px;">';
                        pageDetailsHtml += '<div style="flex: 1;">';
                        pageDetailsHtml += '<h5 style="margin: 0 0 5px 0; color: #212529; font-size: 14px; font-weight: bold;">' + (page.title || 'Untitled') + '</h5>';
                        pageDetailsHtml += '<a href="' + page.url + '" target="_blank" style="color: #007cba; text-decoration: none; font-size: 12px;">' + page.url + '</a>';
                        pageDetailsHtml += '</div>';
                        pageDetailsHtml += '<div style="display: flex; gap: 8px; margin-left: 15px;">';
                        if (page.a > 0) pageDetailsHtml += '<span style="background: #ffc107; color: #212529; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">A: ' + page.a + '</span>';
                        if (page.aa > 0) pageDetailsHtml += '<span style="background: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">AA: ' + page.aa + '</span>';
                        if (page.aaa > 0) pageDetailsHtml += '<span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold;">AAA: ' + page.aaa + '</span>';
                        pageDetailsHtml += '</div></div>';
                        
                        if (page.issues && page.issues.length > 0) {
                          pageDetailsHtml += '<div style="background: #f8f9fa; padding: 10px; border-radius: 4px; margin-top: 10px;">';
                          pageDetailsHtml += '<strong style="color: #495057; font-size: 12px; display: block; margin-bottom: 8px;"><?php echo esc_js(__('Issues Found:', 'meacodes-accessibility-tools')); ?></strong>';
                          pageDetailsHtml += '<ul style="margin: 0; padding-left: 20px; font-size: 12px; color: #6c757d;">';
                          page.issues.forEach(function(issue) {
                            pageDetailsHtml += '<li style="margin-bottom: 4px;">' + issue + '</li>';
                          });
                          pageDetailsHtml += '</ul></div>';
                        }
                        pageDetailsHtml += '</div>';
                      });
                      
                      pageDetailsHtml += '</div></div></div>';
                    }
                  }
                  
                  scanResultsDisplay.innerHTML = 
                    '<div class="scan-summary" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; margin: 15px 0; border: 1px solid #dee2e6;">' +
                    '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">' +
                    '<h3 style="margin: 0; color: #495057; font-size: 18px;"><?php echo esc_js(__('Scan Results', 'meacodes-accessibility-tools')); ?></h3>' +
                     '<span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;"><?php echo esc_js(__('Completed', 'meacodes-accessibility-tools')); ?></span>' +
                    '</div>' +
                    '<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">' +
                    '<div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #007cba;">' +
                    '<strong style="color: #007cba; display: block; margin-bottom: 5px;"><?php echo esc_js(__('Last Scan', 'meacodes-accessibility-tools')); ?></strong>' +
                    '<span style="color: #6c757d; font-size: 14px;">' + lastScanText + '</span>' +
                    '</div>' +
                    '<div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #6f42c1;">' +
                    '<strong style="color: #6f42c1; display: block; margin-bottom: 5px;"><?php echo esc_js(__('Pages Scanned', 'meacodes-accessibility-tools')); ?></strong>' +
                    '<span style="color: #6c757d; font-size: 14px;">' + (summary.pages_scanned || 0) + ' <?php echo esc_js(__('pages', 'meacodes-accessibility-tools')); ?> (' + (summary.duration_seconds || 0) + 's)</span>' +
                    '</div>' +
                    '</div>' +
                    '<div style="background: white; padding: 15px; border-radius: 6px; border-left: 4px solid #dc3545;">' +
                    '<strong style="color: #dc3545; display: block; margin-bottom: 10px;"><?php echo esc_js(__('Accessibility Issues Found', 'meacodes-accessibility-tools')); ?></strong>' +
                    '<div style="display: flex; gap: 20px; flex-wrap: wrap;">' +
                    '<span style="background: #ffc107; color: #212529; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 14px;">A: ' + (summary.a || 0) + '</span>' +
                    '<span style="background: #fd7e14; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 14px;">AA: ' + (summary.aa || 0) + '</span>' +
                    '<span style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; font-weight: bold; font-size: 14px;">AAA: ' + (summary.aaa || 0) + '</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' + pageDetailsHtml;
                }
              } else {
                scanResults.innerHTML = '<div class="notice notice-error"><p>' + (data.data || '<?php esc_js(__('Scan failed. Please try again.', 'meacodes-accessibility-tools')); ?>') + '</p></div>';
              }
            })
            .catch(error => {
              scanResults.innerHTML = '<div class="notice notice-error"><p><?php esc_js(__('Scan failed. Please try again.', 'meacodes-accessibility-tools')); ?></p></div>';
            })
            .finally(() => {
              button.disabled = false;
              button.textContent = originalText;
              button.style.backgroundColor = '';
              button.style.color = '';
              button.style.borderColor = '';
                  });
                });
        }
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
                  <input type="checkbox" id="meaAccessibility_enable_movable_plugin" name="meaAccessibility_enable_movable_plugin" value="1" <?php checked(get_option('meaAccessibility_enable_movable_plugin', true)); ?>>
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
        
        <!-- Tab 4 - Scan -->
        <div class="meaAccessibility_tab-pane">
          <h1><?php esc_html_e('Accessibility Quick Scan', 'meacodes-accessibility-tools'); ?></h1>
          <p><?php esc_html_e('Scan your website for accessibility issues manually.', 'meacodes-accessibility-tools'); ?></p>
          
          <div style="background: linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%); border-radius: 8px; padding: 20px; border: 1px solid #c3e6cb; margin-bottom: 20px;">
            <h3 style="margin: 0 0 15px 0; color: #155724; font-size: 18px;">🔍 <?php esc_html_e('Manual Accessibility Scan', 'meacodes-accessibility-tools'); ?></h3>
            <p style="margin: 0 0 15px 0; color: #155724; font-size: 14px;">
              <?php esc_html_e('Click the button below to scan your website for accessibility issues. This will check your pages for common accessibility problems.', 'meacodes-accessibility-tools'); ?>
            </p>
            
            <div style="margin-bottom: 15px;">
              <label for="scan-page-limit" style="display: block; margin-bottom: 5px; color: #155724; font-weight: 600; font-size: 14px;">
                <?php esc_html_e('Maximum Pages to Scan:', 'meacodes-accessibility-tools'); ?>
              </label>
              <input type="number" id="scan-page-limit" name="meacodes_quickscan_max_pages" value="<?php echo esc_attr(get_option('meacodes_quickscan_max_pages', 35)); ?>" min="1" max="35" style="width: 80px; padding: 5px 8px; border: 1px solid #c3e6cb; border-radius: 4px; font-size: 14px;" />
              <span style="margin-left: 8px; color: #155724; font-size: 13px;">
                <?php esc_html_e('(1-35 pages)', 'meacodes-accessibility-tools'); ?>
              </span>
            </div>
            
            <button type="button" id="run-manual-scan" class="button button-primary" style="margin-bottom: 15px;">
              <?php esc_html_e('Run Accessibility Scan Now', 'meacodes-accessibility-tools'); ?>
            </button>
            
            <div id="scan-results" style="margin-top: 20px;"></div>
          </div>
          
          <hr />
          
          <h2><?php esc_html_e('Last Scan Results', 'meacodes-accessibility-tools'); ?></h2>
          <div id="scan-results-display">
            <?php
            $summary = get_transient('meacodes_quickscan_summary');
            if ($summary) {
              $last_scan = new DateTime($summary['last_run']);
              $last_scan->setTimezone(new DateTimeZone(wp_timezone_string()));
              $last_scan_text = $last_scan->format('Y-m-d H:i T');
              $total_issues = $summary['a'] + $summary['aa'] + $summary['aaa'];
              
              echo '<div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; border: 1px solid #dee2e6; margin-bottom: 20px;">';
              echo '<h3 style="margin: 0 0 15px 0; color: #495057; font-size: 16px;">📊 ' . esc_html__('Scan Results', 'meacodes-accessibility-tools') . '</h3>';
              echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">';
              
              // Last Scan
              echo '<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #dee2e6;">';
              echo '<div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">' . esc_html__('Last Scan', 'meacodes-accessibility-tools') . '</div>';
              echo '<div style="color: #495057; font-weight: 600; font-size: 14px;">' . esc_html($last_scan_text) . '</div>';
              echo '</div>';
              
              // Pages Scanned
              echo '<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #dee2e6;">';
              echo '<div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">' . esc_html__('Pages Scanned', 'meacodes-accessibility-tools') . '</div>';
              echo '<div style="color: #495057; font-weight: 600; font-size: 14px;">' . esc_html($summary['pages_scanned']) . ' pages (' . esc_html($summary['duration_seconds']) . 's)</div>';
              echo '</div>';
              
              // Accessibility Issues
              echo '<div style="background: white; padding: 15px; border-radius: 6px; border: 1px solid #dee2e6;">';
              echo '<div style="color: #6c757d; font-size: 12px; margin-bottom: 5px;">' . esc_html__('Accessibility Issues Found', 'meacodes-accessibility-tools') . '</div>';
              echo '<div style="display: flex; gap: 10px; align-items: center;">';
              echo '<span style="background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">A: ' . esc_html($summary['a']) . '</span>';
              echo '<span style="background: #fd7e14; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">AA: ' . esc_html($summary['aa']) . '</span>';
              echo '<span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">AAA: ' . esc_html($summary['aaa']) . '</span>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              
              // Pages with Issues
              if (!empty($summary['page_details'])) {
                echo '<div style="margin-top: 15px;">';
                echo '<h4 style="margin: 0 0 10px 0; color: #495057; font-size: 14px;">' . esc_html__('Pages with Issues', 'meacodes-accessibility-tools') . ' (' . count($summary['page_details']) . ')</h4>';
                echo '<div style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 6px;">';
                
                foreach ($summary['page_details'] as $page) {
                  $page_issues = $page['a'] + $page['aa'] + $page['aaa'];
                  if ($page_issues > 0) {
                    echo '<div style="padding: 10px; border-bottom: 1px solid #dee2e6; background: white;">';
                    echo '<div style="font-weight: 600; color: #495057; margin-bottom: 5px;">' . esc_html($page['title']) . '</div>';
                    echo '<div style="font-size: 12px; color: #6c757d; margin-bottom: 5px;">' . esc_html($page['url']) . '</div>';
                    echo '<div style="display: flex; gap: 5px; align-items: center;">';
                    if ($page['a'] > 0) echo '<span style="background: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">A: ' . esc_html($page['a']) . '</span>';
                    if ($page['aa'] > 0) echo '<span style="background: #fd7e14; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">AA: ' . esc_html($page['aa']) . '</span>';
                    if ($page['aaa'] > 0) echo '<span style="background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">AAA: ' . esc_html($page['aaa']) . '</span>';
                    echo '</div>';
                    echo '</div>';
                  }
                }
                
                echo '</div>';
                echo '</div>';
              }
              
              echo '</div>';
            } else {
              echo '<div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; border: 1px solid #dee2e6; text-align: center;">';
              echo '<p style="margin: 0; color: #6c757d; font-size: 14px;">No scan results available. Run a scan to see accessibility issues.</p>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
        
        <!-- Save and Reset Buttons -->
        <div class="meaAccessibility_admin-buttons" style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
          <div style="display: flex; gap: 15px; justify-content: center;">
            <button type="submit" name="submit" class="button button-primary" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; color: white; padding: 12px 30px; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);">
              <span style="margin-right: 8px;">💾</span>
              <?php esc_html_e('Save Changes', 'meacodes-accessibility-tools'); ?>
            </button>
            
            <button type="button" id="reset_settings" class="button button-secondary" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; color: white; padding: 12px 30px; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);">
              <span style="margin-right: 8px;">🔄</span>
              <?php esc_html_e('Reset Settings', 'meacodes-accessibility-tools'); ?>
            </button>
          </div>
          <p style="text-align: center; margin-top: 15px; color: #6c757d; font-size: 14px;">
            <?php esc_html_e('Save Changes will save all settings across all tabs. Reset Settings will restore all options to their default values.', 'meacodes-accessibility-tools'); ?>
          </p>
        </div>            
      </form>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Handle URL parameters and hash for tab switching
        const urlParams = new URLSearchParams(window.location.search);
        const tabParam = urlParams.get('tab');
        const hash = window.location.hash;
        
        if (tabParam === 'scan' || hash === '#scan-results-display') {
          // Switch to scan tab (4th tab, index 3)
          const tabs = document.querySelectorAll('.meaAccessibility_nav-tab');
          const tabContents = document.querySelectorAll('.meaAccessibility_tab-pane');
          
          if (tabs.length >= 4) {
            // Remove active class from all tabs
            tabs.forEach(tab => {
              tab.classList.remove('meaAccessibility_nav-tab-active');
            });
            // Add active class to scan tab (4th tab)
            tabs[3].classList.add('meaAccessibility_nav-tab-active');
            
            // Hide all tab panes
            tabContents.forEach(pane => {
              pane.style.display = 'none';
            });
            // Show scan tab pane (4th pane)
            if (tabContents[3]) {
              tabContents[3].style.display = 'block';
            }
            
            // Scroll to results after tab switch
            setTimeout(function() {
              const resultsElement = document.getElementById('scan-results-display');
              if (resultsElement) {
                resultsElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
              }
            }, 100);
          }
        }
        
        const tabs = document.querySelectorAll('.meaAccessibility_nav-tab');
        const tabContents = document.querySelectorAll('.meaAccessibility_tab-pane');
        
        // Debug code removed for production
        
        tabs.forEach((tab, index) => {
          tab.addEventListener('click', function (event) {
            event.preventDefault();
            // Debug code removed for production
            
            // Remove active class from all tabs
            tabs.forEach((t) => t.classList.remove('meaAccessibility_nav-tab-active'));
            tab.classList.add('meaAccessibility_nav-tab-active');      
            
            // Hide all tab contents
            tabContents.forEach((content) => content.classList.remove('meaAccessibility_active'));
            
            // Show the selected tab content
            if (tabContents[index]) {
            tabContents[index].classList.add('meaAccessibility_active');
              // Debug code removed for production
            } else {
              // Debug code removed for production
            }
          });
        });
      });
      
      // Range slider value updates
      document.querySelectorAll('.meaAccessibility_range_slider').forEach(function(slider) {
        slider.addEventListener('input', function() {
          var value = this.value;
          var suffix = this.getAttribute('name') === 'meaAccessibility_button_border_radius' ? '%' : 'px';
          var valueDisplay = this.parentNode.querySelector('.meaAccessibility_range_value');
          if (valueDisplay) {
            valueDisplay.textContent = value + suffix;
          }
        });
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