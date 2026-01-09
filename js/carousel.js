// ============================================
// Carrusel del hero y modal de propiedades
// ============================================

// ============================================
// Carrusel del hero
// ============================================
(function () {
    'use strict';

    const heroSlides = document.querySelectorAll('.carousel-slide');
    const heroDots = document.querySelectorAll('.carousel-dots .dot');
    const progressBar = document.querySelector('.progress-bar');

    // Verificar que existan los elementos del carrusel
    if (heroSlides.length === 0) return;

    let heroSlideIndex = 0;
    let heroAutoPlay;
    const slideInterval = 6000;

    function showHeroSlide(index) {
        if (index >= heroSlides.length) heroSlideIndex = 0;
        if (index < 0) heroSlideIndex = heroSlides.length - 1;

        heroSlides.forEach(slide => slide.classList.remove('active'));
        heroDots.forEach(dot => dot.classList.remove('active'));

        heroSlides[heroSlideIndex].classList.add('active');
        if (heroDots[heroSlideIndex]) {
            heroDots[heroSlideIndex].classList.add('active');
        }

        resetProgressBar();
    }

    function resetProgressBar() {
        if (progressBar) {
            progressBar.style.animation = 'none';
            progressBar.offsetHeight;
            progressBar.style.animation = `progressAnim ${slideInterval}ms linear`;
        }
    }

    function goToHeroSlide(index) {
        heroSlideIndex = index;
        showHeroSlide(heroSlideIndex);
        resetHeroAutoPlay();
    }

    function startHeroAutoPlay() {
        resetProgressBar();
        heroAutoPlay = setInterval(() => {
            heroSlideIndex++;
            showHeroSlide(heroSlideIndex);
        }, slideInterval);
    }

    function resetHeroAutoPlay() {
        clearInterval(heroAutoPlay);
        startHeroAutoPlay();
    }

    // Event listeners para los dots
    heroDots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToHeroSlide(index));
    });

    // Iniciar autoplay
    startHeroAutoPlay();
})();

// ============================================
//Modal de propiedades
// ============================================
const properties = [
    {
        title: "Casa Moderna",
        price: "$8,000,000 MXN",
        details: "4 dormitorios · 3 baños · 300m² · Estacionamiento 2 autos",
        description: "Hermosa casa moderna ubicada en una de las mejores zonas residenciales de la CDMX. Cuenta con amplios espacios, acabados de lujo, cocina integral equipada, jardín privado y sistema de seguridad. Perfecta para familias que buscan comodidad y estilo.",
        images: ["img/propiedades/propiedad1.webp", "img/propiedades/propiedad1.1.webp", "img/propiedades/propiedad1.2.webp", "img/propiedades/propiedad1.3.webp"]
    },
    {
        title: "Apartamento Centro",
        price: "$1,000,000 MXN",
        details: "2 dormitorios · 1 baño · 80m² · Balcón",
        description: "Elegante apartamento en el corazón de la ciudad con excelente ubicación cerca de transporte público, restaurantes y centros comerciales. Ideal para profesionales o parejas que buscan vivir en el centro de todo.",
        images: ["img/propiedades/propiedad2.webp", "img/propiedades/propiedad2.1.webp", "img/propiedades/propiedad2.2.webp", "img/propiedades/propiedad2.3.webp"]
    },
    {
        title: "Casa de Lujo",
        price: "$30,000,000 MXN",
        details: "5 dormitorios · 4 baños · 500m² · Alberca · Gimnasio",
        description: "Espectacular residencia de lujo con arquitectura contemporánea. Incluye alberca climatizada, gimnasio privado, cine en casa, bodega de vinos y jardín con área de asador. Una propiedad única para los más exigentes.",
        images: ["img/propiedades/propiedad3.webp", "img/propiedades/propiedad3.1.webp", "img/propiedades/propiedad3.2.webp", "img/propiedades/propiedad3.3.webp"]
    }
];

let propertySlideIndex = 0;

function openPropertyModal(propertyIndex) {
    const property = properties[propertyIndex];
    const modal = document.getElementById('propertyModal');
    const slidesContainer = document.getElementById('propertySlides');

    if (!modal || !slidesContainer || !property) return;

    document.getElementById('modalPropertyTitle').textContent = property.title;
    document.getElementById('modalPropertyPrice').textContent = property.price;
    document.getElementById('modalPropertyDetails').textContent = property.details;
    document.getElementById('modalPropertyDescription').textContent = property.description;

    propertySlideIndex = 0;

    slidesContainer.innerHTML = '';
    property.images.forEach((imgSrc, index) => {
        const slide = document.createElement('div');
        slide.className = `property-slide ${index === 0 ? 'active' : ''}`;
        slide.innerHTML = `<img src="${imgSrc}" alt="${property.title} - Imagen ${index + 1}">`;
        slidesContainer.appendChild(slide);
    });

    document.getElementById('currentSlide').textContent = '1';
    document.getElementById('totalSlides').textContent = property.images.length;

    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closePropertyModal() {
    const modal = document.getElementById('propertyModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function changePropertySlide(direction) {
    const slides = document.querySelectorAll('.property-slide');
    if (slides.length === 0) return;

    propertySlideIndex += direction;

    if (propertySlideIndex >= slides.length) propertySlideIndex = 0;
    if (propertySlideIndex < 0) propertySlideIndex = slides.length - 1;

    slides.forEach(slide => slide.classList.remove('active'));
    slides[propertySlideIndex].classList.add('active');

    const currentSlideEl = document.getElementById('currentSlide');
    if (currentSlideEl) {
        currentSlideEl.textContent = propertySlideIndex + 1;
    }
}

// Event listeners para el modal de propiedades
(function () {
    'use strict';

    const propertyModal = document.getElementById('propertyModal');

    if (propertyModal) {
        propertyModal.addEventListener('click', function (e) {
            if (e.target === this) closePropertyModal();
        });
    }

    // Cerrar con Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closePropertyModal();
        }
    });
})();

