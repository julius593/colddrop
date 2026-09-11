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
