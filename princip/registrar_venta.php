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

// 2. Obtener productos del carrito para este pedido
$sqlItems = "SELECT * FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resItems = $conn->query($sqlItems);

// 3. Calcular monto total
$sqlTotal = "SELECT sum(costoTotal) as total FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resTotal = $conn->query($sqlTotal);
$totalRow = $resTotal ? $resTotal->fetch_assoc() : null;
$montoTotal = ($totalRow && $totalRow['total'] !== null) ? (float)$totalRow['total'] : 0;

$fechaActual = date('Y-m-d H:i:s');
$vendedor = !empty($pedido['NombreVendedor']) ? $pedido['NombreVendedor'] : (isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Vendedor');
$cliente = !empty($pedido['Nombre']) ? $pedido['Nombre'] : 'Cliente General';

// 4. Descontar stock de cada producto en la tabla productos
if ($resItems && $resItems->num_rows > 0) {
    while($item = $resItems->fetch_assoc()) {
        $codigoProd = $item['PRODUCTOS_Codigo'];
        $cantVendida = (int)$item['cantidad'];

        // Actualizamos el stock deduciendo la cantidad vendida
        $sqlStockUpd = "UPDATE productos SET Stock = GREATEST(0, CAST(Stock AS SIGNED) - $cantVendida) WHERE Codigo = '$codigoProd'";
        $conn->query($sqlStockUpd);
    }
}

// 5. Registrar en la tabla ventas
$sqlInsVenta = "INSERT INTO ventas (PEDIDOS_idPEDIDOS, Fecha, MontoTotal, NombreVendedor, Cliente, Estado) 
                VALUES ('$idPedido', '$fechaActual', '$montoTotal', '$vendedor', '$cliente', 'Completada')";
$conn->query($sqlInsVenta);

// 6. Actualizar estado del pedido a 'Entregado'
$conn->query("UPDATE pedidos SET Estado = 'Entregado' WHERE idPEDIDOS = '$idPedido'");

// Redirigir al historial de ventas
header("Location: leer_ventas.php");
exit();
?>
