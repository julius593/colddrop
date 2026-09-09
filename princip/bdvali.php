<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validando Sesión - ColdDrop</title>
</head>
<body>
<?php
// ========================================================
// VALIDACIÓN DE USUARIO Y CONTRASEÑA EN LA BASE DE DATOS
// ========================================================

// 1. Iniciamos la sesión de PHP para guardar datos del usuario logueado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluimos la conexión a la base de datos
include_once '../conexion.php';

// 3. Recibimos los datos enviados desde el formulario de iniciosesion.php
$usuario = isset($_POST['Usuario']) ? $_POST['Usuario'] : '';
$contrasena = isset($_POST['Contrasena']) ? $_POST['Contrasena'] : '';

// 4. Consultamos si existe un usuario con esas credenciales exactas
$sql = "SELECT * FROM usuarios WHERE Usuario='$usuario' AND Contrasena='$contrasena'";
$resultado = mysqli_query($conexion, $sql);

// 5. Si encontramos coincidencia (al menos 1 fila), se verifica estado
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);

    // Verificamos si el usuario está bloqueado o inactivo
    if (isset($fila['Estado']) && ($fila['Estado'] === 'Bloqueado' || $fila['Estado'] === 'Inactivo')) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; background:#fff; padding:40px; border-radius:12px; max-width:450px; margin:50px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>";
        echo "<h2 style='color:#dc3545;'>Acceso Denegado</h2>";
        echo "<p style='color:#555;'>Tu cuenta se encuentra actualmente <strong>".$fila['Estado']."</strong>. Contacta al Administrador del sistema.</p>";
        echo "<a href='iniciosesion.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver a Intentar</a>";
        echo "</div>";
        exit();
    }

    // Guardamos la información del usuario en las variables globales $_SESSION
    $_SESSION['id'] = $fila['CI'];
    $_SESSION['usuario'] = $fila['Nombre'];
    $_SESSION['dir'] = $fila['Direccion'];
    $_SESSION['rol'] = $fila['Rol'];
    
    // Redirigimos según el tipo de rol registrado
    if ($_SESSION['rol'] == "vendedor") {
        header("Location: vendedor.php");
    } else if ($_SESSION['rol'] == "Administrador") {
        header("Location: Administrador.php");
    } else {
        // Si no es vendedor ni admin, lo llevamos a la página de inicio
        header("Location: inicio.php");
    }
} else {
    // Si no coincide, avisamos al usuario
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; background:#fff; padding:40px; border-radius:12px; max-width:450px; margin:50px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color:#dc3545;'>Usuario o contraseña incorrectos</h2>";
    echo "<a href='iniciosesion.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver a intentar</a>";
    echo "</div>";
}
?>
</body>
</html>