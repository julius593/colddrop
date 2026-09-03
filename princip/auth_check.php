<?php
// ========================================================
// CONTROL DE ACCESO Y AUTORIZACIÓN POR ROL - COLDDROP
// ========================================================

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica si la sesión actual cuenta con los roles permitidos.
 * Si no está logueado o no posee el rol adecuado, detiene la ejecución
 * y muestra una alerta SweetAlert2 con redirección.
 * 
 * @param array $rolesPermitidos Lista de roles permitidos, ej. ['Administrador', 'vendedor']
 */
function verificarAcceso($rolesPermitidos = ['Administrador']) {
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $rolesPermitidos)) {
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Acceso Restringido - ColdDrop</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>body { font-family: sans-serif; background: #f4f6f8; }</style>
        </head>
        <body>
      <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso Denegado',
                        text: 'No tienes los permisos necesarios para acceder a esta sección.',
                        confirmButtonColor: '#111',
                        confirmButtonText: 'Ir a Iniciar Sesión'
                    }).then(() => {
                        window.location.href = '../princip/iniciosesion.php';
                    });
                });
            </script>
        </body>
        </html>";
        exit();
    }
}
?>
