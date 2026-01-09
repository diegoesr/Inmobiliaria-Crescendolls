<?php
require_once 'config.php';

// Conectar a la base de datos
$conn = conectarDB();

// Obtener todas las propiedades disponibles
$sql = "SELECT * FROM propiedades WHERE disponible = TRUE ORDER BY fecha_registro DESC";
$resultado = $conn->query($sql);

// Guardar propiedades en array para JavaScript
$propiedadesArray = [];
if ($resultado && $resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $propiedadesArray[] = $row;
    }
    // Reiniciar el puntero
    $resultado->data_seek(0);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Propiedades - Inmobiliaria Crescendolls</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- AOS.js - Animate On Scroll -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css?v=9.6">
</head>
<body>

  <header>
    <div class="container header-content">
      <button class="dark-mode-toggle" id="darkModeToggle" title="Cambiar tema">
        <i class="fas fa-moon" id="darkModeIcon"></i>
      </button>
      
      <h1 class="logo"><i class="fas fa-building"></i> Inmobiliaria Crescendolls</h1>
      
      <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
      
      <nav id="navMenu">
        <a href="../index.html">Inicio</a>
        <a href="../nosotros.html">Nosotros</a>       
        <a href="propiedades.php">Propiedades</a>
        <a href="contacto.php">Contacto</a>
      </nav>
      
      <button class="favorites-toggle" id="favoritesToggle" title="Ver favoritos">
        <i class="fas fa-heart"></i>
        <span class="favorites-count" id="favoritesCount">0</span>
      </button>
    </div>
  </header>

  <!-- Hero de Propiedades -->
  <section class="propiedades-hero">
    <div class="container">
      <h1 class="page-title"><i class="fas fa-home"></i> Nuestras Propiedades</h1>
      <p class="page-subtitle">Encuentra la propiedad perfecta para ti</p>
    </div>
  </section>

  <!-- Listado de Propiedades -->
  <section class="propiedades-section">
    <div class="container">
      
      <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          <strong>¡Solicitud enviada con éxito!</strong> Nos pondremos en contacto contigo pronto.
        </div>
      <?php endif; ?>
      
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
          <i class="fas fa-exclamation-circle"></i>
          <strong>Error:</strong> No se pudo procesar tu solicitud. Por favor, intenta nuevamente.
        </div>
      <?php endif; ?>
      
      <div class="propiedades-header">
        <h2 class="section-title">Propiedades Disponibles</h2>
        <a href="reportes.php" class="btn btn-reporte">
          <i class="fas fa-file-alt"></i> Ver Reportes
        </a>
      </div>

      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <div class="grid grid-3">
          <?php 
          $index = 0;
          while($propiedad = $resultado->fetch_assoc()): 
          ?>
            <div class="propiedad-card propiedad-clickable" onclick="abrirVistaPropiedad(<?php echo $index; ?>)">
              <div class="propiedad-imagen">
                <img src="../<?php echo htmlspecialchars($propiedad['imagen']); ?>" 
                     alt="<?php echo htmlspecialchars($propiedad['nombre']); ?>">
                <span class="propiedad-tipo"><?php echo htmlspecialchars($propiedad['tipo']); ?></span>
                <div class="propiedad-overlay-hover">
                  <i class="fas fa-search-plus"></i>
                  <span>Ver galería</span>
                </div>
              </div>
              
              <div class="propiedad-body">
                <div class="card-header-row">
                  <h3><i class="fas fa-home"></i> <?php echo htmlspecialchars($propiedad['nombre']); ?></h3>
                  <button class="favorite-btn" 
                          data-id="<?php echo $propiedad['id']; ?>"
                          onclick="toggleFavorite(event, <?php echo $propiedad['id']; ?>, '<?php echo htmlspecialchars($propiedad['nombre'], ENT_QUOTES); ?>', '../<?php echo htmlspecialchars($propiedad['imagen']); ?>', '$<?php echo number_format($propiedad['precio'], 0); ?> MXN')">
                    <i class="far fa-heart"></i>
                  </button>
                </div>
                <p class="propiedad-descripcion"><?php echo htmlspecialchars($propiedad['descripcion']); ?></p>
                
                <div class="propiedad-detalles">
                  <span><i class="fas fa-bed"></i> <?php echo $propiedad['habitaciones']; ?> hab.</span>
                  <span><i class="fas fa-bath"></i> <?php echo $propiedad['banos']; ?> baños</span>
                  <span><i class="fas fa-ruler-combined"></i> <?php echo $propiedad['metros_cuadrados']; ?>m²</span>
                </div>
                
                <p class="propiedad-precio">
                  $<?php echo number_format($propiedad['precio'], 0); ?> MXN
                </p>
              </div>
            </div>
          <?php 
          $index++;
          endwhile; 
          ?>
        </div>
      <?php else: ?>
        <div class="no-propiedades">
          <i class="fas fa-home"></i>
          <p>No hay propiedades disponibles en este momento.</p>
        </div>
      <?php endif; ?>

      <?php cerrarDB($conn); ?>
    </div>
  </section>

  <!-- Modal de Vista de Propiedad con Carrusel -->
  <div id="modalVistaPropiedad" class="property-modal">
    <div class="property-modal-content">
      <button class="modal-close" onclick="cerrarVistaPropiedad()">
        <i class="fas fa-times"></i>
      </button>
      
      <!-- Carrusel de imágenes -->
      <div class="property-carousel">
        <div class="property-slides" id="propertySlides">
          <!-- Imágenes cargadas dinámicamente -->
        </div>
        <button class="property-carousel-btn prev" onclick="cambiarSlide(-1)">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="property-carousel-btn next" onclick="cambiarSlide(1)">
          <i class="fas fa-chevron-right"></i>
        </button>
        <div class="property-carousel-counter">
          <span id="slideActual">1</span> / <span id="slideTotal">1</span>
        </div>
      </div>
      
      <!-- Información de la propiedad -->
      <div class="property-modal-info">
        <span class="modal-tipo-badge" id="modalTipo">Tipo</span>
        <h2 id="modalTitulo">Título</h2>
        <p class="modal-property-price" id="modalPrecio">$0 MXN</p>
        <div class="modal-property-details" id="modalDetalles"></div>
        <p class="modal-property-description" id="modalDescripcion"></p>
        <button class="btn btn-modal" onclick="abrirFormularioContacto()">
          <i class="fas fa-envelope"></i> Solicitar Información
        </button>
      </div>
    </div>
  </div>

  <!-- Modal de Contacto -->
  <div id="modalContacto" class="modal">
    <div class="modal-content">
      <span class="close" onclick="cerrarModalContacto()">&times;</span>
      <h2><i class="fas fa-envelope"></i> Solicitar Información</h2>
      <p id="propiedadNombre" class="modal-propiedad"></p>
      
      <form id="formContacto" action="procesar_contacto.php" method="POST">
        <input type="hidden" id="propiedad_id" name="propiedad_id" value="">
        
        <div class="form-group">
          <label for="nombre"><i class="fas fa-user"></i> Nombre Completo *</label>
          <input type="text" id="nombre" name="nombre" required>
        </div>
        
        <div class="form-group">
          <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico *</label>
          <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
          <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
          <input type="tel" id="telefono" name="telefono" placeholder="Opcional">
        </div>
        
        <div class="form-group">
          <label><i class="fas fa-calendar"></i> ¿Cuándo desea realizar la operación? *</label>
          <div class="radio-group">
            <label class="radio-label">
              <input type="radio" name="tiempo" value="inmediato" required checked>
              <span>Inmediatamente</span>
            </label>
            <label class="radio-label">
              <input type="radio" name="tiempo" value="1-3meses" required>
              <span>En 1-3 meses</span>
            </label>
            <label class="radio-label">
              <input type="radio" name="tiempo" value="mas3meses" required>
              <span>Más de 3 meses</span>
            </label>
          </div>
        </div>
        
        <div class="form-group">
          <label for="tipo_interes"><i class="fas fa-clipboard-list"></i> Tipo de Interés *</label>
          <select id="tipo_interes" name="tipo_interes" required>
            <option value="">Seleccione una opción</option>
            <option value="compra">Compra</option>
            <option value="renta">Renta</option>
            <option value="informacion">Más información</option>
          </select>
        </div>
        
        <div class="form-group">
          <label><i class="fas fa-building"></i> Características de interés</label>
          <div class="checkbox-group">
            <label class="checkbox-label">
              <input type="checkbox" name="caracteristicas[]" value="estacionamiento">
              <span>Estacionamiento</span>
            </label>
            <label class="checkbox-label">
              <input type="checkbox" name="caracteristicas[]" value="jardin">
              <span>Jardín</span>
            </label>
            <label class="checkbox-label">
              <input type="checkbox" name="caracteristicas[]" value="seguridad">
              <span>Seguridad 24/7</span>
            </label>
            <label class="checkbox-label">
              <input type="checkbox" name="caracteristicas[]" value="amenidades">
              <span>Amenidades</span>
            </label>
          </div>
        </div>
        
        <div class="form-group">
          <label for="mensaje"><i class="fas fa-comment"></i> Mensaje</label>
          <textarea id="mensaje" name="mensaje" rows="4" placeholder="Cuéntanos sobre tus necesidades..."></textarea>
        </div>
        
        <div class="form-group">
          <label class="checkbox-label">
            <input type="checkbox" name="acepto_contacto" required>
            <span>Acepto ser contactado para recibir información sobre esta propiedad *</span>
          </label>
        </div>
        
        <button type="submit" class="btn btn-submit">
          <i class="fas fa-paper-plane"></i> Enviar Solicitud
        </button>
      </form>
    </div>
  </div>

  <!-- Modal de Favoritos -->
  <div id="favoritesModal" class="favorites-modal">
    <div class="favorites-modal-content">
      <div class="favorites-header">
        <h2><i class="fas fa-heart"></i> Mis Favoritos</h2>
        <button class="modal-close" onclick="closeFavoritesModal()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="favorites-list" id="favoritesList">
        <!-- Lista de favoritos cargada dinámicamente -->
      </div>
      <div class="favorites-empty" id="favoritesEmpty">
        <i class="far fa-heart"></i>
        <p>No tienes propiedades favoritas</p>
        <span>Haz clic en el corazón de una propiedad para agregarla</span>
      </div>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2025 Inmobiliaria Crescendolls. Todos los derechos reservados.</p>
  </footer>

  <!-- Scripts modulares -->
  <script src="../js/utils.js"></script>
  <script src="../js/app.js"></script>
  <script src="../js/dark-mode.js"></script>
  <script src="../js/favorites.js"></script>
  <script>
    // Datos de propiedades desde PHP
    const propiedades = <?php echo json_encode($propiedadesArray); ?>;
    
    // Imágenes adicionales para el carrusel - usando las mismas que en index.html
    const imagenesExtra = [
      '../img/propiedades/propiedad1.webp', 
      '../img/propiedades/propiedad1.1.webp', 
      '../img/propiedades/propiedad1.2.webp', 
      '../img/propiedades/propiedad1.3.webp',
      '../img/propiedades/propiedad2.webp', 
      '../img/propiedades/propiedad2.1.webp', 
      '../img/propiedades/propiedad2.2.webp', 
      '../img/propiedades/propiedad2.3.webp',
      '../img/propiedades/propiedad3.webp', 
      '../img/propiedades/propiedad3.1.webp', 
      '../img/propiedades/propiedad3.2.webp', 
      '../img/propiedades/propiedad3.3.webp'
    ];
    
    // Mapeo de imágenes específicas para todas las propiedades
    // Nota: Usar el nombre exacto de la base de datos
    const imagenesPorPropiedad = {
      // Propiedades destacadas (coinciden con index.html)
      'Casa Moderna': [
        '../img/propiedades/propiedad1.webp',
        '../img/propiedades/propiedad1.1.webp',
        '../img/propiedades/propiedad1.2.webp',
        '../img/propiedades/propiedad1.3.webp'
      ],
      'Departamento Centro': [  // Nombre en la BD (coincide con "Apartamento Centro" de index.html)
        '../img/propiedades/propiedad2.webp',
        '../img/propiedades/propiedad2.1.webp',
        '../img/propiedades/propiedad2.2.webp',
        '../img/propiedades/propiedad2.3.webp'
      ],
      'Casa de Lujo': [
        '../img/propiedades/propiedad3.webp',
        '../img/propiedades/propiedad3.1.webp',
        '../img/propiedades/propiedad3.2.webp',
        '../img/propiedades/propiedad3.3.webp'
      ],
      // Otras propiedades - Agrega aquí las imágenes para cada propiedad
      'Departamento Familiar': [
        '../img/propiedades/propiedad4.webp',
        '../img/propiedades/propiedad4.1.webp',
        '../img/propiedades/propiedad4.2.webp',
        '../img/propiedades/propiedad4.3.webp'
      ],
      'Casa Colonial': [
        '../img/propiedades/propiedad5.webp',
        '../img/propiedades/propiedad5.1.webp',
        '../img/propiedades/propiedad5.2.webp',
        '../img/propiedades/propiedad5.3.webp'
      ],
      'Penthouse Ejecutivo': [
        '../img/propiedades/propiedad6.webp',
        '../img/propiedades/propiedad6.1.webp',
        '../img/propiedades/propiedad6.2.webp',
        '../img/propiedades/propiedad6.3.webp'
      ]
    };
    
    let slideActual = 0;
    let propiedadActual = null;
    
    // ============================================
    // MODAL DE VISTA DE PROPIEDAD CON CARRUSEL
    // ============================================
    function abrirVistaPropiedad(index) {
      propiedadActual = propiedades[index];
      const modal = document.getElementById('modalVistaPropiedad');
      const slidesContainer = document.getElementById('propertySlides');
      
      // Cargar información
      document.getElementById('modalTitulo').textContent = propiedadActual.nombre;
      document.getElementById('modalPrecio').textContent = '$' + Number(propiedadActual.precio).toLocaleString('es-MX') + ' MXN';
      document.getElementById('modalTipo').textContent = propiedadActual.tipo;
      document.getElementById('modalDescripcion').textContent = propiedadActual.descripcion;
      document.getElementById('modalDetalles').innerHTML = `
        <span><i class="fas fa-bed"></i> ${propiedadActual.habitaciones} habitaciones</span>
        <span><i class="fas fa-bath"></i> ${propiedadActual.banos} baños</span>
        <span><i class="fas fa-ruler-combined"></i> ${propiedadActual.metros_cuadrados}m²</span>
      `;
      
      // Crear array de imágenes - usar imágenes específicas si existen, sino usar imagen principal + extras
      let imagenes = [];
      
      // Verificar si hay imágenes específicas para esta propiedad (propiedades destacadas)
      if (imagenesPorPropiedad[propiedadActual.nombre]) {
        imagenes = imagenesPorPropiedad[propiedadActual.nombre];
      } else {
        // Para otras propiedades, usar imagen principal + extras relacionadas
        imagenes = ['../' + propiedadActual.imagen];
        const extrasAleatorias = imagenesExtra.filter(img => !img.includes(propiedadActual.imagen)).slice(0, 4);
        imagenes = imagenes.concat(extrasAleatorias);
      }
      
      // Cargar imágenes en el carrusel
      slideActual = 0;
      slidesContainer.innerHTML = '';
      imagenes.forEach((imgSrc, i) => {
        const slide = document.createElement('div');
        slide.className = `property-slide ${i === 0 ? 'active' : ''}`;
        slide.innerHTML = `<img src="${imgSrc}" alt="${propiedadActual.nombre} - Imagen ${i + 1}">`;
        slidesContainer.appendChild(slide);
      });
      
      // Actualizar contador
      document.getElementById('slideActual').textContent = '1';
      document.getElementById('slideTotal').textContent = imagenes.length;
      
      // Mostrar modal
      modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
    
    function cerrarVistaPropiedad() {
      document.getElementById('modalVistaPropiedad').classList.remove('active');
      document.body.style.overflow = 'auto';
    }
    
    function cambiarSlide(direccion) {
      const slides = document.querySelectorAll('#propertySlides .property-slide');
      slideActual += direccion;
      
      if (slideActual >= slides.length) slideActual = 0;
      if (slideActual < 0) slideActual = slides.length - 1;
      
      slides.forEach(slide => slide.classList.remove('active'));
      slides[slideActual].classList.add('active');
      
      document.getElementById('slideActual').textContent = slideActual + 1;
    }
    
    // Abrir formulario de contacto desde el modal de vista
    function abrirFormularioContacto() {
      cerrarVistaPropiedad();
      setTimeout(() => {
        document.getElementById('modalContacto').style.display = 'block';
        document.getElementById('propiedad_id').value = propiedadActual.id;
        document.getElementById('propiedadNombre').textContent = 'Propiedad: ' + propiedadActual.nombre;
        document.body.style.overflow = 'hidden';
      }, 300);
    }
    
    // ============================================
    // MODAL DE CONTACTO
    // ============================================
    function cerrarModalContacto() {
      document.getElementById('modalContacto').style.display = 'none';
      document.body.style.overflow = 'auto';
    }
    
    // Cerrar modales al hacer clic fuera
    document.getElementById('modalVistaPropiedad').addEventListener('click', function(e) {
      if (e.target === this) {
        cerrarVistaPropiedad();
      }
    });
    
    window.addEventListener('click', function(e) {
      const modalContacto = document.getElementById('modalContacto');
      if (e.target === modalContacto) {
        cerrarModalContacto();
      }
    });
    
    // Cerrar con tecla Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        cerrarVistaPropiedad();
        cerrarModalContacto();
      }
    });
    
    // Navegación con teclado en el carrusel
    document.addEventListener('keydown', function(e) {
      if (document.getElementById('modalVistaPropiedad').classList.contains('active')) {
        if (e.key === 'ArrowLeft') cambiarSlide(-1);
        if (e.key === 'ArrowRight') cambiarSlide(1);
      }
    });
    
    // Inicializar favoritos al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof updateFavoriteButtons === 'function') {
        updateFavoriteButtons();
      }
      if (typeof updateFavoritesCount === 'function') {
        updateFavoritesCount();
      }
    });
  </script>
</body>
</html>
