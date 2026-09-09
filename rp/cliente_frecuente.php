<?php
// ========================================================
// REPORTE: CLIENTE MÁS FRECUENTE - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

$sql = "SELECT Nombre as Cliente, COUNT(*) as TotalPedidos FROM pedidos WHERE Nombre IS NOT NULL AND Nombre != '' GROUP BY Nombre ORDER BY TotalPedidos DESC LIMIT 10";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cliente Más Frecuente - ColdDrop</title>
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2>Reporte: Clientes Más Frecuentes</h2>
        <a href="menu_reportes.php" style="display:inline-block; margin-bottom: 20px; color: #555;">← Volver al Menú de Reportes</a>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Cliente / Contacto</th>
                        <th>Total de Pedidos Realizados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        $pos = 1;
                        while ($row = $resultado->fetch_assoc()) {
                            echo "<tr>";
                                echo "<td>#".$pos++."</td>";
                                echo "<td>".htmlspecialchars($row['Cliente'])."</td>";
                                echo "<td><strong>".$row['TotalPedidos']." pedidos</strong></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center;'>No se encontraron registros de clientes.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>
