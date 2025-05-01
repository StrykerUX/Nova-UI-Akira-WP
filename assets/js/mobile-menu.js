/**
 * Nova UI Akira - Mobile Menu JS
 * Handles the interaction for the responsive mobile menu
 */

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const mobileMenuOverlay = document.querySelector('.nova-mobile-menu-overlay');
    const mobileMenuToggle = document.querySelector('.nova-mobile-menu-toggle button');
    const mobileMenuClose = document.querySelector('.nova-mobile-menu-close');
    
    // If the elements don't exist, exit
    if (!mobileMenuOverlay || !mobileMenuToggle || !mobileMenuClose) {
        return;
    }
    
    // Open mobile menu
    mobileMenuToggle.addEventListener('click', function() {
        mobileMenuOverlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling of body
    });
    
    // Close mobile menu on close button click
    mobileMenuClose.addEventListener('click', function() {
        closeMobileMenu();
    });
    
    // Close mobile menu when clicking on the overlay (outside the menu)
    mobileMenuOverlay.addEventListener('click', function(e) {
        // Check if click was on the overlay and not on the menu itself
        if (e.target === mobileMenuOverlay) {
            closeMobileMenu();
        }
    });
    
    // Close mobile menu when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMenuOverlay.classList.contains('active')) {
            closeMobileMenu();
        }
    });
    
    // Close mobile menu function
    function closeMobileMenu() {
        mobileMenuOverlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore body scrolling
    }
    
    // Close mobile menu when clicking on a menu item
    const mobileMenuLinks = mobileMenuOverlay.querySelectorAll('a[href]');
    mobileMenuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            // Only close menu if link doesn't toggle a submenu
            if (!link.hasAttribute('data-bs-toggle')) {
                closeMobileMenu();
            }
        });
    });
});
