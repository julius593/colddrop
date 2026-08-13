<?php
// ========================================================
// BLOQUEAR / DESBLOQUEAR VENDEDOR (BLOQUEAR_USUARIO.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Solo el Administrador puede bloquear/desbloquear usuarios
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

