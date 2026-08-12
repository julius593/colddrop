<?php
// ========================================================
// ENDPOINT AJAX PARA AGREGAR PRODUCTOS AL CARRITO
// ========================================================
include_once '../conexion.php';
header('Content-Type: application/json');

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$codigo = isset($_POST['Codigo']) ? $_POST['Codigo'] : '';
$id_PEDIDOS = isset($_POST['id_PEDIDOS']) ? $_POST['id_PEDIDOS'] : '';
$costo = isset($_POST['Costo']) ? (float)$_POST['Costo'] : 0;
$cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

if (empty($codigo) || empty($id_PEDIDOS)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit();
}

// 1. Verificar stock disponible del producto
$sqlStock = "SELECT Stock, Nombre FROM productos WHERE Codigo = '$codigo'";
$resStock = $conn->query($sqlStock);
if (!$resStock || $resStock->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Producto no encontrado"]);
    exit();
}

$prod = $resStock->fetch_assoc();
$stockDisponible = (int)$prod['Stock'];

// Verificar si ya existe en el carrito
$sqlExist = "SELECT cantidad FROM Carrito WHERE PRODUCTOS_Codigo = '$codigo' AND PEDIDOS_idPEDIDOS = '$id_PEDIDOS'";
$resExist = $conn->query($sqlExist);
$cantEnCarrito = 0;
if ($resExist && $resExist->num_rows > 0) {
    $rowExist = $resExist->fetch_assoc();
    $cantEnCarrito = (int)$rowExist['cantidad'];
}

$cantTotalRequerida = $cantEnCarrito + $cantidad;

if ($cantTotalRequerida > $stockDisponible) {
    echo json_encode([
        "success" => false, 
        "message" => "No se puede agregar. El stock disponible de '{$prod['Nombre']}' es {$stockDisponible} unidades (ya tienes {$cantEnCarrito} en el carrito)."
    ]);
    exit();
}

// 2. Insertar o actualizar en la tabla Carrito
if ($cantEnCarrito > 0) {
    $nuevaCant = $cantTotalRequerida;
    $nuevoSubtotal = $nuevaCant * $costo;
    $sqlUpd = "UPDATE Carrito SET cantidad = '$nuevaCant', costoTotal = '$nuevoSubtotal' WHERE PRODUCTOS_Codigo = '$codigo' AND PEDIDOS_idPEDIDOS = '$id_PEDIDOS'";
    $conn->query($sqlUpd);
} else {
    $costoTotal = $cantidad * $costo;
    $sqlIns = "INSERT INTO Carrito (PRODUCTOS_Codigo, PEDIDOS_idPEDIDOS, cantidad, costoTotal) VALUES ('$codigo', '$id_PEDIDOS', '$cantidad', '$costoTotal')";
    $conn->query($sqlIns);
}

// 3. Recalcular total del pedido
$sqlTotal = "SELECT sum(costoTotal) as total FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$id_PEDIDOS'";
$resTotal = $conn->query($sqlTotal);
$totalRow = $resTotal->fetch_assoc();
$total = isset($totalRow['total']) && $totalRow['total'] !== null ? (float)$totalRow['total'] : 0;

echo json_encode([
    "success" => true,
    "message" => "Producto agregado exitosamente al carrito",
    "total" => number_format($total, 2)
]);
?>
