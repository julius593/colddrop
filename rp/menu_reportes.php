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

    <?php include '../princip/footer.php'; ?>
</body>
</html>
