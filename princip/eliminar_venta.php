<?php
// ========================================================
// ELIMINAR REGISTRO DE VENTA - SOLO ADMINISTRADOR (ELIMINAR_VENTA.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}