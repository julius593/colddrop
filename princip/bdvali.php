<?php
// ========================================================
// VALIDACIÓN DE USUARIO Y CONTRASEÑA EN LA BASE DE DATOS
// ========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../conexion.php';

// Protocolo Seguridad Inyección SQL: Sanitizar entradas $_POST con real_escape_string
$usuario = isset($_POST['Usuario']) ? $conexion->real_escape_string(trim($_POST['Usuario'])) : '';
$contrasena = isset($_POST['Contrasena']) ? $conexion->real_escape_string(trim($_POST['Contrasena'])) : '';

$sql = "SELECT * FROM usuarios WHERE Usuario='$usuario' AND Contrasena='$contrasena'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);

    if (isset($fila['Estado']) && ($fila['Estado'] === 'Bloqueado' || $fila['Estado'] === 'Inactivo')) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; background:#fff; padding:40px; border-radius:12px; max-width:450px; margin:50px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>";
        echo "<h2 style='color:#dc3545;'>Acceso Denegado</h2>";
        // Protocolo XSS: htmlspecialchars al mostrar texto dinámico
        echo "<p style='color:#555;'>Tu cuenta se encuentra actualmente <strong>".htmlspecialchars($fila['Estado'])."</strong>. Contacta al Administrador del sistema.</p>";
        echo "<a href='iniciosesion.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver a Intentar</a>";
        echo "</div>";
        exit();
    }

    $_SESSION['id'] = $fila['CI'];
    $_SESSION['usuario'] = $fila['Nombre'];
    $_SESSION['dir'] = $fila['Direccion'];
    $_SESSION['rol'] = $fila['Rol'];
    
    if ($_SESSION['rol'] == "vendedor") {
        header("Location: vendedor.php");
    } else if ($_SESSION['rol'] == "Administrador") {
        header("Location: Administrador.php");
    } else {
        header("Location: index.php");
    }
} else {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; background:#fff; padding:40px; border-radius:12px; max-width:450px; margin:50px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color:#dc3545;'>Usuario o contraseña incorrectos</h2>";
    echo "<a href='iniciosesion.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver a intentar</a>";
    echo "</div>";
}
?>