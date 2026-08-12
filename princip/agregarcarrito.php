<?php
// ========================================================
// AGREGAR UN PRODUCTO AL CARRITO DE COMPRAS
// ========================================================

// 1. Incluimos la conexión a la base de datos
include_once '../conexion.php';

// 2. Recibimos los datos por método POST desde el formulario en micarrito.php
$codigo = $_POST["Codigo"];
$idpedido = $_POST["id_PEDIDOS"];

// Verificamos que tengamos un número de pedido válido
if (empty($idpedido) || !is_numeric($idpedido)) {
    die("Error: No se ha especificado un ID de pedido válido. Por favor, inicia un nuevo pedido.");
}

$cantidad = $_POST["cantidad"];
$costo = $_POST["Costo"];

// 3. Calculamos el costo total multiplicando cantidad por precio unitario
$total = $costo * $cantidad;

// 4. Consulta SQL: Si el producto ya está en el carrito para este pedido, suma la cantidad; si no, lo inserta
$sql = "INSERT INTO Carrito (PRODUCTOS_Codigo, PEDIDOS_idPEDIDOS, cantidad, costoTotal)
        VALUES ('$codigo', '$idpedido', '$cantidad', '$total')
        ON DUPLICATE KEY UPDATE
             cantidad = cantidad + VALUES(cantidad),
             costoTotal = costoTotal + VALUES(costoTotal)";

// 5. Ejecutamos la consulta y devolvemos al usuario al carrito
if ($conn->query($sql)) {
    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit;
} else {
    echo "<div style='font-family:sans-serif; text-align:center; margin-top:50px;'>";
    echo "<h3>Error al guardar el producto en el carrito</h3>";
    echo "<a href='micarrito.php?idPedido=$idpedido'>Volver al Carrito</a>";
    echo "</div>";
}
?>
