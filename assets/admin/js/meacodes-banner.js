/**
 * Meacodes Admin Banner JavaScript
 *
 * @package Meacodes_Accessibility_Tools
 * @since 1.0.6
 */

(function($) {
    'use strict';

    /**
     * Meacodes Banner Handler
     */
    var MeacodesBanner = {
        
        /**
         * Initialize the banner functionality
         */
        init: function() {
            this.bindEvents();
        },

        /**
         * Bind event handlers
         */
        bindEvents: function() {
            // Close button click handler
            $(document).on('click', '.meacodes-banner-close', this.handleCloseClick);
            
            // Keyboard support for close button
            $(document).on('keydown', '.meacodes-banner-close', this.handleCloseKeydown);
            
            // Handle banner button clicks (tracking)
            $(document).on('click', '.meacodes-banner-button', this.handleButtonClick);
        },

        /**
         * Handle close button click
         *
         * @param {Event} e - Click event
         */
        handleCloseClick: function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $banner = $(this).closest('.meacodes-banner');
            
            // Add dismissed class for immediate visual feedback
            $banner.addClass('dismissed');
            
            // Dismiss banner via AJAX
            MeacodesBanner.dismissBanner();
        },

        /**
         * Handle close button keyboard events
         *
         * @param {Event} e - Keyboard event
         */
        handleCloseKeydown: function(e) {
            // Handle Enter and Space keys
            if (e.which === 13 || e.which === 32) {
                e.preventDefault();
                $(this).click();
            }
        },

        /**
         * Handle banner button click for analytics
         *
         * @param {Event} e - Click event
         */
        handleButtonClick: function(e) {
            // Track button click (you can add analytics here)
            console.log('Meacodes banner button clicked');
            
            // Let the link work normally
            // No preventDefault() needed
        },

        /**
         * Dismiss banner via AJAX
         */
        dismissBanner: function() {
            var data = {
                action: meacodesBanner.action,
                nonce: meacodesBanner.nonce
            };

            $.ajax({
                url: meacodesBanner.ajaxUrl,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        console.log('Banner dismissed successfully');
                    } else {
                        console.error('Failed to dismiss banner:', response.data);
                        // Revert visual state if AJAX failed
                        $('.meacodes-banner').removeClass('dismissed');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error dismissing banner:', error);
                    // Revert visual state if AJAX failed
                    $('.meacodes-banner').removeClass('dismissed');
                }
            });
        },

        /**
         * Show banner (for testing purposes)
         */
        showBanner: function() {
            $('.meacodes-banner').removeClass('dismissed').show();
        },

        /**
         * Hide banner
         */
        hideBanner: function() {
            $('.meacodes-banner').addClass('dismissed');
        }
    };

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        MeacodesBanner.init();
    });

    /**
     * Expose to global scope for testing
     */
    window.MeacodesBanner = MeacodesBanner;

})(jQuery);
