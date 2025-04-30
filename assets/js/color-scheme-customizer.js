/**
 * Color Scheme Customizer Script
 * Applies color scheme presets when selected
 */
(function($) {
    'use strict';
    
    wp.customize('color_scheme', function(value) {
        value.bind(function(newVal) {
            // Only apply presets if not selecting "custom"
            if (newVal !== 'custom' && novaColorSchemes[newVal]) {
                var scheme = novaColorSchemes[newVal];
                
                // Update each color setting silently
                for (var setting in scheme) {
                    if (scheme.hasOwnProperty(setting)) {
                        wp.customize(setting).set(scheme[setting]);
                    }
                }
            }
        });
    });
    
})(jQuery);
