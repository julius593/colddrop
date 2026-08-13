<?php
// ========================================================
// REGISTRAR VENTA Y ACTUALIZAR STOCK (REGISTRAR_VENTA.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['Administrador', 'vendedor'], true)) {
    header('Location: iniciosesion.php');
    exit();
}

$idPedido = isset($_GET['idPedido']) ? (int)$_GET['idPedido'] : 0;

if (empty($idPedido)) {
    header("Location: micarrito.php");
    exit();
}

// 1. Obtener detalles del pedido
$sqlPed = "SELECT * FROM pedidos WHERE idPEDIDOS = '$idPedido'";
$resPed = $conn->query($sqlPed);
$pedido = ($resPed && $resPed->num_rows > 0) ? $resPed->fetch_assoc() : null;

if (!$pedido) {
    header("Location: micarrito.php");
    exit();
}

if ($pedido['Estado'] === 'Entregado') {
    header('Location: detalle_pedido.php?idPedido=' . $idPedido);
    exit();
}



// 6. Actualizar estado del pedido a 'Entregado'
$conn->query("UPDATE pedidos SET Estado = 'Entregado' WHERE idPEDIDOS = '$idPedido'");

// Redirigir al historial de ventas
header("Location: leer_ventas.php");
exit();
?>
