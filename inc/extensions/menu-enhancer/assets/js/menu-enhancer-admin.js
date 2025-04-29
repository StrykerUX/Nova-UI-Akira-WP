/**
 * Menu Enhancer Admin JS
 */
(function($) {
    'use strict';
    
    // Function to add icon previews
    function addIconPreviews() {
        $('.edit-menu-item-icon').each(function() {
            var $this = $(this);
            var iconClass = $this.val();
            
            // Remove any existing preview
            $this.next('.nova-icon-preview').remove();
            
            // Add new preview if there's an icon class
            if (iconClass) {
                $this.after('<span class="nova-icon-preview"><i class="' + iconClass + '"></i></span>');
            }
        });
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        // Add initial icon previews
        addIconPreviews();
        
        // Update preview when icon input changes
        $(document).on('input', '.edit-menu-item-icon', function() {
            addIconPreviews();
        });
        
        // Add icon preview after menu item is added via AJAX
        $(document).ajaxComplete(function(event, xhr, settings) {
            if (settings.data && settings.data.indexOf('action=add-menu-item') !== -1) {
                addIconPreviews();
            }
        });
    });
    
})(jQuery);
