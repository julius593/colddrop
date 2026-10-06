<?php
// ========================================================
// ACTUALIZAR PRODUCTO CON PROTOCOLOS DE SEGURIDAD (CASAACTUALIZARPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

// Protocolo Seguridad Inyección SQL: real_escape_string
$Codigo = isset($_POST['Codigo']) ? $conexion->real_escape_string(trim($_POST['Codigo'])) : '';
$Nombre = isset($_POST['Nombre']) ? $conexion->real_escape_string(trim($_POST['Nombre'])) : '';
$Tipo = isset($_POST['Tipo']) ? $conexion->real_escape_string(trim($_POST['Tipo'])) : '';
$Talla = isset($_POST['Talla']) ? $conexion->real_escape_string(trim($_POST['Talla'])) : '';
$Color = isset($_POST['Color']) ? $conexion->real_escape_string(trim($_POST['Color'])) : '';
$Costo = isset($_POST['Costo']) ? $conexion->real_escape_string(trim($_POST['Costo'])) : '0';
$Stock = isset($_POST['Stock']) ? $conexion->real_escape_string(trim($_POST['Stock'])) : '0';
$Imagen = isset($_POST['Imagen']) ? $conexion->real_escape_string(trim($_POST['Imagen'])) : '';

// Protocolo Seguridad Inyección PHP en Archivos: Validar extensiones de imagen
if (isset($_FILES['ImagenFile']) && $_FILES['ImagenFile']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = basename($_FILES['ImagenFile']['name']);
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    $extensionesPermitidas = array('jpg', 'jpeg', 'png', 'webp', 'gif');

    if (in_array($extension, $extensionesPermitidas)) {
        $nombreSeguro = preg_replace("/[^a-zA-Z0-9._-]/", "_", $nombreArchivo);
        $rutaDestino = "../imagenes/" . $nombreSeguro;
        if (move_uploaded_file($_FILES['ImagenFile']['tmp_name'], $rutaDestino)) {
            $Imagen = $nombreSeguro;
        }
    }
}

if (!empty($Imagen)) {
    $sql = "UPDATE productos SET Nombre='$Nombre', Tipo='$Tipo', Talla='$Talla', Color='$Color', Costo='$Costo', Stock='$Stock', Imagen='$Imagen' WHERE Codigo='$Codigo'";
} else {
    $sql = "UPDATE productos SET Nombre='$Nombre', Tipo='$Tipo', Talla='$Talla', Color='$Color', Costo='$Costo', Stock='$Stock' WHERE Codigo='$Codigo'";
}

if ($conexion->query($sql) === TRUE) {
    header("Location: leerproductos.php");
    exit();
} else {
    echo "Error al actualizar producto: " . htmlspecialchars($conexion->error);
}
?>