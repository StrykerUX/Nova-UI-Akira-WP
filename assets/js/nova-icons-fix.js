/**
 * Script independiente para garantizar que los iconos se inicialicen correctamente
 * sin depender de jQuery
 */
(function() {
    'use strict';
    
    // Función para inicializar los iconos
    function initializeIcons() {
        console.log("Inicializando iconos de forma independiente...");
        
        // Inicializar Lucide Icons si está disponible
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            console.log("Lucide encontrado - inicializando iconos...");
            lucide.createIcons();
        } else {
            console.log("Lucide no está disponible");
        }
        
        // Añadir clases a los iconos Tabler para mejorar visibilidad
        document.querySelectorAll('.ti').forEach(function(icon) {
            // Asegurar que los iconos Tabler sean visibles
            if (icon.style.color === '' || icon.style.color === 'transparent') {
                if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                    icon.style.color = '#f8f9fa';
                } else {
                    icon.style.color = '#212529';
                }
            }
        });
    }
    
    // Inicializar tan pronto como sea posible
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeIcons);
    } else {
        initializeIcons();
    }
    
    // También inicializar después de que la página esté completamente cargada
    window.addEventListener('load', initializeIcons);
    
    // Exponer la función globalmente para poder llamarla desde otros scripts
    window.novaInitIcons = initializeIcons;
})();
