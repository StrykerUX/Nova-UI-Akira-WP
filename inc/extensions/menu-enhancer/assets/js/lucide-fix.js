/**
 * Lucide Fix
 * 
 * This script fixes the "lucide is not defined" error by providing a dummy object
 * when the lucide library is not available.
 */
(function() {
    // Check if lucide is not defined
    if (typeof window.lucide === 'undefined') {
        // Create a dummy lucide object to prevent errors
        window.lucide = {
            // Add any methods or properties that your app.js expects from lucide
            createIcons: function() {
                console.log('Lucide icons library is not loaded. This is a placeholder.');
                return true;
            }
        };
    }
})();
