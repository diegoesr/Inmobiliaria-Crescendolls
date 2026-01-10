<?php
/**
 * API REST para Inmobiliaria Crescendolls
 * Endpoints disponibles:
 * - GET /api.php?action=propiedades - Obtener todas las propiedades
 * - GET /api.php?action=propiedad&id=X - Obtener una propiedad específica
 * - GET /api.php?action=propiedades-destacadas&limit=X - Obtener propiedades destacadas
 */

// Iniciar buffer de salida para evitar errores de headers
ob_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'config.php';

// Obtener la acción solicitada
$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    $conn = conectarDB();
    
    switch ($action) {
        case 'propiedades':
            // Obtener todas las propiedades disponibles
            $sql = "SELECT * FROM propiedades WHERE disponible = TRUE ORDER BY fecha_registro DESC";
            $resultado = $conn->query($sql);
            
            $propiedades = [];
            if ($resultado && $resultado->num_rows > 0) {
                while($row = $resultado->fetch_assoc()) {
                    // Formatear precio como número
                    $row['precio'] = floatval($row['precio']);
                    $propiedades[] = $row;
                }
            }
            
            ob_end_clean(); // Limpiar cualquier output accidental antes de enviar JSON
            echo json_encode([
                'success' => true,
                'data' => $propiedades,
                'count' => count($propiedades)
            ], JSON_UNESCAPED_UNICODE);
            exit();
            break;
            
        case 'propiedad':
            // Obtener una propiedad específica por ID
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            
            if ($id <= 0) {
                throw new Exception('ID de propiedad inválido');
            }
            
            $stmt = $conn->prepare("SELECT * FROM propiedades WHERE id = ? AND disponible = TRUE");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows > 0) {
                $propiedad = $resultado->fetch_assoc();
                $propiedad['precio'] = floatval($propiedad['precio']);
                
                ob_end_clean(); // Limpiar cualquier output accidental antes de enviar JSON
                echo json_encode([
                    'success' => true,
                    'data' => $propiedad
                ], JSON_UNESCAPED_UNICODE);
                exit();
            } else {
                throw new Exception('Propiedad no encontrada');
            }
            
            $stmt->close();
            break;
            
        case 'propiedades-destacadas':
            // Obtener propiedades destacadas (limitadas a 3 o 6)
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 3;
            $limit = max(1, min($limit, 20)); // Entre 1 y 20
            
            $stmt = $conn->prepare("SELECT * FROM propiedades WHERE disponible = TRUE ORDER BY fecha_registro DESC LIMIT ?");
            $stmt->bind_param("i", $limit);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            $propiedades = [];
            while($row = $resultado->fetch_assoc()) {
                $row['precio'] = floatval($row['precio']);
                $propiedades[] = $row;
            }
            
            ob_end_clean(); // Limpiar cualquier output accidental antes de enviar JSON
            echo json_encode([
                'success' => true,
                'data' => $propiedades,
                'count' => count($propiedades)
            ], JSON_UNESCAPED_UNICODE);
            exit();
            
            $stmt->close();
            break;
            
        default:
            throw new Exception('Acción no válida. Acciones disponibles: propiedades, propiedad, propiedades-destacadas');
    }
    
    cerrarDB($conn);
    
} catch (Exception $e) {
    ob_end_clean(); // Limpiar cualquier output accidental antes de enviar JSON
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    
    if (isset($conn)) {
        cerrarDB($conn);
    }
    exit();
}
