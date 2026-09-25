<?php 

include_once '../conexion.php'; 

// Verificar que se recibió el CI
if (!isset($_GET['CI']) || trim($_GET['CI']) === '') { 
    echo "Error: no se especificó el CI del usuario."; 
    exit; 
} 

$idCI = trim($_GET['CI']); 

// Consulta preparada
$sql = "DELETE FROM usuarios WHERE CI = ?"; 
$stmt = $conn->prepare($sql); 

if (!$stmt) { 
    echo "Error al preparar la consulta: " . $conn->error; 
    exit; 
} 

$stmt->bind_param("s", $idCI); 

if ($stmt->execute()) { 

    if ($stmt->affected_rows > 0) { 
        echo "Usuario eliminado exitosamente."; 
    } else { 
        echo "No se encontró el usuario o ya fue eliminado."; 
    } 

} else { 
    echo "Error al eliminar el usuario: " . $stmt->error; 
} 

$stmt->close(); 
$conn->close(); 

?>