<?php 
  function meaAccessibility_main_thm() {
    $meaAccessibility_accessibilityButtonText = sanitize_text_field(get_option('meaAccessibility_header_text', __('Accessibility', 'meacodes-accessibility-tools')));
    $meaAccessibility_GDPR = esc_url(plugins_url('/Default_blue/img/GDPR_ready.png', dirname(__FILE__)));
    ?>
    <?php if (get_option('meaAccessibility_status_plugin', true)) : ?>
    <div id="meacodes_accessibility_module">
      <div id="Dragit_meac" class="meaAccessibility_widget meaAccessibility_mainbg-admin  meaAccessibility_iconSizeS meaAccessibility_widgetBottomLeft meaAccessibility_widgetBottomRightSM meaCodesAccessibilityModule" style="display:none">
        <div id="meaAccessibility_widgetHeader_line" class="meaAccessibility_widgetHeader meaAccessibility_enable_border <?php echo get_option('meaAccessibility_enable_movable_plugin') ? 'meaAccessibility_dragable-box' : ''; ?>" style="font-size: 18px !important; line-height: 1.2 !important; letter-spacing: normal !important;" <?php echo get_option('meaAccessibility_enable_movable_plugin') ? 'title="' . esc_attr__('Drag and move the accessibility box', 'meacodes-accessibility-tools') . '"' : ''; ?>>
          <div id="meaAccessibility_tooltip" class="tooltip">
          <button type="button" class="meaAccessibility_propertiesToggle" aria-expanded="false" aria-controls="meaAccessibility_properties" title="<?php echo esc_attr__('Open/Close Accessibility Options', 'meacodes-accessibility-tools'); ?>"></button>
          </div>          
          <legend class="meaAccessibility_accessibility-text" style="font-size: 18px !important; line-height: 1.2 !important; letter-spacing: normal !important;"> <?php if ($meaAccessibility_accessibilityButtonText === 'Accessibility') { esc_html_e('Accessibility', 'meacodes-accessibility-tools'); } else { echo esc_html($meaAccessibility_accessibilityButtonText); } ?></legend>
          <?php if (get_option('meaAccessibility_privacy_notice_Fe', true)) : ?>
          <div class="meaAccessibility_GDPR_link" style="font-size: 18px !important; line-height: 0 !important; letter-spacing: normal !important;">
          <a href="#" id="gdprNoticeLink" class="meaAccessibility_GDPR_btn" title="<?php esc_html_e('Click to read GDPR Notice', 'meacodes-accessibility-tools'); ?>"><img src="<?php echo esc_attr($meaAccessibility_GDPR); ?>" alt=""></a>
          </div>
          <?php endif; ?>
        </div>
        <div id="meaAccessibility_properties" class="meaAccessibility_properties">
          <?php if (get_option('meaAccessibility_font_size_Fe', true)) : ?>
            <fieldset class="meaAccessibility_fontSizeField">
              <legend><?php esc_html_e('Font Size', 'meacodes-accessibility-tools'); ?> </legend>
              <div class="meaAccessibility_rbSlider meaAcM__fontSize">
                <input type="radio" id="fontSizeSmall" name="fontSize" value="meaAccessibility_fontSizeS" aria-hidden="true">
                <label for="fontSizeSmall">S</label>
                <input type="radio" id="fontSizeNormal" name="fontSize" value="meaAccessibility_fontSizeNormal" checked="checked">
                <label for="fontSizeNormal"><?php esc_html_e('‌Normal', 'meacodes-accessibility-tools'); ?></label>
                <input type="radio" id="fontSizeL" name="fontSize" value="meaAccessibility_fontSizeL">
                <label for="fontSizeL">L</label>
                <input type="radio" id="fontSizeXL" name="fontSize" value="meaAccessibility_fontSizeXL">
                <label for="fontSizeXL">XL</label>
                <input type="radio" id="fontSizeXXL" name="fontSize" value="meaAccessibility_fontSizeXXL">
                <label for="fontSizeXXL">XXL</label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_line_height_Fe', true)) : ?>
            <fieldset class="meaAccessibility_lineHeightField meaAccessibility_fieldsetSeparator">
              <legend><?php esc_html_e('Line Height', 'meacodes-accessibility-tools'); ?></legend>
              <div class="meaAccessibility_rbSlider meaAcM__lineSpacing">
                <input type="radio" id="lineHeightNormal" name="lineHeight" value="meaAccessibility_LineHeightNormal" checked="checked">
                <label for="lineHeightNormal"><?php esc_html_e('Normal', 'meacodes-accessibility-tools'); ?></label>
                <input type="radio" id="lineHeightL" name="lineHeight" value="meaAccessibility_lineHeight1" aria-hidden="true">
                <label for="lineHeightL">L</label>
                <input type="radio" id="lineHeightXL" name="lineHeight" value="meaAccessibility_lineHeight2" aria-hidden="true">
                <label for="lineHeightXL">XL</label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_letter_spacing_Fe', true)) : ?>
            <fieldset class="meaAccessibility_letterSpacingField meaAccessibility_fieldsetSeparator">
              <legend class="meaAccessibility_listItemTitle"><?php esc_html_e('Letter Spacing', 'meacodes-accessibility-tools'); ?></legend>
              <div class="meaAccessibility_rbSlider meaAcM__letterSpacing">
                <input type="radio" id="letterSpacingNormal" name="letterSpacing" value="meaAccessibility_letterSpacingNormal" checked="checked">
                <label for="letterSpacingNormal"><?php esc_html_e('Normal', 'meacodes-accessibility-tools'); ?></label>
                <input type="radio" id="letterSpacingL" name="letterSpacing" value="meaAccessibility_letterSpacing1" aria-hidden="true">
                <label for="letterSpacingL">L</label>
                <input type="radio" id="letterSpacingXL" name="letterSpacing" value="meaAccessibility_letterSpacing2" aria-hidden="true">
                <label for="letterSpacingXL">XL</label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_dyslexia_mask_Fe', true)) : ?>
            <fieldset class="meaAccessibility_dyslexicField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="dyslexieFont_4103" class="meaAcM__dyslexieFont" name="dyslexieFont">
                <label class="meaAccessibility_label" for="dyslexieFont_4103"><?php esc_html_e('Dyslexia Mask', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_grayscale_page_Fe', true)) : ?>
            <fieldset class="meaAccessibility_grayscaleField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="grayscale_4103" class="meaAcM__grayscale" name="grayscale">
                <label class="meaAccessibility_label" for="grayscale_4103"><?php esc_html_e('Grayscale Page', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_contrast_Fe', true)) : ?>
            <fieldset class="meaAccessibility_contrastField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="contrast_4103" class="meaAcM__contrast" name="contrast">
                <label class="meaAccessibility_label" for="contrast_4103"><?php esc_html_e('Contrast', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_negativ_Fe', true)) : ?>
            <fieldset class="meaAccessibility_negativField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="negativ_4103" class="meaAcM__negativ" name="negativ">
                <label class="meaAccessibility_label" for="negativ_4103"><?php esc_html_e('Negative', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_underlined_links_Fe', true)) : ?>
            <fieldset class="meaAccessibility_aUnderlinedField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="underlinedLinks_4103" class="meaAcM__underlinedLinks" name="underlinedLinks">
                <label class="meaAccessibility_label" for="underlinedLinks_4103"><?php esc_html_e('Underlined Links', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_highlight_links_Fe', true)) : ?>
            <fieldset class="meaAccessibility_aHighlightField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="highlightLinks_4103" class="meaAcM__highlightLinks" name="highlightLinks">
                <label class="meaAccessibility_label" for="highlightLinks_4103"><?php esc_html_e('Highlight Links', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_grayscale_images_Fe', true)) : ?>
            <fieldset class="meaAccessibility_grayscaleImgField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="grayscaleImages_4103" class="meaAcM__grayscaleImages" name="grayscaleImages">
                <label class="meaAccessibility_label" for="grayscaleImages_4103"><?php esc_html_e('Grayscale Images', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
          <?php if (get_option('meaAccessibility_black_white_Fe', true)) : ?>
            <fieldset class="meaAccessibility_blackAndWhiteField meaAccessibility_fieldsetSwitch">
              <div class="meaAccessibility_switchBox">
                <input type="checkbox" id="blackAndWhite_4103" class="meaAcM__blackAndWhite" name="blackAndWhite">
                <label class="meaAccessibility_label" for="blackAndWhite_4103"><?php esc_html_e('Black and white', 'meacodes-accessibility-tools'); ?></label>
              </div>
            </fieldset>
          <?php endif; ?>
        </div>
        <?php if (get_option('meaAccessibility_copyright_text', false)) : ?>
          <div class="meaAccessibility_copyright-text"><p style="font-size: 0.7rem !important; line-height: 1.2 !important; letter-spacing: normal !important; margin-bottom: 5px !important; margin-top: 5px !important;" class="meaAccessibility_copyright-text-color"><?php esc_html_e('Developed by ', 'meacodes-accessibility-tools'); ?><a style="font-size: 0.9rem !important; line-height: 1.2 !important; letter-spacing: normal !important;" class="meaAccessibility_copyright-text-color" href="https://www.meacodes.com">Meacodes</a></p></div>
        <?php endif; ?>
          <button type="button" class="meaAccessibility_widgetButton meaAccessibility_resetChanges" title="<?php esc_html_e('Reset', 'meacodes-accessibility-tools'); ?>"></button>
          <button type="button" class="meaAccessibility_widgetButton meaAccessibility_closeWidget" aria-label="<?php esc_html_e('Close', 'meacodes-accessibility-tools'); ?>" title="<?php esc_html_e('Close', 'meacodes-accessibility-tools'); ?>"></button>
          <div id="gdprNoticeModal" class="meaAccessibility_modal_overlay" style="font-size: 18px !important; line-height: 1.2 !important; letter-spacing: normal !important;">
            <div class="meaAccessibility_modal" style="font-size: 1rem !important; line-height: 1.2 !important; letter-spacing: normal !important;">           
              <div class="meaAccessibility_modal-content" style="font-size: 1rem !important; line-height: 1.2 !important; letter-spacing: normal !important; margin-top:15px !important;">
                <span class="meaAccessibility_close" style="font-size: 1rem !important; line-height: 1.2 !important; letter-spacing: normal !important;">&times;</span>
                <h6 style="font-size: 1rem !important; line-height: 2 !important; letter-spacing: normal !important; font-weight: bold;"><?php esc_html_e('GDPR Notice:', 'meacodes-accessibility-tools'); ?></h6>
                <p style="font-size: 1rem !important; line-height: 1.2 !important; letter-spacing: normal !important;"><?php esc_html_e('This plugin uses cookies to enhance your experience and provide personalized accessibility settings. These cookies are stored in your browser and allow us to remember your preferences for font size, color schemes, and other accessibility features. By using this plugin, you consent to the use of cookies for these purposes. You can delete or block cookies in your browser settings at any time. Please note that doing so may affect your experience on the site.', 'meacodes-accessibility-tools'); ?></p>
              </div>
            </div>
          </div>
      </div>
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
          if (typeof jQuery !== 'undefined') {
            jQuery('html').addClass('');
            jQuery('.meaCodesAccessibilityModule').prependTo('body');
            jQuery(document).ready(function () {
                jQuery('.meaCodesAccessibilityModule').show();
                jQuery('.meaCodesAccessibilityModule').meaCodesAccessibilityModule('cookie', '0', '477', '4103');
            });
          }else {
            console.error(meaParams.errorMessage);
          }
        });
      </script>    
    </div>
  <?php endif; ?>
  <?php
  }
?>