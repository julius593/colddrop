<?php
// ========================================================
// ELIMINAR REGISTRO DE VENTA - SOLO ADMINISTRADOR (ELIMINAR_VENTA.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}


// Verificación estricta de permisos de Administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: leer_ventas.php");
    exit();
}


$idVenta = isset($_GET['idVenta']) ? $_GET['idVenta'] : '';

if (!empty($idVenta)) {
    $sqlDel = "DELETE FROM ventas WHERE idVenta = '$idVenta'";
    $conn->query($sqlDel);
}


header("Location: leer_ventas.php");
exit();
?>
