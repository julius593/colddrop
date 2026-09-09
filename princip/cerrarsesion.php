<?php
// ========================================================
// CIERRE DE SESIÓN
// ========================================================

// 1. Reanudamos la sesión activa para poder cerrarla
session_start();

// 2. Destruimos todas las variables de sesión del usuario
session_destroy();

// 3. Redirigimos de vuelta a la pantalla de inicio de sesión
header("Location: iniciosesion.php");
exit;
?>