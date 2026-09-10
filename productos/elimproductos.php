<?php
include_once '../conexion.php';

if (!isset($_GET['Codigo'])) {
    die("error: falta el parámetro Codigo");
}

$codigo = $_GET['Codigo'];

$sql = "DELETE FROM productos WHERE Codigo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codigo); // "s" si Codigo es varchar, "i" si es entero
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "producto eliminado exitosamente";
} else {
    echo "no se encontró el producto o ya fue eliminado";
}

$stmt->close();
?>