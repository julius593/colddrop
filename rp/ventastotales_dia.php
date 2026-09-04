<?php
// ========================================================
// REPORTE: VENTAS TOTALES DEL DÍA - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

$hoy = date('d/m/Y');
$hoySql = date('Y-m-d');

$sql = "SELECT * FROM ventas WHERE Fecha LIKE '%$hoy%' OR Fecha LIKE '%$hoySql%' ORDER BY idVenta DESC";
$resultado = $conn->query($sql);

$totalMonto = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas Totales del Día - ColdDrop</title>
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2>Reporte: Ventas Totales del Día (<?php echo $hoy; ?>)</h2>
        <a href="menu_reportes.php" class="btn-volver" style="display:inline-block; margin-bottom: 20px; padding: 8px 15px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 4px;">← Volver al Menú de Reportes</a>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th># Venta</th>
                        <th># Pedido</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Monto Total ($)</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $totalMonto += (float)$row['MontoTotal'];
                            echo "<tr>";
                                echo "<td>".$row['idVenta']."</td>";
                                echo "<td>".$row['PEDIDOS_idPEDIDOS']."</td>";
                                echo "<td>".htmlspecialchars($row['Fecha'])."</td>";
                                echo "<td>".htmlspecialchars($row['Cliente'])."</td>";
                                echo "<td>".htmlspecialchars($row['NombreVendedor'])."</td>";
                                echo "<td>$".number_format($row['MontoTotal'], 2)."</td>";
                                echo "<td>".htmlspecialchars($row['Estado'])."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No se registraron ventas el día de hoy.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h3 style="margin-top: 20px; text-align: right; color: #28a745;">Total Recaudado Hoy: $<?php echo number_format($totalMonto, 2); ?></h3>
    </div>

    <?php include '../princip/footer.php'; ?>
    <!-- ===================== SCRIPTS DE LOS GRÁFICOS ===================== -->
    <script>
</body>
</html>
