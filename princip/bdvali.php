
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