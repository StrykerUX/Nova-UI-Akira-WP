/**
 * Live preview for color customizer changes
 * Updates CSS variables in real-time as colors are changed in the customizer
 */
(function($) {
    'use strict';
    
    // Helper function to convert hex color to RGB
    function hexToRgb(hex) {
        // Remove # if present
        hex = hex.replace('#', '');
        
        // Parse the hex values
        var r = parseInt(hex.substring(0, 2), 16);
        var g = parseInt(hex.substring(2, 4), 16);
        var b = parseInt(hex.substring(4, 6), 16);
        
        return r + ',' + g + ',' + b;
    }
    
    // Helper function to adjust brightness
    function adjustBrightness(hex, steps) {
        // Remove # if present
        hex = hex.replace('#', '');
        
        // Parse the hex values
        var r = parseInt(hex.substring(0, 2), 16);
        var g = parseInt(hex.substring(2, 4), 16);
        var b = parseInt(hex.substring(4, 6), 16);
        
        // Adjust values
        r = Math.max(0, Math.min(255, r + steps));
        g = Math.max(0, Math.min(255, g + steps));
        b = Math.max(0, Math.min(255, b + steps));
        
        // Convert back to hex
        return '#' + r.toString(16).padStart(2, '0') + 
               g.toString(16).padStart(2, '0') + 
               b.toString(16).padStart(2, '0');
    }
    
    // Update primary color
    wp.customize('primary_color', function(value) {
        value.bind(function(newVal) {
            var rgbValue = hexToRgb(newVal);
            
            // Update CSS variables
            document.documentElement.style.setProperty('--bs-primary', newVal);
            document.documentElement.style.setProperty('--bs-primary-rgb', rgbValue);
            
            // Update derived styles
            $('.icon-dual-primary').css({
                'color': newVal,
                'fill': 'rgba(' + rgbValue + ', 0.2)'
            });
        });
    });
    
    // Update secondary color
    wp.customize('secondary_color', function(value) {
        value.bind(function(newVal) {
            var rgbValue = hexToRgb(newVal);
            
            // Update CSS variables
            document.documentElement.style.setProperty('--bs-secondary', newVal);
            document.documentElement.style.setProperty('--bs-secondary-rgb', rgbValue);
            
            // Update derived styles
            $('.icon-dual-secondary').css({
                'color': newVal,
                'fill': 'rgba(' + rgbValue + ', 0.2)'
            });
        });
    });
    
    // Update accent color
    wp.customize('accent_color', function(value) {
        value.bind(function(newVal) {
            var rgbValue = hexToRgb(newVal);
            var darkerAccent = adjustBrightness(newVal, -15);
            var darkerRgb = hexToRgb(darkerAccent);
            
            // Update CSS variables
            document.documentElement.style.setProperty('--bs-accent', newVal);
            document.documentElement.style.setProperty('--bs-accent-rgb', rgbValue);
            document.documentElement.style.setProperty('--bs-link-color', newVal);
            document.documentElement.style.setProperty('--bs-link-color-rgb', rgbValue);
            document.documentElement.style.setProperty('--bs-link-hover-color', darkerAccent);
            document.documentElement.style.setProperty('--bs-link-hover-color-rgb', darkerRgb);
            
            // Update icon colors for hover effects
            var style = $('#nova-icon-hover-preview');
            if (style.length === 0) {
                style = $('<style id="nova-icon-hover-preview"></style>').appendTo('head');
            }
            
            style.html('\
            .btn-icon:hover i, \
            .topbar-link:hover i, \
            .menu-icon:hover i, \
            .side-nav-link:hover i, \
            .app-topbar .btn-icon:hover i, \
            .app-topbar .btn-outline-primary:hover i, \
            #light-dark-mode:hover i, \
            .sidenav-toggle-button:hover i, \
            .user-dropdown-toggle:hover i, \
            .topbar-item .dropdown-toggle:hover i, \
            button:hover i, \
            a:hover i, \
            .nav-link:hover i { \
                color: ' + newVal + ' !important; \
            }');
            
            // Update icon colors
            $('.icon-dual-accent').css({
                'color': newVal,
                'fill': 'rgba(' + rgbValue + ', 0.2)'
            });
        });
    });
    
    // Update light mode background
    wp.customize('light_background', function(value) {
        value.bind(function(newVal) {
            if (!$('html').attr('data-bs-theme') || $('html').attr('data-bs-theme') === 'light') {
                document.documentElement.style.setProperty('--bs-body-bg', newVal);
                document.documentElement.style.setProperty('--bs-body-bg-rgb', hexToRgb(newVal));
            }
        });
    });
    
    // Update light mode text color
    wp.customize('light_text', function(value) {
        value.bind(function(newVal) {
            if (!$('html').attr('data-bs-theme') || $('html').attr('data-bs-theme') === 'light') {
                document.documentElement.style.setProperty('--bs-body-color', newVal);
                document.documentElement.style.setProperty('--bs-body-color-rgb', hexToRgb(newVal));
            }
        });
    });
    
    // Update dark mode background
    wp.customize('dark_background', function(value) {
        value.bind(function(newVal) {
            if ($('html').attr('data-bs-theme') === 'dark') {
                document.documentElement.style.setProperty('--bs-body-bg', newVal);
                document.documentElement.style.setProperty('--bs-body-bg-rgb', hexToRgb(newVal));
            }
            
            // Add a style rule for dark mode
            var style = $('#nova-dark-mode-preview');
            if (style.length === 0) {
                style = $('<style id="nova-dark-mode-preview"></style>').appendTo('head');
            }
            
            style.html('[data-bs-theme=dark] { --bs-body-bg: ' + newVal + '; --bs-body-bg-rgb: ' + hexToRgb(newVal) + '; }');
        });
    });
    
    // Update dark mode text color
    wp.customize('dark_text', function(value) {
        value.bind(function(newVal) {
            if ($('html').attr('data-bs-theme') === 'dark') {
                document.documentElement.style.setProperty('--bs-body-color', newVal);
                document.documentElement.style.setProperty('--bs-body-color-rgb', hexToRgb(newVal));
            }
            
            // Add a style rule for dark mode
            var style = $('#nova-dark-mode-text-preview');
            if (style.length === 0) {
                style = $('<style id="nova-dark-mode-text-preview"></style>').appendTo('head');
            }
            
            style.html('[data-bs-theme=dark] { --bs-body-color: ' + newVal + '; --bs-body-color-rgb: ' + hexToRgb(newVal) + '; }');
        });
    });
    
    // Update menu hover color
    wp.customize('menu_hover_color', function(value) {
        value.bind(function(newVal) {
            var rgbValue = hexToRgb(newVal);
            
            document.documentElement.style.setProperty('--bs-menu-item-hover-color', newVal);
            document.documentElement.style.setProperty('--bs-menu-item-hover-bg', 'rgba(' + rgbValue + ', 0.1)');
            document.documentElement.style.setProperty('--bs-menu-item-active-color', newVal);
            document.documentElement.style.setProperty('--bs-menu-item-active-bg', 'rgba(' + rgbValue + ', 0.1)');
            
            // Update menu styles
            $('.side-nav-item:hover, .side-nav-item:focus, .side-nav-item.active').css('color', newVal);
            $('.side-nav-link:hover, .side-nav-link:focus, .side-nav-link:active').css('color', newVal);
        });
    });
    
    // Update button background
    wp.customize('button_background', function(value) {
        value.bind(function(newVal) {
            var darkerButton = adjustBrightness(newVal, -10);
            
            document.documentElement.style.setProperty('--bs-btn-bg', newVal);
            
            // Add style rules for buttons
            var style = $('#nova-button-preview');
            if (style.length === 0) {
                style = $('<style id="nova-button-preview"></style>').appendTo('head');
            }
            
            style.html('.btn-primary { --bs-btn-bg: ' + newVal + '; --bs-btn-border-color: ' + newVal + '; --bs-btn-hover-bg: ' + darkerButton + '; --bs-btn-hover-border-color: ' + darkerButton + '; }');
        });
    });
    
    // Update button text color
    wp.customize('button_text', function(value) {
        value.bind(function(newVal) {
            document.documentElement.style.setProperty('--bs-btn-color', newVal);
            
            // Add style rules for button text
            var style = $('#nova-button-text-preview');
            if (style.length === 0) {
                style = $('<style id="nova-button-text-preview"></style>').appendTo('head');
            }
            
            style.html('.btn-primary { --bs-btn-color: ' + newVal + '; --bs-btn-hover-color: ' + newVal + '; }');
        });
    });
    
})(jQuery);
