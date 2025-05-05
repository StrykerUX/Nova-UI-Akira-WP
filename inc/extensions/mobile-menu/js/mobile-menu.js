/**
 * Mobile Menu JavaScript
 * 
 * Handles the interactions for the mobile bottom navigation
 * and the fullscreen more menu.
 *
 * @package Nova_UI_Akira
 * @subpackage Mobile_Menu
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        // Adjust layout for mobile screens
        function adjustForMobile() {
            // Check if we're on a mobile screen
            if (window.innerWidth < 768) {
                // Add a class to the body for mobile-specific styling
                document.body.classList.add('mobile-view');
                
                // Force content-page to have left margin 0
                const contentPage = document.querySelector('.content-page');
                if (contentPage) {
                    contentPage.style.marginLeft = '0';
                    contentPage.style.width = '100%';
                }
                
                // Force topbar to be full width
                const topbar = document.querySelector('.app-topbar');
                if (topbar) {
                    topbar.style.left = '0';
                    topbar.style.width = '100%';
                }
            } else {
                // Remove the mobile view class when on larger screens
                document.body.classList.remove('mobile-view');
                
                // Reset styles on larger screens
                const contentPage = document.querySelector('.content-page');
                const topbar = document.querySelector('.app-topbar');
                
                if (contentPage) {
                    contentPage.style.marginLeft = '';
                    contentPage.style.width = '';
                }
                
                if (topbar) {
                    topbar.style.left = '';
                    topbar.style.width = '';
                }
            }
        }
        
        // Run on page load
        adjustForMobile();
        
        // Run on resize
        window.addEventListener('resize', adjustForMobile);
        
        // Toggle More Menu
        const moreMenuToggle = document.getElementById('more-menu-toggle');
        const moreMenu = document.querySelector('.mobile-more-menu');
        const closeMoreMenu = document.querySelector('.close-more-menu');

        if (moreMenuToggle && moreMenu && closeMoreMenu) {
            moreMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                moreMenu.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
            
            closeMoreMenu.addEventListener('click', function() {
                moreMenu.classList.remove('show');
                document.body.style.overflow = '';
            });
            
            // Close by clicking outside of menu content
            moreMenu.addEventListener('click', function(e) {
                // Check if the click was directly on the more menu container
                if (e.target === moreMenu) {
                    moreMenu.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
            
            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && moreMenu.classList.contains('show')) {
                    moreMenu.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        }

        // Mobile menu dark/light toggle functionality
        const mobileDarkLightToggle = document.getElementById('mobile-dark-light-toggle');
        if (mobileDarkLightToggle) {
            mobileDarkLightToggle.addEventListener('click', function() {
                // Trigger the same action as the desktop toggle
                const desktopToggle = document.getElementById('light-dark-mode');
                if (desktopToggle) {
                    desktopToggle.click();
                }
            });
        }

        // Auto-close more menu on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && moreMenu && moreMenu.classList.contains('show')) {
                moreMenu.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
        
        // Set active class for current page
        const currentUrl = window.location.href;
        const mobileNavItems = document.querySelectorAll('.mobile-nav-item');
        
        mobileNavItems.forEach(function(item) {
            // Skip the more menu toggle
            if (item.id === 'more-menu-toggle') {
                return;
            }
            
            const itemUrl = item.getAttribute('href');
            if (itemUrl && currentUrl.includes(itemUrl) && itemUrl !== '#' && itemUrl !== '/') {
                // Remove active class from all items
                mobileNavItems.forEach(function(navItem) {
                    navItem.classList.remove('active');
                });
                
                // Add active class to the current item
                item.classList.add('active');
            } else if (itemUrl === '/' && currentUrl === window.location.origin + '/') {
                // Special case for the home page
                item.classList.add('active');
            }
        });
    });
})();
