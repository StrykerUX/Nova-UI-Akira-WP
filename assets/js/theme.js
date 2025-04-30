/**
 * Theme functionality for Nova UI Akira theme
 */
(function($) {
    'use strict';
    
    // Configuration defaults
    window.defaultConfig = {
        theme: 'light',
        nav: 'vertical',
        layout: {
            mode: 'fluid',
            position: 'fixed'
        },
        topbar: {
            color: 'light'
        },
        menu: {
            color: 'dark'
        },
        sidenav: {
            size: 'default'
        }
    };
    
    // Set current config from storage or defaults
    window.config = localStorage.getItem('__NOVA_CONFIG__') 
        ? JSON.parse(localStorage.getItem('__NOVA_CONFIG__')) 
        : window.defaultConfig;
    
    // Light/Dark mode toggle
    function initLightDarkMode() {
        $('#light-dark-mode').on('click', function() {
            if ($('html').attr('data-bs-theme') === 'dark') {
                $('html').attr('data-bs-theme', 'light');
                window.config.theme = 'light';
                document.cookie = "theme_mode=light; path=/; SameSite=Strict";
            } else {
                $('html').attr('data-bs-theme', 'dark');
                window.config.theme = 'dark';
                document.cookie = "theme_mode=dark; path=/; SameSite=Strict";
            }
            
            // Save configuration
            localStorage.setItem('__NOVA_CONFIG__', JSON.stringify(window.config));
        });
    }
    
    // Initialize theme
    $(document).ready(function() {
        // Set theme from config
        $('html').attr('data-bs-theme', window.config.theme);
        $('html').attr('data-menu-color', window.config.menu.color);
        $('html').attr('data-topbar-color', window.config.topbar.color);
        $('html').attr('data-sidenav-size', window.config.sidenav.size);
        
        // Set cookie for server-side theming
        document.cookie = "theme_mode=" + window.config.theme + "; path=/; SameSite=Strict";
        
        // Initialize toggles
        initLightDarkMode();
    });
    
})(jQuery);
