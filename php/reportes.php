<?php
require_once 'config.php';

// Conectar a la base de datos
$conn = conectarDB();

// ============ SOLICITUDES DE PROPIEDADES ============
$sqlSolicitudes = "SELECT 
            s.id,
            s.nombre_cliente,
            s.email,
            s.telefono,
            s.tipo_interes,
            s.mensaje,
            s.fecha_solicitud,
            s.estado,
            p.nombre as propiedad_nombre,
            p.tipo as propiedad_tipo,
            p.precio as propiedad_precio
        FROM solicitudes_contacto s
        INNER JOIN propiedades p ON s.propiedad_id = p.id
        ORDER BY s.fecha_solicitud DESC";
$resultadoSolicitudes = $conn->query($sqlSolicitudes);

// Estadísticas de solicitudes
$sqlStatsSolicitudes = "SELECT 
                COUNT(*) as total_solicitudes,
                SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado = 'contactado' THEN 1 ELSE 0 END) as contactados,
                SUM(CASE WHEN estado = 'finalizado' THEN 1 ELSE 0 END) as finalizados
             FROM solicitudes_contacto";
$statsResultadoSolicitudes = $conn->query($sqlStatsSolicitudes);
$statsSolicitudes = $statsResultadoSolicitudes->fetch_assoc();

// ============ CONTACTOS GENERALES ============
$sqlContactos = "SELECT * FROM contactos ORDER BY fecha_contacto DESC";
$resultadoContactos = $conn->query($sqlContactos);

// Estadísticas de contactos
$sqlStatsContactos = "SELECT 
                COUNT(*) as total_contactos,
                SUM(CASE WHEN estado = 'nuevo' THEN 1 ELSE 0 END) as nuevos,
                SUM(CASE WHEN estado = 'leido' THEN 1 ELSE 0 END) as leidos,
                SUM(CASE WHEN estado = 'respondido' THEN 1 ELSE 0 END) as respondidos
             FROM contactos";
$statsResultadoContactos = $conn->query($sqlStatsContactos);
$statsContactos = $statsResultadoContactos->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes - Inmobiliaria Crescendolls</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- AOS.js - Animate On Scroll -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css?v=9.6">
  <style>
    /* Estilos específicos para esta página */
    .reportes-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .tab-btn {
        padding: 1rem 2rem;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 500;
        color: #6b7280;
        transition: all 0.3s;
    }
    
    .tab-btn.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
    }
    
    /* Dark mode para tabs */
    body.dark-mode .reportes-tabs {
        border-bottom-color: #3d4a66;
    }
    
    body.dark-mode .tab-btn {
        color: #9aa5bb;
    }
    
    body.dark-mode .tab-btn.active {
        color: var(--color-accent);
        border-bottom-color: var(--color-accent);
    }
    
    body.dark-mode .stat-card {
        background: var(--color-gray-100);
        border-color: var(--color-gray-200);
    }
    
    body.dark-mode .tabla-responsive {
        border-color: var(--color-gray-200);
    }
    
    body.dark-mode .tabla-reporte {
        background: var(--color-gray-100);
    }
    
    body.dark-mode .tabla-reporte td {
        color: #cbd5e1;
        border-bottom-color: var(--color-gray-200);
    }
    
    body.dark-mode .tabla-reporte tbody tr:hover {
        background: var(--color-gray-200);
    }
  </style>
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

  <!-- Hero del Reporte -->
  <section class="reporte-hero">
    <div class="container">
      <h1 class="page-title"><i class="fas fa-chart-bar"></i> Reportes Generales</h1>
      <p class="page-subtitle">Gestión de solicitudes y contactos</p>
    </div>
  </section>

  <!-- Contenido de Reportes -->
  <section class="reporte-section">
    <div class="container">
      
      <!-- Tabs -->
      <div class="reportes-tabs">
        <button class="tab-btn active" onclick="cambiarTab('solicitudes')">
          <i class="fas fa-home"></i> Solicitudes de Propiedades
        </button>
        <button class="tab-btn" onclick="cambiarTab('contactos')">
          <i class="fas fa-envelope"></i> Mensajes de Contacto
        </button>
      </div>

      <div class="reporte-header">
        <h2 class="section-title" id="titulo-reporte">Solicitudes de Propiedades</h2>
        <button onclick="window.print()" class="btn btn-print">
          <i class="fas fa-print"></i> Imprimir / Guardar PDF
        </button>
      </div>

      <!-- TAB 1: Solicitudes de Propiedades -->
      <div id="tab-solicitudes" class="tab-content active">
        
        <!-- Estadísticas Solicitudes -->
        <div class="stats-grid">
          <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsSolicitudes['total_solicitudes']; ?></h3>
              <p>Total Solicitudes</p>
            </div>
          </div>
          
          <div class="stat-card stat-pendiente">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsSolicitudes['pendientes']; ?></h3>
              <p>Pendientes</p>
            </div>
          </div>
          
          <div class="stat-card stat-contactado">
            <div class="stat-icon"><i class="fas fa-phone"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsSolicitudes['contactados']; ?></h3>
              <p>Contactados</p>
            </div>
          </div>
          
          <div class="stat-card stat-finalizado">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsSolicitudes['finalizados']; ?></h3>
              <p>Finalizados</p>
            </div>
          </div>
        </div>

        <?php if ($resultadoSolicitudes && $resultadoSolicitudes->num_rows > 0): ?>
          <div class="tabla-responsive">
            <table class="tabla-reporte">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Cliente</th>
                  <th>Contacto</th>
                  <th>Propiedad</th>
                  <th>Tipo de Interés</th>
                  <th>Estado</th>
                  <th>Mensaje</th>
                </tr>
              </thead>
              <tbody>
                <?php while($solicitud = $resultadoSolicitudes->fetch_assoc()): ?>
                  <tr>
                    <td><?php echo $solicitud['id']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_solicitud'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($solicitud['nombre_cliente']); ?></strong></td>
                    <td>
                      <div class="contacto-info">
                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($solicitud['email']); ?></span>
                        <?php if (!empty($solicitud['telefono'])): ?>
                          <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($solicitud['telefono']); ?></span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td>
                      <div class="propiedad-info">
                        <strong><?php echo htmlspecialchars($solicitud['propiedad_nombre']); ?></strong>
                        <span class="badge badge-tipo"><?php echo htmlspecialchars($solicitud['propiedad_tipo']); ?></span>
                        <span class="precio-small">$<?php echo number_format($solicitud['propiedad_precio'], 2); ?></span>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-<?php echo $solicitud['tipo_interes']; ?>">
                        <?php echo ucfirst($solicitud['tipo_interes']); ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-estado-<?php echo $solicitud['estado']; ?>">
                        <?php echo ucfirst($solicitud['estado']); ?>
                      </span>
                    </td>
                    <td class="mensaje-col">
                      <?php 
                        $mensaje = htmlspecialchars($solicitud['mensaje']);
                        echo !empty($mensaje) ? $mensaje : '<em>Sin mensaje</em>';
                      ?>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="no-datos">
            <i class="fas fa-inbox"></i>
            <p>No hay solicitudes registradas en este momento.</p>
          </div>
        <?php endif; ?>
      </div>

      <!-- TAB 2: Contactos -->
      <div id="tab-contactos" class="tab-content">
        
        <!-- Estadísticas Contactos -->
        <div class="stats-grid">
          <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsContactos['total_contactos']; ?></h3>
              <p>Total Mensajes</p>
            </div>
          </div>
          
          <div class="stat-card stat-pendiente">
            <div class="stat-icon"><i class="fas fa-envelope-open"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsContactos['nuevos']; ?></h3>
              <p>Nuevos</p>
            </div>
          </div>
          
          <div class="stat-card stat-contactado">
            <div class="stat-icon"><i class="fas fa-eye"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsContactos['leidos']; ?></h3>
              <p>Leídos</p>
            </div>
          </div>
          
          <div class="stat-card stat-finalizado">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
              <h3><?php echo $statsContactos['respondidos']; ?></h3>
              <p>Respondidos</p>
            </div>
          </div>
        </div>

        <?php if ($resultadoContactos && $resultadoContactos->num_rows > 0): ?>
          <div class="tabla-responsive">
            <table class="tabla-reporte">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Nombre</th>
                  <th>Contacto</th>
                  <th>Asunto</th>
                  <th>Mensaje</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                // Reset del puntero para recorrer de nuevo
                $resultadoContactos->data_seek(0);
                while($contacto = $resultadoContactos->fetch_assoc()): 
                ?>
                  <tr>
                    <td><?php echo $contacto['id']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($contacto['fecha_contacto'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($contacto['nombre']); ?></strong></td>
                    <td>
                      <div class="contacto-info">
                        <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($contacto['email']); ?></span>
                        <?php if (!empty($contacto['telefono'])): ?>
                          <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($contacto['telefono']); ?></span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td>
                      <strong><?php echo htmlspecialchars($contacto['asunto']); ?></strong>
                    </td>
                    <td class="mensaje-col">
                      <?php echo htmlspecialchars($contacto['mensaje']); ?>
                    </td>
                    <td>
                      <span class="badge badge-estado-<?php echo $contacto['estado']; ?>">
                        <?php echo ucfirst($contacto['estado']); ?>
                      </span>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="no-datos">
            <i class="fas fa-inbox"></i>
            <p>No hay mensajes de contacto registrados en este momento.</p>
          </div>
        <?php endif; ?>
      </div>

      <?php cerrarDB($conn); ?>
      
      <div class="reporte-footer">
        <a href="propiedades.php" class="btn">
          <i class="fas fa-arrow-left"></i> Volver a Propiedades
        </a>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>&copy; 2025 Inmobiliaria Crescendolls. Todos los derechos reservados.</p>
  </footer>

  <!-- Scripts modulares -->
  <script src="../js/app.js"></script>
  <script src="../js/dark-mode.js"></script>
  <script>
    // ============================================
    // TABS - Específico de reportes
    // ============================================
    function cambiarTab(tab) {
      // Ocultar todos los tabs
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
      });
      
      // Quitar active de todos los botones
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Mostrar el tab seleccionado
      if (tab === 'solicitudes') {
        document.getElementById('tab-solicitudes').classList.add('active');
        document.querySelector('.tab-btn:first-child').classList.add('active');
        document.getElementById('titulo-reporte').textContent = 'Solicitudes de Propiedades';
      } else if (tab === 'contactos') {
        document.getElementById('tab-contactos').classList.add('active');
        document.querySelector('.tab-btn:last-child').classList.add('active');
        document.getElementById('titulo-reporte').textContent = 'Mensajes de Contacto';
      }
    }
  </script>
</body>
</html>



