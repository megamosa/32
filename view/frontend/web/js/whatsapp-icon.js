/**
 * MagoArab WhatsApp Icon Extension
 * Frontend JavaScript
 */

define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';

    return function (config) {
        $(document).ready(function () {
            // Ensure WhatsApp icon is visible
            function ensureWhatsAppIconVisible() {
                var $icon = $('#magoarab-whatsapp-icon');
                
                if ($icon.length) {
                    console.log('WhatsApp icon found:', $icon);
                    
                    // Force visibility
                    $icon.css({
                        'position': 'fixed',
                        'z-index': '999999',
                        'display': 'block',
                        'visibility': 'visible',
                        'opacity': '1'
                    });
                    
                    // Apply position classes
                    var position = $icon.data('position') || 'bottom-right';
                    $icon.removeClass('bottom-right bottom-left top-right top-left')
                         .addClass(position);
                    
                    console.log('WhatsApp icon positioned:', position);
                } else {
                    console.log('WhatsApp icon not found');
                }
            }

            // Run on page load
            ensureWhatsAppIconVisible();
            
            // Run after a short delay to ensure all CSS is loaded
            setTimeout(ensureWhatsAppIconVisible, 1000);
            
            // Run multiple times to ensure visibility
            setTimeout(ensureWhatsAppIconVisible, 2000);
            setTimeout(ensureWhatsAppIconVisible, 3000);
            setTimeout(ensureWhatsAppIconVisible, 5000);
            
            // Force visibility every 3 seconds for first 60 seconds
            var forceVisibilityInterval = setInterval(function() {
                ensureWhatsAppIconVisible();
            }, 3000);
            
            // Stop forcing after 60 seconds
            setTimeout(function() {
                clearInterval(forceVisibilityInterval);
            }, 60000);
            
            // Force visibility on DOM changes
            var observer = new MutationObserver(function() {
                ensureWhatsAppIconVisible();
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
            
            // Run on window resize
            $(window).on('resize', ensureWhatsAppIconVisible);
            
            // Run on scroll to ensure icon stays visible
            $(window).on('scroll', function() {
                var $icon = $('#magoarab-whatsapp-icon');
                if ($icon.length) {
                    $icon.css('position', 'fixed');
                }
            });
        });
    };
});