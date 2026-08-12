
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
