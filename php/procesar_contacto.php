<?php
require_once 'config.php';

// Verificar que sea una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Conectar a la base de datos
    $conn = conectarDB();
    
    // Obtener y limpiar datos del formulario
    $propiedad_id = isset($_POST['propiedad_id']) ? intval($_POST['propiedad_id']) : 0;
    $nombre = isset($_POST['nombre']) ? limpiarDato($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? limpiarDato($_POST['email']) : '';
    $telefono = isset($_POST['telefono']) ? limpiarDato($_POST['telefono']) : '';
    $tipo_interes = isset($_POST['tipo_interes']) ? limpiarDato($_POST['tipo_interes']) : 'informacion';
    $mensaje = isset($_POST['mensaje']) ? limpiarDato($_POST['mensaje']) : '';
    
    // Validar datos requeridos
    if ($propiedad_id <= 0 || empty($nombre) || empty($email)) {
        header("Location: propiedades.php?error=datos_incompletos");
        exit();
    }
    
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: propiedades.php?error=email_invalido");
        exit();
    }
    
    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO solicitudes_contacto (propiedad_id, nombre_cliente, email, telefono, tipo_interes, mensaje) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        // Vincular parámetros
        $stmt->bind_param("isssss", $propiedad_id, $nombre, $email, $telefono, $tipo_interes, $mensaje);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito - Redirigir con mensaje de éxito
            $stmt->close();
            cerrarDB($conn);
            header("Location: propiedades.php?exito=1");
            exit();
        } else {
            // Error al ejecutar
            $stmt->close();
            cerrarDB($conn);
            header("Location: propiedades.php?error=al_guardar");
            exit();
        }
    } else {
        // Error al preparar la consulta
        cerrarDB($conn);
        header("Location: propiedades.php?error=preparacion");
        exit();
    }
    
} else {
    // Si no es POST, redirigir a propiedades
    header("Location: propiedades.php");
    exit();
}
?>

