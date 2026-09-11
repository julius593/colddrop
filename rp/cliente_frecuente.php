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


