<?php 
// ========================================================
// GUARDAR NUEVO PRODUCTO CON PROTOCOLOS DE SEGURIDAD (CASACREARPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

// Protocolo Seguridad Inyección SQL: real_escape_string
$Codigo = isset($_POST['Codigo']) ? $conn->real_escape_string(trim($_POST['Codigo'])) : '';
$Nombre = isset($_POST['Nombre']) ? $conn->real_escape_string(trim($_POST['Nombre'])) : '';
$Tipo = isset($_POST['Tipo']) ? $conn->real_escape_string(trim($_POST['Tipo'])) : '';
$Talla = isset($_POST['Talla']) ? $conn->real_escape_string(trim($_POST['Talla'])) : '';
$Color = isset($_POST['Color']) ? $conn->real_escape_string(trim($_POST['Color'])) : '';
$Costo = isset($_POST['Costo']) ? $conn->real_escape_string(trim($_POST['Costo'])) : '0';
$Stock = isset($_POST['Stock']) ? $conn->real_escape_string(trim($_POST['Stock'])) : '0';
$Imagen = isset($_POST['Imagen']) ? $conn->real_escape_string(trim($_POST['Imagen'])) : '';

// Protocolo Seguridad Inyección PHP en Archivos: Validar extensión de imágenes permitidas
if (isset($_FILES['ImagenFile']) && $_FILES['ImagenFile']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = basename($_FILES['ImagenFile']['name']);
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    
    // Solo permitir extensiones de imagen seguras (bloquear .php, .phtml, etc.)
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'webp', 'gif');
    
    if (in_array($extension, $extensionesPermitidas)) {
        $nombreSeguro = preg_replace("/[^a-zA-Z0-9._-]/", "_", $nombreArchivo);
        $rutaDestino = "../imagenes/" . $nombreSeguro;
        if (move_uploaded_file($_FILES['ImagenFile']['tmp_name'], $rutaDestino)) {
            $Imagen = $nombreSeguro;
        }
    }
}

if (empty($Imagen)) {
    $Imagen = 'default.jpg';
}

$sql = "INSERT INTO productos (Codigo, Nombre, Tipo, Talla, Color, Costo, Stock, Imagen) 
        VALUES('$Codigo','$Nombre','$Tipo','$Talla', '$Color','$Costo','$Stock','$Imagen')";

if ($conn->query($sql) === TRUE) {
    header("Location: leerproductos.php");
    exit();
} else {
    echo "Error: " . htmlspecialchars($conn->error);
}
$conn->close();
?>
