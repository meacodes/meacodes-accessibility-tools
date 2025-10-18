<?php
/**
 * Accessibility checks class
 *
 * @package MeacodesQuickScan
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * MeacodesQuickScan_Checks class
 */
class MeacodesQuickScan_Checks {
    
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
     * Check a page for accessibility issues
     */
    public function check_page($html) {
        $results = array(
            'a' => 0,
            'aa' => 0,
            'aaa' => 0,
            'issues' => array()
        );
        
        // Create DOMDocument
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        
        $xpath = new DOMXPath($dom);
        
        // Run A-level checks
        $img_issues = $this->check_images_alt($xpath);
        $results['a'] += $img_issues['count'];
        if ($img_issues['count'] > 0) {
            // translators: %d is the number of images without alt text
            $results['issues'][] = sprintf(__('%d images without alt text', 'meacodes-accessibility-tools'), $img_issues['count']);
        }
        
        $form_issues = $this->check_form_labels($xpath);
        $results['a'] += $form_issues['count'];
        if ($form_issues['count'] > 0) {
            // translators: %d is the number of form elements without labels
            $results['issues'][] = sprintf(__('%d form elements without labels', 'meacodes-accessibility-tools'), $form_issues['count']);
        }
        
        $lang_issues = $this->check_language_declaration($xpath);
        $results['a'] += $lang_issues['count'];
        if ($lang_issues['count'] > 0) {
            // translators: %d is the number of missing language declarations
            $results['issues'][] = sprintf(__('%d missing language declaration', 'meacodes-accessibility-tools'), $lang_issues['count']);
        }
        
        $button_issues = $this->check_button_accessibility($xpath);
        $results['a'] += $button_issues['count'];
        if ($button_issues['count'] > 0) {
            // translators: %d is the number of buttons without accessible names
            $results['issues'][] = sprintf(__('%d buttons without accessible names', 'meacodes-accessibility-tools'), $button_issues['count']);
        }
        
        $table_issues = $this->check_table_headers($xpath);
        $results['a'] += $table_issues['count'];
        if ($table_issues['count'] > 0) {
            // translators: %d is the number of tables without proper headers
            $results['issues'][] = sprintf(__('%d tables without proper headers', 'meacodes-accessibility-tools'), $table_issues['count']);
        }
        
        // Run AA-level checks
        $link_issues = $this->check_empty_links($xpath);
        $results['aa'] += $link_issues['count'];
        if ($link_issues['count'] > 0) {
            // translators: %d is the number of empty or unclear links
            $results['issues'][] = sprintf(__('%d empty or unclear links', 'meacodes-accessibility-tools'), $link_issues['count']);
        }
        
        $heading_issues = $this->check_heading_structure($xpath);
        $results['aa'] += $heading_issues['count'];
        if ($heading_issues['count'] > 0) {
            // translators: %d is the number of heading structure issues
            $results['issues'][] = sprintf(__('%d heading structure issues', 'meacodes-accessibility-tools'), $heading_issues['count']);
        }
        
        $skip_issues = $this->check_skip_links($xpath);
        $results['aa'] += $skip_issues['count'];
        if ($skip_issues['count'] > 0) {
            // translators: %d is the number of missing skip links
            $results['issues'][] = sprintf(__('%d missing skip links', 'meacodes-accessibility-tools'), $skip_issues['count']);
        }
        
        $focus_issues = $this->check_focus_indicators($xpath);
        $results['aa'] += $focus_issues['count'];
        if ($focus_issues['count'] > 0) {
            // translators: %d is the number of missing focus indicators
            $results['issues'][] = sprintf(__('%d missing focus indicators', 'meacodes-accessibility-tools'), $focus_issues['count']);
        }
        
        $landmark_issues = $this->check_landmark_roles($xpath);
        $results['aa'] += $landmark_issues['count'];
        if ($landmark_issues['count'] > 0) {
            // translators: %d is the number of missing landmark roles
            $results['issues'][] = sprintf(__('%d missing landmark roles', 'meacodes-accessibility-tools'), $landmark_issues['count']);
        }
        
        $form_validation_issues = $this->check_form_validation($xpath);
        $results['aa'] += $form_validation_issues['count'];
        if ($form_validation_issues['count'] > 0) {
            // translators: %d is the number of form validation issues
            $results['issues'][] = sprintf(__('%d form validation issues', 'meacodes-accessibility-tools'), $form_validation_issues['count']);
        }
        
        // Run AAA-level checks
        $contrast_issues = $this->check_color_contrast($xpath);
        $results['aaa'] += $contrast_issues['count'];
        if ($contrast_issues['count'] > 0) {
            // translators: %d is the number of potential color contrast issues
            $results['issues'][] = sprintf(__('%d potential color contrast issues', 'meacodes-accessibility-tools'), $contrast_issues['count']);
        }
        
        $motion_issues = $this->check_motion_preferences($xpath);
        $results['aaa'] += $motion_issues['count'];
        if ($motion_issues['count'] > 0) {
            // translators: %d is the number of motion/animation issues
            $results['issues'][] = sprintf(__('%d motion/animation issues', 'meacodes-accessibility-tools'), $motion_issues['count']);
        }
        
        $text_spacing_issues = $this->check_text_spacing($xpath);
        $results['aaa'] += $text_spacing_issues['count'];
        if ($text_spacing_issues['count'] > 0) {
            // translators: %d is the number of text spacing issues
            $results['issues'][] = sprintf(__('%d text spacing issues', 'meacodes-accessibility-tools'), $text_spacing_issues['count']);
        }
        
        return $results;
    }
    
    /**
     * Check images for alt attributes (A-level)
     */
    private function check_images_alt($xpath) {
        $count = 0;
        $images = $xpath->query('//img');
        
        foreach ($images as $img) {
            $alt = $img->getAttribute('alt');
            if ($alt === '' || $alt === null) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check form elements for labels (A-level)
     */
    private function check_form_labels($xpath) {
        $count = 0;
        
        // Check input elements
        $inputs = $xpath->query('//input[@type="text" or @type="email" or @type="password" or @type="search" or @type="url" or @type="tel" or @type="number"]');
        foreach ($inputs as $input) {
            if (!$this->has_label_or_aria_label($input, $xpath)) {
                $count++;
            }
        }
        
        // Check select elements
        $selects = $xpath->query('//select');
        foreach ($selects as $select) {
            if (!$this->has_label_or_aria_label($select, $xpath)) {
                $count++;
            }
        }
        
        // Check textarea elements
        $textareas = $xpath->query('//textarea');
        foreach ($textareas as $textarea) {
            if (!$this->has_label_or_aria_label($textarea, $xpath)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check if form element has label or aria-label
     */
    private function has_label_or_aria_label($element, $xpath) {
        // Check for aria-label
        if ($element->getAttribute('aria-label')) {
            return true;
        }
        
        // Check for aria-labelledby
        $labelledby = $element->getAttribute('aria-labelledby');
        if ($labelledby) {
            $label = $xpath->query("//*[@id='$labelledby']");
            if ($label->length > 0) {
                return true;
            }
        }
        
        // Check for associated label
        $id = $element->getAttribute('id');
        if ($id) {
            $label = $xpath->query("//label[@for='$id']");
            if ($label->length > 0) {
                return true;
            }
        }
        
        // Check for wrapping label
        $parent = $element->parentNode;
        if ($parent && $parent->nodeName === 'label') {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check for empty links (AA-level)
     */
    private function check_empty_links($xpath) {
        $count = 0;
        $links = $xpath->query('//a');
        
        foreach ($links as $link) {
            $text = trim($link->textContent);
            $aria_label = $link->getAttribute('aria-label');
            $title = $link->getAttribute('title');
            
            if (empty($text) && empty($aria_label) && empty($title)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check heading structure (AA-level)
     */
    private function check_heading_structure($xpath) {
        $h1_count = $xpath->query('//h1')->length;
        
        // Page should have at least one h1
        $count = $h1_count === 0 ? 1 : 0;
        return array('count' => $count);
    }
    
    /**
     * Check color contrast (AAA-level, limited)
     */
    private function check_color_contrast($xpath) {
        $count = 0;
        
        // Find elements with inline color styles
        $elements = $xpath->query('//*[@style]');
        
        foreach ($elements as $element) {
            $style = $element->getAttribute('style');
            if (preg_match('/color\s*:\s*([^;]+)/', $style, $color_matches) &&
                preg_match('/background-color\s*:\s*([^;]+)/', $style, $bg_matches)) {
                
                $text_color = trim($color_matches[1]);
                $bg_color = trim($bg_matches[1]);
                
                if ($this->has_low_contrast($text_color, $bg_color)) {
                    $count++;
                }
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check if colors have low contrast (simplified)
     */
    private function has_low_contrast($text_color, $bg_color) {
        $text_rgb = $this->parse_color($text_color);
        $bg_rgb = $this->parse_color($bg_color);
        
        if (!$text_rgb || !$bg_rgb) {
            return false;
        }
        
        $contrast = $this->calculate_contrast_ratio($text_rgb, $bg_rgb);
        
        // AAA requires 7:1 for normal text
        return $contrast < 7.0;
    }
    
    /**
     * Parse color string to RGB array
     */
    private function parse_color($color) {
        $color = trim($color);
        
        // Handle hex colors
        if (preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', $color, $matches)) {
            $hex = $matches[1];
            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }
            return array(
                'r' => hexdec(substr($hex, 0, 2)),
                'g' => hexdec(substr($hex, 2, 2)),
                'b' => hexdec(substr($hex, 4, 2))
            );
        }
        
        // Handle rgb() colors
        if (preg_match('/rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/', $color, $matches)) {
            return array(
                'r' => intval($matches[1]),
                'g' => intval($matches[2]),
                'b' => intval($matches[3])
            );
        }
        
        return false;
    }
    
    /**
     * Calculate contrast ratio between two colors
     */
    private function calculate_contrast_ratio($color1, $color2) {
        $l1 = $this->get_relative_luminance($color1);
        $l2 = $this->get_relative_luminance($color2);
        
        $lighter = max($l1, $l2);
        $darker = min($l1, $l2);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }
    
    /**
     * Get relative luminance of a color
     */
    private function get_relative_luminance($color) {
        $r = $color['r'] / 255;
        $g = $color['g'] / 255;
        $b = $color['b'] / 255;
        
        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }
    
    /**
     * Check language declaration (A-level)
     */
    private function check_language_declaration($xpath) {
        $html_elements = $xpath->query('//html');
        $count = 0;
        
        foreach ($html_elements as $html) {
            $lang = $html->getAttribute('lang');
            if (empty($lang)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check button accessibility (A-level)
     */
    private function check_button_accessibility($xpath) {
        $count = 0;
        $buttons = $xpath->query('//button | //input[@type="button"] | //input[@type="submit"] | //input[@type="reset"]');
        
        foreach ($buttons as $button) {
            $text = trim($button->textContent);
            $value = $button->getAttribute('value');
            $aria_label = $button->getAttribute('aria-label');
            $aria_labelledby = $button->getAttribute('aria-labelledby');
            
            if (empty($text) && empty($value) && empty($aria_label) && empty($aria_labelledby)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check table headers (A-level)
     */
    private function check_table_headers($xpath) {
        $count = 0;
        $tables = $xpath->query('//table');
        
        foreach ($tables as $table) {
            $headers = $xpath->query('.//th', $table);
            if ($headers->length === 0) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check skip links (AA-level)
     */
    private function check_skip_links($xpath) {
        $skip_links = $xpath->query('//a[contains(@href, "#") or contains(text(), "skip") or contains(text(), "Skip")]');
        $count = 0;
        
        // If no skip links found, flag as issue
        if ($skip_links->length === 0) {
            $count = 1; // Flag as missing skip links
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check focus indicators (AA-level)
     */
    private function check_focus_indicators($xpath) {
        $count = 0;
        $focusable_elements = $xpath->query('//a | //button | //input | //select | //textarea | //[tabindex]');
        
        foreach ($focusable_elements as $element) {
            $style = $element->getAttribute('style');
            $class = $element->getAttribute('class');
            
            // Check if element has focus styles
            if (empty($style) && empty($class)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check landmark roles (AA-level)
     */
    private function check_landmark_roles($xpath) {
        $count = 0;
        $landmarks = $xpath->query('//*[@role="banner"] | //*[@role="main"] | //*[@role="navigation"] | //*[@role="contentinfo"] | //header | //main | //nav | //footer');
        
        // If no landmarks found, flag as issue
        if ($landmarks->length === 0) {
            $count = 1;
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check form validation (AA-level)
     */
    private function check_form_validation($xpath) {
        $count = 0;
        $required_inputs = $xpath->query('//input[@required] | //select[@required] | //textarea[@required]');
        
        foreach ($required_inputs as $input) {
            $aria_required = $input->getAttribute('aria-required');
            $aria_invalid = $input->getAttribute('aria-invalid');
            
            // Check if required field has proper ARIA attributes
            if ($aria_required !== 'true' && $aria_invalid !== 'true') {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check motion preferences (AAA-level)
     */
    private function check_motion_preferences($xpath) {
        $count = 0;
        $animated_elements = $xpath->query('//*[@style]');
        
        foreach ($animated_elements as $element) {
            $style = $element->getAttribute('style');
            if (preg_match('/(animation|transition|transform)/', $style)) {
                $count++;
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Check text spacing (AAA-level)
     */
    private function check_text_spacing($xpath) {
        $count = 0;
        $text_elements = $xpath->query('//p | //div | //span | //h1 | //h2 | //h3 | //h4 | //h5 | //h6');
        
        foreach ($text_elements as $element) {
            $style = $element->getAttribute('style');
            if (preg_match('/line-height\s*:\s*([^;]+)/', $style, $matches)) {
                $line_height = trim($matches[1]);
                // Check if line height is less than 1.5 (AAA requirement)
                if (is_numeric($line_height) && $line_height < 1.5) {
                    $count++;
                }
            }
        }
        
        return array('count' => $count);
    }
    
    /**
     * Get check descriptions
     */
    public function get_check_descriptions() {
        return array(
            'a' => array(
                'title' => __('A-Level Issues', 'meacodes-accessibility-tools'),
                'description' => __('Basic accessibility: Images, forms, language, buttons, tables', 'meacodes-accessibility-tools')
            ),
            'aa' => array(
                'title' => __('AA-Level Issues', 'meacodes-accessibility-tools'),
                'description' => __('Enhanced accessibility: Links, headings, navigation, focus, landmarks', 'meacodes-accessibility-tools')
            ),
            'aaa' => array(
                'title' => __('AAA-Level Issues', 'meacodes-accessibility-tools'),
                'description' => __('Advanced accessibility: Contrast, motion, text spacing', 'meacodes-accessibility-tools')
            )
        );
    }
}
