<?php
// ========================================================
// REPORTE: INGRESOS TOTALES (POR DÍA, SEMANA, MES, AÑO) - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'mes';
$sql = "SELECT * FROM ventas ORDER BY idVenta DESC";

if ($periodo == 'dia') {
    $sql = "SELECT * FROM ventas WHERE Fecha LIKE '%" . date('d/m/Y') . "%' OR Fecha LIKE '%" . date('Y-m-d') . "%'";
} elseif ($periodo == 'semana') {
    $sql = "SELECT * FROM ventas ORDER BY idVenta DESC LIMIT 15";
} elseif ($periodo == 'ano') {
    $sql = "SELECT * FROM ventas WHERE Fecha LIKE '%" . date('Y') . "%'";
} else { // mes
    $sql = "SELECT * FROM ventas WHERE Fecha LIKE '%/" . date('m/Y') . "%' OR Fecha LIKE '%-" . date('m') . "-%'";
}

$resultado = $conn->query($sql);
$totalIngresos = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos Totales - ColdDrop</title>
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2>Reporte de Ingresos Totales</h2>
        <a href="menu_reportes.php" style="display:inline-block; margin-bottom: 20px; color: #555;">← Volver al Menú de Reportes</a>

        <div style="margin-bottom: 20px; text-align: center;">
            <a href="ingresostotales.php?periodo=dia" style="padding: 8px 15px; background: #111; color: #fff; text-decoration: none; margin-right: 5px;">Por Día</a>
            <a href="ingresostotales.php?periodo=semana" style="padding: 8px 15px; background: #111; color: #fff; text-decoration: none; margin-right: 5px;">Por Semana</a>
            <a href="ingresostotales.php?periodo=mes" style="padding: 8px 15px; background: #111; color: #fff; text-decoration: none; margin-right: 5px;">Por Mes</a>
            <a href="ingresostotales.php?periodo=ano" style="padding: 8px 15px; background: #111; color: #fff; text-decoration: none;">Por Año</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th># Venta</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Monto Total ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $totalIngresos += (float)$row['MontoTotal'];
                            echo "<tr>";
                                echo "<td>".$row['idVenta']."</td>";
                                echo "<td>".htmlspecialchars($row['Fecha'])."</td>";
                                echo "<td>".htmlspecialchars($row['Cliente'])."</td>";
                                echo "<td>".htmlspecialchars($row['NombreVendedor'])."</td>";
                                echo "<td>$".number_format($row['MontoTotal'], 2)."</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>No se encontraron ventas para este periodo.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h3 style="margin-top: 20px; text-align: right; color: #28a745;">Total Ingresos en Filtro: $<?php echo number_format($totalIngresos, 2); ?></h3>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>