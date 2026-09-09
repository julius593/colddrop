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

$CI = isset($_GET['CI']) ? $_GET['CI'] : '';

if (!empty($CI)) {
    // Consultamos el estado actual del usuario
    $sqlSel = "SELECT Estado FROM usuarios WHERE CI = '$CI'";
    $resSel = $conexion->query($sqlSel);
    if ($resSel && $resSel->num_rows > 0) {
        $user = $resSel->fetch_assoc();
        $nuevoEstado = ($user['Estado'] === 'Bloqueado') ? 'Activo' : 'Bloqueado';
        
        $sqlUpd = "UPDATE usuarios SET Estado = '$nuevoEstado' WHERE CI = '$CI'";
        $conexion->query($sqlUpd);
    }
}

// Redireccionamos a la lista de usuarios
header("Location: leerusuarios.php");
exit();
?>
