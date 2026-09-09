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

// === Datos para los gráficos ===
$labelsVentas = [];   // ej: "Venta #12"
$montosVentas = [];   // monto de cada venta
$porVendedor = [];    // acumulado por vendedor, ej: ['Juan' => 150.00, 'Ana' => 90.00]

$filas = []; // guardamos las filas para no perder el recorrido al pintar la tabla
if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $filas[] = $row;

        $monto = (float) $row['MontoTotal'];
        $totalMonto += $monto;

        $labelsVentas[] = 'Venta #' . $row['idVenta'];
        $montosVentas[] = $monto;

        $vendedor = $row['NombreVendedor'];
        if (!isset($porVendedor[$vendedor])) {
            $porVendedor[$vendedor] = 0;
        }
        $porVendedor[$vendedor] += $monto;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas Totales del Día - ColdDrop</title>
    <link rel="stylesheet" href="../css/tablas.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2>Reporte: Ventas Totales del Día (<?php echo $hoy; ?>)</h2>
        <a href="menu_reportes.php" class="btn-volver" style="display:inline-block; margin-bottom: 20px; padding: 8px 15px; background: #6c757d; color: #fff; text-decoration: none; border-radius: 4px;">← Volver al Menú de Reportes</a>

        <?php if (count($filas) > 0): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 30px; margin-bottom: 30px;">
            <div style="flex: 2; min-width: 300px; background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <canvas id="graficoMontos"></canvas>
            </div>
            <div style="flex: 1; min-width: 250px; background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <canvas id="graficoVendedores"></canvas>
            </div>
        </div>
        <?php endif; ?>

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
                    if (count($filas) > 0) {
                        foreach ($filas as $row) {
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

    <?php if (count($filas) > 0): ?>
    <script>
        // Los datos vienen de PHP ya calculados, solo los convertimos a JSON
        var labelsVentas = <?php echo json_encode($labelsVentas); ?>;
        var montosVentas = <?php echo json_encode($montosVentas); ?>;
        var vendedores = <?php echo json_encode(array_keys($porVendedor)); ?>;
        var montosPorVendedor = <?php echo json_encode(array_values($porVendedor)); ?>;

        // Gráfico de barras: monto por venta
        new Chart(document.getElementById('graficoMontos'), {
            type: 'bar',
            data: {
                labels: labelsVentas,
                datasets: [{
                    label: 'Monto ($)',
                    data: montosVentas,
                    backgroundColor: '#28a745'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: 'Monto por venta (hoy)' },
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Gráfico de dona: ventas por vendedor
        new Chart(document.getElementById('graficoVendedores'), {
            type: 'doughnut',
            data: {
                labels: vendedores,
                datasets: [{
                    data: montosPorVendedor,
                    backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: { display: true, text: 'Recaudado por vendedor' }
                }
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>