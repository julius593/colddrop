<?php
// ========================================================
// ENDPOINT AJAX PARA ELIMINAR PRODUCTOS DEL CARRITO
// ========================================================
include_once '../conexion.php';
header('Content-Type: application/json');

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}
