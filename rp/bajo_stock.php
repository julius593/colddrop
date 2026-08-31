<?php
// ========================================================
// REPORTE: PRODUCTOS CON BAJO STOCK - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

$sql = "SELECT * FROM productos WHERE CAST(Stock AS UNSIGNED) <= 5 ORDER BY CAST(Stock AS UNSIGNED) ASC";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos con Bajo Stock - ColdDrop</title>
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2>Reporte: Productos con Bajo Stock (<= 5 Unidades)</h2>
        <a href="menu_reportes.php" style="display:inline-block; margin-bottom: 20px; color: #555;">← Volver al Menú de Reportes</a>

        <div style="background: #fff3cd; border-left: 5px solid #ffc107; padding: 15px; margin-bottom: 20px;">
            <strong>Notificación de Reposición Sugerida:</strong> Los siguientes productos tienen un stock bajo. Se sugiere realizar reposición de inventario.
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Stock Actual</th>
                        <th>Estado / Sugerencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $st = (int)$row['Stock'];
                            echo "<tr style='background-color: #fff5f5;'>";
                                echo "<td>".$row['Codigo']."</td>";
                                echo "<td>".htmlspecialchars($row['Nombre'])."</td>";
                                echo "<td>".htmlspecialchars($row['Tipo'])."</td>";
                                echo "<td>".htmlspecialchars($row['Talla'])."</td>";
                                echo "<td>".htmlspecialchars($row['Color'])."</td>";
                                echo "<td style='color: red; font-weight: bold;'>".$st." unidades</td>";
                                echo "<td style='color: #dc3545; font-weight: bold;'>¡Se sugiere reponer!</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align:center;'>No hay productos con bajo stock.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>
