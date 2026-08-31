<?php
// =========================================================
// VER SUGERENCIAS GUARDADAS EN ARCHIVO TEXTO - COLDDROP
// ========================================================
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}
$contenido = "No hay sugerencias registradas aún en el archivo sugerencias.txt.";
if (file_exists("sugerencias.txt")) {
    $contenido = file_get_contents("sugerencias.txt");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sugerencias Registradas (fwrite) - ColdDrop</title>
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
     <?php include '../princip/header.php'; ?>
     
</body>
</html>