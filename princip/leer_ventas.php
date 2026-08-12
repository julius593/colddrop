<?php
// ========================================================
// HISTORIAL Y REPORTES DE VENTAS (LEER_VENTAS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';
$nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';

if (!in_array($rolUsuario, ['Administrador', 'vendedor'], true)) {
    header('Location: iniciosesion.php');
    exit();
}

// Si es administrador muestra todas las ventas, si es vendedor filtra por su usuario
if ($rolUsuario === 'Administrador') {
    $sql = "SELECT * FROM ventas ORDER BY idVenta DESC";
} else if ($rolUsuario === 'vendedor') {
    $sql = "SELECT * FROM ventas WHERE NombreVendedor = '$nombreUsuario' ORDER BY idVenta DESC";
}

$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ventas - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>

    <!-- Incluimos la cabecera superior -->
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <div class="admin-header-flex">
            <h1><i class="fa-solid fa-receipt"></i> Historial de Ventas</h1>
            <div>
                <?php if ($rolUsuario === 'Administrador'): ?>
                    <a href="Administrador.php" class="btn-volver">← Volver al Panel Admin</a>
                <?php elseif ($rolUsuario === 'vendedor'): ?>
                    <a href="vendedor.php" class="btn-volver">← Volver al Panel Vendedor</a>
                <?php else: ?>
                    <a href="micarrito.php" class="btn-volver">← Volver al Carrito</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>N° Venta</th>
                        <th>Pedido ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Monto Total ($)</th>
                        <th>Estado</th>
                        <?php if ($rolUsuario === 'Administrador'): ?>
                            <th style="text-align: center;">Acciones (Solo Admin)</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $idVenta = htmlspecialchars($row['idVenta']);
                            $idPedido = htmlspecialchars($row['PEDIDOS_idPEDIDOS']);
                            $fecha = htmlspecialchars($row['Fecha']);
                            $cliente = htmlspecialchars($row['Cliente']);
                            $vendedor = htmlspecialchars($row['NombreVendedor']);
                            $monto = number_format($row['MontoTotal'], 2);
                            $estado = htmlspecialchars($row['Estado']);

                            echo "<tr>";
                                echo "<td>#$idVenta</td>";
                                echo "<td>#$idPedido</td>";
                                echo "<td>$fecha</td>";
                                echo "<td>$cliente</td>";
                                echo "<td>$vendedor</td>";
                                echo "<td><strong>$$monto</strong></td>";
                                echo "<td><span style='background:#28a745; color:#fff; padding:4px 8px; border-radius:12px; font-size:12px;'>$estado</span></td>";
                                
                                if ($rolUsuario === 'Administrador') {
                                    echo "<td style='text-align: center;'>";
                                        echo "<a href='editar_venta.php?idVenta=$idVenta' class='btn-action btn-editar'>Editar</a>";
                                        echo "<a href='eliminar_venta.php?idVenta=$idVenta' class='btn-action btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar este registro de venta?\");'>Eliminar</a>";
                                        echo "<a href='detalle_pedido.php?idPedido=$idPedido' class='btn-action btn-mostrar'>Detalle / QR</a>";
                                    echo "</td>";
                                }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>No se encontraron registros de ventas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>

</body>
</html>
