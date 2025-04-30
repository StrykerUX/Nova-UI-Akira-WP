/**
 * Dashboard Template JavaScript
 * Ajusta la altura del contenedor del dashboard para ocupar todo el espacio vertical disponible
 */

// Funciones para ajustar la altura del dashboard
function adjustDashboardHeight() {
    // Altura de la ventana
    var windowHeight = window.innerHeight;
    
    // Altura del topbar (usando la variable CSS)
    var topbarHeight = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--bs-topbar-height'));
    
    // Dashboard container
    var dashboardContainer = document.querySelector('.dashboard-template');
    if (dashboardContainer) {
        // Ajustar altura
        dashboardContainer.style.height = (windowHeight - topbarHeight) + 'px';
        
        // También ajustar las alturas de los contenedores internos
        var contentRow = document.querySelector('.dashboard-content-row');
        var contentCol = document.querySelector('.dashboard-content-col');
        var dashboardCard = document.querySelector('.dashboard-card');
        
        if (contentRow) contentRow.style.height = '100%';
        if (contentCol) contentCol.style.height = '100%';
        if (dashboardCard) dashboardCard.style.height = '100%';
    }
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    adjustDashboardHeight();
    
    // Ajustar también cuando se redimensiona la ventana
    window.addEventListener('resize', adjustDashboardHeight);
});
