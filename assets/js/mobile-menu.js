/**
 * Nova UI Akira - Mobile Menu Functionality
 */
(function($) {
    'use strict';
    
    // DOM elements
    const body = $('body');
    const mobileMenuToggle = $('.mobile-menu-toggle');
    const fullscreenMenu = $('.fullscreen-menu');
    const fullscreenMenuClose = $('.fullscreen-menu-close');
    const bottomNavMenuBtn = $('#bottom-nav-menu-btn');
    
    // Function to toggle the fullscreen menu
    function toggleFullscreenMenu() {
        fullscreenMenu.toggleClass('show');
        
        // If opening the menu, trigger the animation
        if (fullscreenMenu.hasClass('show')) {
            // Make sure any previous hiding animation is removed
            fullscreenMenu.removeClass('hiding');
        } else {
            // If closing, apply the slide-down animation
            fullscreenMenu.addClass('hiding');
        }
    }
    
    // Initialize mobile menu
    function initMobileMenu() {
        // Menu toggle button click event
        mobileMenuToggle.on('click', function(e) {
            e.preventDefault();
            toggleFullscreenMenu();
        });
        
        // Bottom nav menu button click event
        bottomNavMenuBtn.on('click', function(e) {
            e.preventDefault();
            toggleFullscreenMenu();
        });
        
        // Close button click event
        fullscreenMenuClose.on('click', function(e) {
            e.preventDefault();
            toggleFullscreenMenu();
        });
        
        // Close menu when clicking outside (optional)
        $(document).on('click', function(e) {
            if (
                fullscreenMenu.hasClass('show') && 
                !$(e.target).closest('.fullscreen-menu').length && 
                !$(e.target).closest('.mobile-menu-toggle').length &&
                !$(e.target).closest('#bottom-nav-menu-btn').length
            ) {
                toggleFullscreenMenu();
            }
        });
    }
    
    // Document ready event
    $(document).ready(function() {
        initMobileMenu();
    });
    
})(jQuery);
