<?php
/**
 * Configuración de conexión a la Base de Datos
 * Inmobiliaria Crescendolls
 * 
 * INSTRUCCIONES:
 * 1. Copia este archivo y renómbralo a "config.php"
 * 2. Modifica las credenciales según tu entorno
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');           // Servidor de base de datos
define('DB_USER', 'tu_usuario');          // Usuario de MySQL
define('DB_PASS', 'tu_contraseña');       // Contraseña de MySQL
define('DB_NAME', 'inmobiliaria_db');     // Nombre de la base de datos

// Crear conexión
function conectarDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Configurar charset UTF-8
    $conn->set_charset("utf8");
    
    return $conn;
}

// Función para cerrar conexión
function cerrarDB($conn) {
    if ($conn) {
        $conn->close();
    }
}

// Función para sanitizar datos
function limpiarDato($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}
?>

