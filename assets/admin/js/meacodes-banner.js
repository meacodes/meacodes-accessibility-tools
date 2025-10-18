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
            document.addEventListener('click', (e) => {
                if (e.target.matches('.meacodes-banner-close')) {
                    this.handleCloseClick(e);
                }
            });
            
            // Keyboard support for close button
            document.addEventListener('keydown', (e) => {
                if (e.target.matches('.meacodes-banner-close')) {
                    this.handleCloseKeydown(e);
                }
            });
            
            // Handle banner button clicks (tracking)
            document.addEventListener('click', (e) => {
                if (e.target.matches('.meacodes-banner-button')) {
                    this.handleButtonClick(e);
                }
            });
        },

        /**
         * Handle close button click
         *
         * @param {Event} e - Click event
         */
        handleCloseClick: function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var banner = e.target.closest('.meacodes-banner');
            
            // Add dismissed class for immediate visual feedback
            banner.classList.add('dismissed');
            
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
                e.target.click();
            }
        },

        /**
         * Handle banner button click for analytics
         *
         * @param {Event} e - Click event
         */
        handleButtonClick: function(e) {
            // Track button click (you can add analytics here)
            // Debug code removed for production
            
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
                        // Debug code removed for production
                    } else {
                        // Debug code removed for production
                        // Revert visual state if AJAX failed
                        document.querySelectorAll('.meacodes-banner').forEach(banner => {
                            banner.classList.remove('dismissed');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error dismissing banner:', error);
                    // Revert visual state if AJAX failed
                    document.querySelectorAll('.meacodes-banner').forEach(banner => {
                        banner.classList.remove('dismissed');
                    });
                }
            });
        },

        /**
         * Show banner (for testing purposes)
         */
        showBanner: function() {
            document.querySelectorAll('.meacodes-banner').forEach(banner => {
                banner.classList.remove('dismissed');
                banner.style.display = 'block';
            });
        },

        /**
         * Hide banner
         */
        hideBanner: function() {
            document.querySelectorAll('.meacodes-banner').forEach(banner => {
                banner.classList.add('dismissed');
            });
        }
    };

    /**
     * Initialize when document is ready
     */
    document.addEventListener('DOMContentLoaded', function() {
        MeacodesBanner.init();
    });

    /**
     * Expose to global scope for testing
     */
    window.MeacodesBanner = MeacodesBanner;

})();
