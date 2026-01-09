<?php
require_once 'config.php';

// Verificar que sea una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Conectar a la base de datos
    $conn = conectarDB();
    
    // Obtener y limpiar datos del formulario
    $nombre = isset($_POST['nombre']) ? limpiarDato($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? limpiarDato($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? limpiarDato($_POST['telefono']) : '';
    $asunto = isset($_POST['asunto']) ? limpiarDato($_POST['asunto']) : '';
    $mensaje = isset($_POST['mensaje']) ? limpiarDato($_POST['mensaje']) : '';
    
    // Validar datos requeridos
    if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
        header("Location: contacto.php?error=datos_incompletos");
        exit();
    }
    
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contacto.php?error=email_invalido");
        exit();
    }
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("sssss", $nombre, $email, $telefono, $asunto, $mensaje);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito - Redirigir con mensaje de éxito
            $stmt->close();
            cerrarDB($conn);
            header("Location: contacto.php?exito=1");
            exit();
        } else {
            // Error al ejecutar
            $stmt->close();
            cerrarDB($conn);
            header("Location: contacto.php?error=al_guardar");
            exit();
        }
    } else {
        // Error al preparar la consulta
        cerrarDB($conn);
        header("Location: contacto.php?error=preparacion");
        exit();
    }
    
} else {
    // Si no es POST, redirigir a contacto
    header("Location: contacto.php");
    exit();
}
?>



