<?php
// ========================================================
// MENÚ DE REPORTES DEL SISTEMA - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú de Reportes - ColdDrop</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="admin-container">
        <h1 class="admin-title">MENÚ DE REPORTES DEL SISTEMA</h1>
        <p style="margin-bottom: 30px; color: #555;">Selecciona el reporte que deseas consultar:</p>

        <div class="admin-grid">
            <div class="admin-card">
                <h3>Ventas Totales del Día</h3>
                <p>Muestra el resumen de las ventas realizadas en la fecha actual.</p>
                <a href="ventastotales_dia.php" class="btn-admin">Ver Reporte</a>
            </div>

            <div class="admin-card">
                <h3>Producto Más Vendido (en el mes)</h3>
                <p>Muestra cuál es la prenda con mayor cantidad de ventas acumuladas este mes.</p>
                <a href="producto_mas_vendido.php" class="btn-admin secundario">Ver Reporte</a>
            </div>

            <div class="admin-card">
                <h3>Ingresos Totales (Día/Semana/Mes/Año)</h3>
                <p>Consulta los ingresos financieros filtrados por periodo referentes a las ventas.</p>
                <a href="ingresostotales.php" class="btn-admin" style="background-color: #28a745;">Ver Reporte</a>
            </div>

            <div class="admin-card">
                <h3>Productos con Bajo Stock</h3>
                <p>Lista los productos con existencias iguales o menores a 5 unidades y sugerencias para reponer.</p>
                <a href="bajo_stock.php" class="btn-admin peligro">Ver Alerta de Stock</a>
            </div>

            <div class="admin-card">
                <h3>Cliente Más Frecuente</h3>
                <p>Lista los clientes que han realizado mayor cantidad de pedidos en la tienda.</p>
                <a href="cliente_frecuente.php" class="btn-admin" style="background-color: #6f42c1;">Ver Reporte</a>
            </div>

            <div class="admin-card">
                <h3>Bitácora de Sugerencias (fwrite)</h3>
                <p>Muestra los comentarios enviados por los clientes guardados en el archivo texto.</p>
                <a href="../fm/leer_sugerencias.php" class="btn-admin" style="background-color: #6c757d;">Ver Bitácora</a>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <a href="../princip/Administrador.php" class="btn-admin secundario" style="width: auto; padding: 10px 20px;">← Volver al panel admin</a>
        </div>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>
