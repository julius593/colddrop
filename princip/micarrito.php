<?php
// ========================================================
// PÁGINA DEL CARRITO DE COMPRAS (MICARRITO.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// 1. Obtener el ID del pedido activo (de la URL o buscando el último en la BD)
$id_PEDIDOS = '';
if (isset($_GET['idPedido'])) {
    $id_PEDIDOS = $_GET['idPedido'];
} elseif (isset($_GET['idPEDIDOS'])) {
    $id_PEDIDOS = $_GET['idPEDIDOS'];
}

// Si no viene ningún ID por la URL, buscamos el último pedido registrado en la BD
if (empty($id_PEDIDOS)) {
    $sqlUltimo = "SELECT idPEDIDOS FROM pedidos ORDER BY idPEDIDOS DESC LIMIT 1";
    $resUltimo = $conn->query($sqlUltimo);
    if ($resUltimo && $resUltimo->num_rows > 0) {
        $filaUltimo = $resUltimo->fetch_assoc();
        $id_PEDIDOS = $filaUltimo['idPEDIDOS'];
    } else {
        // Si la tabla pedidos estuviera vacía, creamos un pedido por defecto
        $vendedor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Cliente Directo';
        $fecha = date('Y-m-d');
        $conn->query("INSERT INTO pedidos (Nombre, Fecha, Estado, NombreVendedor) VALUES ('Cliente General', '$fecha', 'En Proceso', '$vendedor')");
        $id_PEDIDOS = $conn->insert_id;
    }
}

// 2. Consulta SQL para traer únicamente las prendas agregadas a este carrito específico
$sqlCart = "SELECT c.*, p.Nombre, p.Costo, p.Talla, p.Imagen 
            FROM Carrito c 
            JOIN productos p ON c.PRODUCTOS_Codigo = p.Codigo 
            WHERE c.PEDIDOS_idPEDIDOS = '$id_PEDIDOS'";
$resultadoCart = $conn->query($sqlCart);

// 3. Consulta SQL para calcular el monto total a pagar del pedido actual
$sqlTotal = "SELECT sum(costoTotal) FROM Carrito where PEDIDOS_idPEDIDOS='$id_PEDIDOS'";
$resultadoTotal = $conn->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total = $res['sum(costoTotal)'];
if ($total == null) {
    $total = 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito - ColdDrop</title>
    
    <!-- Carga de fuentes de Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para el carrito -->
    <link rel="stylesheet" href="../css/micarrito.css">
</head>
<body>

    <!-- Incluimos la cabecera superior -->
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Mi Carrito de Compras</h2>
        <p style="color: #666; margin-bottom: 20px;">Pedido ID: #<?php echo htmlspecialchars($id_PEDIDOS); ?></p>
        
        <!-- Muestra el monto total del pedido -->
        <div class="total-box">
            <h3 id="txtTotal">Total a Pagar: $<?php echo number_format($total, 2); ?></h3>
        </div>

        <!-- ========================================================
             TABLA DE PRODUCTOS EN EL CARRITO
             ======================================================== -->
        <div class="section-title">Productos en Compra</div>
        <?php if ($resultadoCart && $resultadoCart->num_rows > 0): ?>
            <table id="tablaCarrito">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Talla</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($item = $resultadoCart->fetch_assoc()) {
                        $img = !empty($item['Imagen']) ? $item['Imagen'] : 'default.jpg';
                        echo "<tr id='item_row_".htmlspecialchars($item["PRODUCTOS_Codigo"])."'>";
                            echo "<td><img class='product-img' src='../imagenes/".htmlspecialchars($img)."' alt=''></td>";
                            echo "<td>".htmlspecialchars($item["PRODUCTOS_Codigo"])."</td>";
                            echo "<td>".htmlspecialchars($item["Nombre"])."</td>";
                            echo "<td>".htmlspecialchars($item["Talla"])."</td>";
                            echo "<td>$".number_format($item["Costo"], 2)."</td>";
                            echo "<td>".htmlspecialchars($item["cantidad"])."</td>";
                            echo "<td>$".number_format($item["costoTotal"], 2)."</td>";
                            echo "<td>";
                                echo "<a href='#' onclick='eliminarAjax(\"".htmlspecialchars($item["PRODUCTOS_Codigo"])."\", \"".htmlspecialchars($id_PEDIDOS)."\"); return false;' class='btn-eliminar'>Eliminar</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-cart" id="emptyNotice">
                Tu carrito está vacío. ¡Explora nuestro catálogo para agregar prendas!
                <div style="margin-top: 15px;">
                    <a href="poleras.php" class="btn-nuevo" style="background-color: #111;">Ver Catálogo de Productos</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Botones de Acción e Impresión -->
        <div style="margin-top: 40px; text-align: right; display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador'): ?>
                <a href="Administrador.php" class="btn-nuevo" style="background-color: #5a6268;">← Volver al Panel Admin</a>
            <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'vendedor'): ?>
                <a href="vendedor.php" class="btn-nuevo" style="background-color: #5a6268;">← Volver al Panel Vendedor</a>
            <?php endif; ?>

            <a href="poleras.php" class="btn-nuevo" style="background-color: #111;"><i class="fa-solid fa-store"></i> Explorar Catálogo</a>

            <?php if ($resultadoCart && $resultadoCart->num_rows > 0): ?>
                <a href="enviar_pedido.php?idPedido=<?php echo htmlspecialchars($id_PEDIDOS); ?>" class="btn-nuevo" style="background-color: #28a745; font-size:15px; font-weight:700;"><i class="fa-solid fa-paper-plane"></i> Enviar / Confirmar Pedido</a>
                <a href="detalle_pedido.php?idPedido=<?php echo htmlspecialchars($id_PEDIDOS); ?>" class="btn-nuevo" style="background-color: #17a2b8;"><i class="fa-solid fa-file-pdf"></i> Ver Comprobante PDF</a>
                
                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'Administrador' || $_SESSION['rol'] === 'vendedor')): ?>
                    <a href="registrar_venta.php?idPedido=<?php echo htmlspecialchars($id_PEDIDOS); ?>" class="btn-nuevo" style="background-color: #ffc107; color:#000;" onclick="return confirm('¿Confirmar la venta de este pedido? Esto descontará el stock de los productos.');"><i class="fa-solid fa-cash-register"></i> Registrar Venta Oficial</a>
                <?php endif; ?>
            <?php endif; ?>

            <a href="frompedido.php" class="btn-nuevo" style="background-color: #6c757d;">Generar Nuevo Pedido</a>
        </div>
    </div>

    <!-- Script de manipulación AJAX para eliminar ítems del Carrito -->
    <script>
    function eliminarAjax(codigo, idPedido) {
        if (!confirm('¿Deseas eliminar esta prenda del carrito?')) return;

        const formData = new FormData();
        formData.append('Codigo', codigo);
        formData.append('idPedido', idPedido);

        fetch('eliminar_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el producto');
        });
    }
    </script>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>

</body>
</html>