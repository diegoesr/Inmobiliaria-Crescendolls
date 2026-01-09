(function () {
    'use strict';

    // ============================================
    // Menú móvil toggle
    // ============================================
    const toggle = document.getElementById('menuToggle');
    const nav = document.getElementById('navMenu');

    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('active');
        });
    }

    // ============================================
    // Scroll suave para enlaces de navegación
    // ============================================
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Solo hacer scroll suave si es un enlace de ancla (#)
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const section = document.querySelector(href);
                if (section) section.scrollIntoView({ behavior: 'smooth' });

                // Cerrar menú móvil si está abierto
                if (nav) nav.classList.remove('active');
            }
            // Si no es un ancla, dejar que navegue normalmente (otras páginas)
        });
    });

    // ============================================
    // Efecto de zoom en imágenes de tarjetas
    // ============================================
    document.querySelectorAll('.card img, .propiedad-card img').forEach(img => {
        img.style.transition = 'transform 0.3s ease';
        img.style.cursor = 'pointer';

        img.addEventListener('click', function () {
            if (this.style.transform === 'scale(1.5)') {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            } else {
                this.style.transform = 'scale(1.5)';
                this.style.zIndex = '100';
            }
        });
    });

    // ============================================
    // Efecto de aumento de tamaño en precios
    // ============================================
    document.querySelectorAll('.property-price, .propiedad-precio').forEach(precio => {
        precio.addEventListener('mouseenter', function () {
            this.style.fontSize = '1.8rem';
            this.style.transition = 'font-size 0.3s ease';
        });

        precio.addEventListener('mouseleave', function () {
            this.style.fontSize = '1.5rem';
        });
    });
})();
