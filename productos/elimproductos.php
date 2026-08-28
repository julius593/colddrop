<?php
include_once '../conexion.php';

// 1. Validar que el parámetro llegó
if (!isset($_GET['idCodigo']) || trim($_GET['idCodigo']) === '') {
    http_response_code(400);
    echo "Error: no se especificó el código del producto.";
    exit;
}

$codigo = $_GET['idCodigo'];

// 2. Consulta preparada (evita inyección SQL) usando el nombre real de columna
$sql = "DELETE FROM productos WHERE Codigo = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo "Error interno al preparar la consulta.";
    exit;
}

$stmt->bind_param('s', $codigo); // 's' porque Codigo es varchar

$stmt->execute();

// 3. Verificar si realmente se borró una fila
if ($stmt->affected_rows > 0) {
    echo "Producto eliminado exitosamente.";
} else {
    echo "No se encontró ningún producto con ese código.";
}

$stmt->close();
$conn->close();