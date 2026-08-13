<?php
// ========================================================
// ENDPOINT AJAX PARA ELIMINAR PRODUCTOS DEL CARRITO
// ========================================================
include_once '../conexion.php';
header('Content-Type: application/json');

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}
$codigo = isset($_POST['Codigo']) ? $_POST['Codigo'] : '';
$idPedido = isset($_POST['idPedido']) ? $_POST['idPedido'] : '';
if (empty($codigo) || empty($idPedido)) {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
    exit();
}