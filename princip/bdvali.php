<?php
// ========================================================
// VALIDACIÓN DE USUARIO Y CONTRASEÑA - COLDDROP
// ========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../conexion.php';

// --------------------------------------------------------
// Muestra una tarjeta de mensaje y termina el script
// --------------------------------------------------------
function mostrarMensaje(string $titulo, string $texto = ''): void
{
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Iniciar Sesión - ColdDrop</title></head><body style='background:#f5f5f5; margin:0;'>";
    echo "<div style='text-align:center; font-family:sans-serif; background:#fff; padding:40px; border-radius:12px; max-width:450px; margin:50px auto; box-shadow:0 4px 15px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color:#dc3545;'>" . htmlspecialchars($titulo) . "</h2>";
    if ($texto !== '') {
        echo "<p style='color:#555;'>" . $texto . "</p>";   // $texto ya viene escapado por quien llama
    }
    echo "<a href='iniciosesion.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver a intentar</a>";
    echo "</div></body></html>";
    exit();
}

// --------------------------------------------------------
// Solo se acepta el envío del formulario por POST
// --------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: iniciosesion.php");
    exit();
}

// --------------------------------------------------------
// Recibir datos (la contraseña NO lleva trim, igual que en el registro)
// --------------------------------------------------------
$usuario    = trim($_POST['Usuario'] ?? '');
$contrasena = $_POST['Contrasena'] ?? '';

if ($usuario === '' || $contrasena === '') {
    mostrarMensaje('Completa usuario y contraseña');
}

// --------------------------------------------------------
// Buscar al usuario con consulta preparada (anti inyección SQL)
// --------------------------------------------------------
try {
    $stmt = $conexion->prepare(
        "SELECT CI, Nombre, Direccion, Rol, Estado
         FROM usuarios
         WHERE Usuario = ? AND Contrasena = ?
         LIMIT 1"
    );
    $stmt->bind_param('ss', $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila      = $resultado->fetch_assoc();
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log('Error en login: ' . $e->getMessage());
    mostrarMensaje('Error interno', 'No se pudo validar tu acceso. Inténtalo más tarde.');
}

$conexion->close();

// --------------------------------------------------------
// Credenciales incorrectas
// --------------------------------------------------------
if (!$fila) {
    mostrarMensaje('Usuario o contraseña incorrectos');
}

// --------------------------------------------------------
// Cuenta bloqueada o inactiva
// --------------------------------------------------------
if (in_array($fila['Estado'], ['Bloqueado', 'Inactivo'], true)) {
    mostrarMensaje(
        'Acceso Denegado',
        'Tu cuenta se encuentra actualmente <strong>' . htmlspecialchars($fila['Estado']) .
        '</strong>. Contacta al Administrador del sistema.'
    );
}

// --------------------------------------------------------
// Iniciar sesión (se renueva el ID para evitar robo de sesión)
// --------------------------------------------------------
session_regenerate_id(true);

$_SESSION['id']      = $fila['CI'];
$_SESSION['usuario'] = $fila['Nombre'];
$_SESSION['dir']     = $fila['Direccion'];
$_SESSION['rol']     = $fila['Rol'];

// --------------------------------------------------------
// Redirigir según el rol
// --------------------------------------------------------
switch ($fila['Rol']) {
    case 'vendedor':
        header("Location: vendedor.php");
        break;
    case 'Administrador':
        header("Location: Administrador.php");
        break;
    default:
        header("Location: index.php");
        break;
}
exit();