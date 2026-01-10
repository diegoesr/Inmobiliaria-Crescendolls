// ============================================
// Carga dinámica de propiedades para index.html
// ============================================

// Mapeo de imágenes adicionales para el carrusel de cada propiedad
const imagenesPorPropiedad = {
    'Casa Moderna': [
        'img/propiedades/propiedad1.webp',
        'img/propiedades/propiedad1.1.webp',
        'img/propiedades/propiedad1.2.webp',
        'img/propiedades/propiedad1.3.webp'
    ],
    'Departamento Centro': [
        'img/propiedades/propiedad2.webp',
        'img/propiedades/propiedad2.1.webp',
        'img/propiedades/propiedad2.2.webp',
        'img/propiedades/propiedad2.3.webp'
    ],
    'Casa de Lujo': [
        'img/propiedades/propiedad3.webp',
        'img/propiedades/propiedad3.1.webp',
        'img/propiedades/propiedad3.2.webp',
        'img/propiedades/propiedad3.3.webp'
    ],
    'Departamento Familiar': [
        'img/propiedades/propiedad4.webp',
        'img/propiedades/propiedad4.1.webp',
        'img/propiedades/propiedad4.2.webp',
        'img/propiedades/propiedad4.3.webp'
    ],
    'Casa Colonial': [
        'img/propiedades/propiedad5.webp',
        'img/propiedades/propiedad5.1.webp',
        'img/propiedades/propiedad5.2.webp',
        'img/propiedades/propiedad5.3.webp'
    ],
    'Penthouse Ejecutivo': [
        'img/propiedades/propiedad6.webp',
        'img/propiedades/propiedad6.1.webp',
        'img/propiedades/propiedad6.2.webp',
        'img/propiedades/propiedad6.3.webp'
    ]
};

// Almacenar propiedades cargadas
let propiedadesCargadas = [];
// Nota: propertySlideIndex está declarada en carousel.js, no redeclarar aquí

/**
 * Formatear precio con separadores de miles
 */
function formatearPrecio(precio) {
    return '$' + Number(precio).toLocaleString('es-MX') + ' MXN';
}

/**
 * Obtener icono según el tipo de propiedad
 */
function obtenerIconoTipo(tipo) {
    const iconos = {
        'Casa': 'fa-house',
        'Departamento': 'fa-building',
        'Penthouse': 'fa-gem'
    };
    
    for (let key in iconos) {
        if (tipo.includes(key)) {
            return iconos[key];
        }
    }
    return 'fa-home';
}

/**
 * Renderizar propiedades en el contenedor
 */
function renderizarPropiedades(propiedades) {
    const container = document.getElementById('propiedadesContainer');
    
    if (!container) {
        console.error('No se encontró el contenedor de propiedades');
        return;
    }
    
    // Limpiar contenedor
    container.innerHTML = '';
    
    if (propiedades.length === 0) {
        container.innerHTML = `
            <div class="no-propiedades" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <i class="fas fa-home" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <p>No hay propiedades disponibles en este momento.</p>
            </div>
        `;
        return;
    }
    
    // Renderizar cada propiedad
    propiedades.forEach((propiedad, index) => {
        const imagen = propiedad.imagen.startsWith('img/') 
            ? propiedad.imagen 
            : 'img/' + propiedad.imagen;
        
        const precioFormateado = formatearPrecio(propiedad.precio);
        const iconoTipo = obtenerIconoTipo(propiedad.tipo);
        
        const propiedadCard = document.createElement('div');
        propiedadCard.className = 'card property-card';
        propiedadCard.setAttribute('data-aos', 'fade-up');
        propiedadCard.setAttribute('data-aos-delay', (index + 1) * 100);
        propiedadCard.setAttribute('data-property-id', propiedad.id);
        
        propiedadCard.innerHTML = `
            <div class="card-image-container" onclick="openPropertyModal(${index})">
                <img src="${imagen}" alt="${propiedad.nombre}" onerror="this.src='img/propiedades/propiedad1.webp'">
                <div class="card-overlay">
                    <i class="fas fa-search-plus"></i>
                    <span>Ver detalles</span>
                </div>
            </div>
            <div class="card-body">
                <div class="card-header-row">
                    <h3><i class="fas ${iconoTipo}"></i> ${propiedad.nombre}</h3>
                    <button class="favorite-btn" data-id="${propiedad.id}"
                        onclick="toggleFavorite(event, ${propiedad.id}, '${propiedad.nombre.replace(/'/g, "\\'")}', '${imagen}', '${precioFormateado}')">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                <p>${propiedad.habitaciones || 0} dormitorios · ${propiedad.banos || 0} baños · ${propiedad.metros_cuadrados || 0}m²</p>
                <p class="property-price">${precioFormateado}</p>
            </div>
        `;
        
        container.appendChild(propiedadCard);
    });
    
    // Actualizar botones de favoritos
    if (typeof updateFavoriteButtons === 'function') {
        updateFavoriteButtons();
    }
    
    // Guardar propiedades para el modal
    propiedadesCargadas = propiedades;
}

/**
 * Cargar propiedades destacadas desde el API
 */
async function cargarPropiedadesDestacadas() {
    const container = document.getElementById('propiedadesContainer');
    
    if (!container) {
        console.error('No se encontró el contenedor de propiedades');
        return;
    }
    
    try {
        // Verificar si existe la función del API
        if (typeof window.API === 'undefined' || !window.API.obtenerPropiedadesDestacadas) {
            console.error('API no disponible');
            container.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--error-color);">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Error: No se pudo cargar el API. Verifica que el servidor esté funcionando.</p>
                </div>
            `;
            return;
        }
        
        // Mostrar loading
        container.innerHTML = `
            <div class="loading-properties" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary-color);"></i>
                <p style="margin-top: 1rem;">Cargando propiedades...</p>
            </div>
        `;
        
        // Obtener propiedades destacadas (máximo 3)
        console.log('Llamando a obtenerPropiedadesDestacadas...');
        const propiedades = await window.API.obtenerPropiedadesDestacadas(3);
        console.log('Propiedades recibidas:', propiedades);
        
        if (propiedades && propiedades.length > 0) {
            console.log(`Renderizando ${propiedades.length} propiedades`);
            renderizarPropiedades(propiedades);
        } else {
            console.warn('No se recibieron propiedades o el array está vacío');
            container.innerHTML = `
                <div class="no-propiedades" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fas fa-home" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                    <p>No hay propiedades destacadas disponibles.</p>
                    <p style="font-size: 0.9rem; color: #666; margin-top: 1rem;">
                        <a href="php/api.php?action=propiedades-destacadas&limit=3" target="_blank" style="color: #2563eb;">
                            Verificar API
                        </a>
                    </p>
                </div>
            `;
        }
        
    } catch (error) {
        console.error('Error al cargar propiedades:', error);
        container.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--error-color);">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Error al cargar las propiedades. Por favor, recarga la página.</p>
                <small>${error.message}</small>
            </div>
        `;
    }
}

/**
 * Abrir modal de propiedad (compatible con carousel.js)
 * Sobrescribe la función original para usar propiedades dinámicas
 */
function openPropertyModal(propertyIndex) {
    if (!propiedadesCargadas || propiedadesCargadas.length === 0) {
        console.error('No hay propiedades cargadas');
        return;
    }
    
    const propiedad = propiedadesCargadas[propertyIndex];
    if (!propiedad) {
        console.error('Propiedad no encontrada en el índice:', propertyIndex);
        return;
    }
    
    // Obtener imágenes para el carrusel
    let imagenes = [];
    if (imagenesPorPropiedad[propiedad.nombre]) {
        imagenes = imagenesPorPropiedad[propiedad.nombre];
    } else {
        // Usar imagen principal
        const imagenPrincipal = propiedad.imagen.startsWith('img/') 
            ? propiedad.imagen 
            : 'img/' + propiedad.imagen;
        imagenes = [imagenPrincipal];
    }
    
    // Crear objeto de propiedad compatible con carousel.js
    const propertyData = {
        title: propiedad.nombre,
        price: formatearPrecio(propiedad.precio),
        details: `${propiedad.habitaciones || 0} dormitorios · ${propiedad.banos || 0} baños · ${propiedad.metros_cuadrados || 0}m²`,
        description: propiedad.descripcion || 'Propiedad disponible en excelente ubicación.',
        images: imagenes
    };
    
    // Actualizar el array properties global para compatibilidad con carousel.js
    if (!window.properties) {
        window.properties = [];
    }
    
    // Agregar o actualizar la propiedad en el array
    let indexInProperties = window.properties.findIndex(p => p.title === propiedad.nombre);
    if (indexInProperties === -1) {
        window.properties.push(propertyData);
        indexInProperties = window.properties.length - 1;
    } else {
        window.properties[indexInProperties] = propertyData;
    }
    
    // Usar la función del modal directamente (similar a carousel.js)
    const modal = document.getElementById('propertyModal');
    const slidesContainer = document.getElementById('propertySlides');
    
    if (!modal || !slidesContainer) {
        console.error('No se encontró el modal de propiedades');
        return;
    }
    
    // Actualizar contenido del modal
    const titleEl = document.getElementById('modalPropertyTitle');
    const priceEl = document.getElementById('modalPropertyPrice');
    const detailsEl = document.getElementById('modalPropertyDetails');
    const descriptionEl = document.getElementById('modalPropertyDescription');
    
    if (titleEl) titleEl.textContent = propertyData.title;
    if (priceEl) priceEl.textContent = propertyData.price;
    if (detailsEl) detailsEl.textContent = propertyData.details;
    if (descriptionEl) descriptionEl.textContent = propertyData.description;
    
    // Configurar slides (usar la variable global de carousel.js)
    // carousel.js se carga antes, así que la variable ya existe globalmente
    if (typeof window.propertySlideIndex !== 'undefined') {
        window.propertySlideIndex = 0;
    } else if (typeof propertySlideIndex !== 'undefined') {
        propertySlideIndex = 0;
    }
    slidesContainer.innerHTML = '';
    propertyData.images.forEach((imgSrc, index) => {
        const slide = document.createElement('div');
        slide.className = `property-slide ${index === 0 ? 'active' : ''}`;
        slide.innerHTML = `<img src="${imgSrc}" alt="${propertyData.title} - Imagen ${index + 1}">`;
        slidesContainer.appendChild(slide);
    });
    
    // Actualizar contador
    const currentSlideEl = document.getElementById('currentSlide');
    const totalSlidesEl = document.getElementById('totalSlides');
    if (currentSlideEl) currentSlideEl.textContent = '1';
    if (totalSlidesEl) totalSlidesEl.textContent = propertyData.images.length;
    
    // Mostrar modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Cargar propiedades cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, iniciando carga de propiedades...');
    
    // Función para intentar cargar propiedades
    function intentarCargar() {
        console.log('Verificando API...', typeof window.API);
        
        if (typeof window.API !== 'undefined' && window.API.obtenerPropiedadesDestacadas) {
            console.log('API disponible, cargando propiedades...');
            cargarPropiedadesDestacadas();
        } else {
            console.warn('API no disponible aún, reintentando...');
            // Esperar un poco más si el API aún no está cargado
            setTimeout(() => {
                if (typeof window.API !== 'undefined' && window.API.obtenerPropiedadesDestacadas) {
                    console.log('API disponible después de esperar, cargando propiedades...');
                    cargarPropiedadesDestacadas();
                } else {
                    console.error('API no disponible después de esperar');
                    const container = document.getElementById('propiedadesContainer');
                    if (container) {
                        container.innerHTML = `
                            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #dc2626;">
                                <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                                <p style="font-weight: bold; margin-bottom: 0.5rem;">Error: No se pudo cargar el API</p>
                                <p style="font-size: 0.9rem; color: #666;">Verifica que:</p>
                                <ul style="text-align: left; display: inline-block; margin-top: 0.5rem;">
                                    <li>El archivo js/api.js esté incluido antes de propiedades.js</li>
                                    <li>El servidor PHP esté funcionando</li>
                                    <li>La base de datos esté conectada</li>
                                </ul>
                                <p style="margin-top: 1rem; font-size: 0.85rem;">
                                    <a href="php/api.php?action=propiedades-destacadas&limit=3" target="_blank" style="color: #2563eb;">
                                        Probar API directamente
                                    </a>
                                </p>
                            </div>
                        `;
                    }
                }
            }, 1000);
        }
    }
    
    // Intentar cargar inmediatamente
    intentarCargar();
});
