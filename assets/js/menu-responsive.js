document.addEventListener('DOMContentLoaded', function() {
    // Asegurar que el evento del botón de menú funcione en dispositivos móviles
    const menuToggle = document.querySelector('.sidenav-toggle-button');
    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-enable');
            
            // Detectar tamaño de pantalla para comportamiento responsive
            if (window.innerWidth < 768) {
                document.documentElement.setAttribute('data-sidenav-size', 'full');
            } else if (window.innerWidth >= 768 && window.innerWidth < 1140) {
                document.documentElement.setAttribute('data-sidenav-size', 'condensed');
            }
        });
    }
});