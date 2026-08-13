<?php
// ========================================================
// ENDPOINT AJAX PARA ELIMINAR PRODUCTOS DEL CARRITO
// ========================================================
include_once '../conexion.php';
header('Content-Type: application/json');

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}
$codigo = isset($_POST['Codigo']) ? $_POST['Codigo'] : '';
$idPedido = isset($_POST['idPedido']) ? $_POST['idPedido'] : '';
if (empty($codigo) || empty($idPedido)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit();
}
$sqlDel = "DELETE FROM Carrito WHERE PRODUCTOS_Codigo = '$codigo' AND PEDIDOS_idPEDIDOS = '$idPedido'";
$conn->query($sqlDel);

// Recalcular total del pedido
$sqlTotal = "SELECT sum(costoTotal) as total FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resTotal = $conn->query($sqlTotal);
$totalRow = $resTotal->fetch_assoc();
$total = isset($totalRow['total']) && $totalRow['total'] !== null ? (float)$totalRow['total'] : 0;

// Verificar si quedan prendas en el carrito
$sqlCart = "SELECT count(*) as cant FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resCart = $conn->query($sqlCart);
$cantItems = $resCart ? $resCart->fetch_assoc()['cant'] : 0;

echo json_encode([
    "success" => true,
    "total" => number_format($total, 2),
    "cantItems" => $cantItems
]);
?>