<?php
// ========================================================
// ELIMINAR UN PRODUCTO DEL CARRITO DE COMPRAS
// ========================================================

// 1. Conectamos a la base de datos
include_once '../conexion.php';

// 2. Obtenemos el código de producto y el ID del pedido recibiéndolos por URL (GET)
$codigo = isset($_GET['Codigo']) ? $_GET['Codigo'] : '';
$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : (isset($_GET['idPEDIDOS']) ? $_GET['idPEDIDOS'] : '');

// 3. Si ambos datos existen, eliminamos la fila correspondiente de la tabla Carrito
if (!empty($codigo) && !empty($idPedido)) {
    $codigo = $conn->real_escape_string($codigo);
    $idPedido = (int)$idPedido;

    $sql = "DELETE FROM Carrito WHERE PRODUCTOS_Codigo = '$codigo' AND PEDIDOS_idPEDIDOS = $idPedido";
    $conn->query($sql);
}

// 4. Redirigimos al usuario de vuelta a su carrito para ver la lista actualizada
header("Location: micarrito.php?idPedido=" . $idPedido);
exit;
?>
