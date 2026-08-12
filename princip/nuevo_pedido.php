<?php
// ========================================================
// REGISTRAR UN NUEVO PEDIDO EN LA BASE DE DATOS
// ========================================================

// 1. Conectamos a la base de datos
include_once '../conexion.php';

// 2. Recibimos los datos del nuevo cliente/pedido por POST
$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$nombreVendedor = $_POST["nombreVendedor"];

// 3. Insertamos la cabecera del pedido en la tabla 'pedidos'
$sql = "INSERT INTO pedidos (Nombre, Fecha, Estado, NombreVendedor) VALUES ('$nombre', '$fecha', '$estado', '$nombreVendedor')";

if ($conn->query($sql)) {
    // Obtenemos el ID autogenerado del nuevo pedido ($conn->insert_id) y redirigimos al carrito
    header("Location: micarrito.php?idPedido=" . $conn->insert_id);
    exit;
} else {
    echo "Error al crear el pedido: " . $conn->error;
}

$conn->close();
?>
