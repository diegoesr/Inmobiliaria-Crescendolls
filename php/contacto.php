<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto - Inmobiliaria Crescendolls</title>
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
    </div>
  </header>

  <!-- Contacto -->
  <section class="contacto-hero">
    <div class="container">
      <h1 class="page-title"><i class="fas fa-envelope"></i> Contáctanos</h1>
      <p class="page-subtitle">Estamos aquí para ayudarte a encontrar tu hogar ideal</p>
    </div>
  </section>

  <!-- Sección de Contacto -->
  <section class="contacto-section">
    <div class="container">
      
      <?php if (isset($_GET['exito'])): ?>
        <div class="alert alert-success" style="background-color: #d1fae5; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
          <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.2rem;"></i>
          <strong style="color: #065f46;">¡Mensaje enviado con éxito!</strong> <span style="color: #047857;">Nos pondremos en contacto contigo pronto.</span>
        </div>
      <?php endif; ?>
      
      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error" style="background-color: #fee2e2; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
          <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 1.2rem;"></i>
          <strong style="color: #991b1b;">Error:</strong> <span style="color: #b91c1c;">No se pudo enviar tu mensaje. Por favor, intenta nuevamente.</span>
        </div>
      <?php endif; ?>

      <div class="contacto-grid">
        
        <!-- Formulario de Contacto -->
        <div class="contacto-form-container">
          <h2><i class="fas fa-paper-plane"></i> Envíanos un Mensaje</h2>
          <p>Completa el formulario y te responderemos a la brevedad</p>
          
          <form action="procesar_formulario_contacto.php" method="POST" class="contacto-form">
            
            <div class="form-group">
              <label for="nombre"><i class="fas fa-user"></i> Nombre Completo *</label>
              <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo">
            </div>
            
            <div class="form-group">
              <label for="email"><i class="fas fa-envelope"></i> Correo Electrónico *</label>
              <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>
            
            <div class="form-group">
              <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
              <input type="tel" id="telefono" name="telefono" placeholder="10 dígitos (opcional)">
            </div>
            
            <div class="form-group">
              <label><i class="fas fa-comments"></i> ¿Cómo prefiere ser contactado? *</label>
              <div class="radio-group">
                <label class="radio-label">
                  <input type="radio" name="metodo_contacto" value="email" required checked>
                  <span>Correo Electrónico</span>
                </label>
                <label class="radio-label">
                  <input type="radio" name="metodo_contacto" value="telefono" required>
                  <span>Teléfono</span>
                </label>
                <label class="radio-label">
                  <input type="radio" name="metodo_contacto" value="whatsapp" required>
                  <span>WhatsApp</span>
                </label>
              </div>
            </div>
            
            <div class="form-group">
              <label for="asunto"><i class="fas fa-tag"></i> Asunto *</label>
              <input type="text" id="asunto" name="asunto" required placeholder="¿Sobre qué quieres consultarnos?">
            </div>
            
            <div class="form-group">
              <label><i class="fas fa-clipboard-list"></i> Servicios de Interés</label>
              <div class="checkbox-group">
                <label class="checkbox-label">
                  <input type="checkbox" name="servicios[]" value="compra">
                  <span>Compra de Propiedad</span>
                </label>
                <label class="checkbox-label">
                  <input type="checkbox" name="servicios[]" value="venta">
                  <span>Venta de Propiedad</span>
                </label>
                <label class="checkbox-label">
                  <input type="checkbox" name="servicios[]" value="renta">
                  <span>Renta de Propiedad</span>
                </label>
                <label class="checkbox-label">
                  <input type="checkbox" name="servicios[]" value="asesoria">
                  <span>Asesoría Inmobiliaria</span>
                </label>
              </div>
            </div>
            
            <div class="form-group">
              <label for="mensaje"><i class="fas fa-comment"></i> Mensaje *</label>
              <textarea id="mensaje" name="mensaje" rows="6" required placeholder="Escribe tu mensaje aquí..."></textarea>
            </div>
            
            <div class="form-group">
              <label class="checkbox-label">
                <input type="checkbox" name="terminos" required>
                <span style="color: #374151;">Acepto los términos y condiciones y la política de privacidad *</span>
              </label>
            </div>
            
            <button type="submit" class="btn btn-submit">
              <i class="fas fa-paper-plane"></i> Enviar Mensaje
            </button>
          </form>
        </div>

        <!-- Información de Contacto -->
        <div class="contacto-info-container">
          <h2><i class="fas fa-info-circle"></i> Información de Contacto</h2>
          
          <div class="contacto-info-card">
            <div class="info-item">
              <i class="fas fa-map-marker-alt"></i>
              <div>
                <h3>Ubicación</h3>
                <p>Ciudad Universitaria<br>Coyoacán, CDMX</p>
              </div>
            </div>
            
            <div class="info-item">
              <i class="fas fa-phone"></i>
              <div>
                <h3>Teléfono</h3>
                <p>+52 55 1234 5678<br>+52 55 8765 4321</p>
              </div>
            </div>
            
            <div class="info-item">
              <i class="fas fa-envelope"></i>
              <div>
                <h3>Email</h3>
                <p>info@crescendolls.com<br>ventas@crescendolls.com</p>
              </div>
            </div>
            
            <div class="info-item">
              <i class="fas fa-clock"></i>
              <div>
                <h3>Horario de Atención</h3>
                <p>Lunes a Viernes: 9:00 - 18:00<br>Sábados: 10:00 - 14:00</p>
              </div>
            </div>
          </div>

          <!-- Enlace al reporte -->
          <div class="admin-section">
            <a href="reportes.php" class="btn btn-reporte">
              <i class="fas fa-file-alt"></i> Ver Reportes
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <footer class="footer">
    <p>&copy; 2025 Inmobiliaria Crescendolls. Todos los derechos reservados.</p>
  </footer>

  <!-- Scripts modulares -->
  <script src="../js/app.js"></script>
  <script src="../js/dark-mode.js"></script>
</body>
</html>

