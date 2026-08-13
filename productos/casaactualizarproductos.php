<?php
// ========================================================
// ACTUALIZAR DATOS DE PRODUCTO E IMAGEN (CASAACTUALIZARPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

$Codigo = isset($_POST['Codigo']) ? $_POST['Codigo'] : '';
$Nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : '';
$Tipo = isset($_POST['Tipo']) ? $_POST['Tipo'] : '';
$Talla = isset($_POST['Talla']) ? $_POST['Talla'] : '';
$Color = isset($_POST['Color']) ? $_POST['Color'] : '';
$Costo = isset($_POST['Costo']) ? $_POST['Costo'] : '0';
$Stock = isset($_POST['Stock']) ? $_POST['Stock'] : '0';
$Imagen = isset($_POST['Imagen']) ? $_POST['Imagen'] : '';

// Procesar nuevo archivo de imagen si se subió uno
if (isset($_FILES['ImagenFile']) && $_FILES['ImagenFile']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = basename($_FILES['ImagenFile']['name']);
    $rutaDestino = "../imagenes/" . $nombreArchivo;
    if (move_uploaded_file($_FILES['ImagenFile']['tmp_name'], $rutaDestino)) {
        $Imagen = $nombreArchivo;
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
    echo "Error al actualizar producto: " . $conexion->error;
}
?>