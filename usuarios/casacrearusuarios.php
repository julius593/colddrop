
<?php
// ========================================================
// PROCESAR E INSERTAR NUEVO USUARIO EN LA BASE DE DATOS
// ========================================================

// 1. Incluimos la conexión a la base de datos
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Recibimos todos los campos del formulario enviados por POST
$CI = $_POST['CI'];
$Nombre = $_POST['Nombre'];
$Apellido = $_POST['Apellido'];
$Usuario = $_POST['Usuario'];
$Contrasena = $_POST['Contrasena'];
$Direccion = $_POST['Direccion'];
$Celular = $_POST['Celular'];
$esAdministrador = isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador';
$Rol = $esAdministrador ? $_POST['Rol'] : 'cliente';
$Estado = $esAdministrador ? $_POST['Estado'] : 'Activo';

// 3. Consulta SQL INSERT para guardar el nuevo usuario en la tabla usuarios
$sql = "INSERT INTO usuarios (CI, Nombre, Apellido, Usuario, Contrasena, Direccion, Celular, Rol, Estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssss', $CI, $Nombre, $Apellido, $Usuario, $Contrasena, $Direccion, $Celular, $Rol, $Estado);

// 4. Si se guarda con éxito, mostramos mensaje y enlace para iniciar sesión
if ($stmt->execute()) {
    echo "<div style='font-family:sans-serif; text-align:center; margin-top:50px;'>";
    echo "<h2>¡Nuevo usuario creado exitosamente!</h2>";
    echo "<a href='../princip/iniciosesion.php'>Iniciar Sesión Ahora</a>";
    echo "</div>";
} else {
    echo "Error al registrar el usuario: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
?>

<?php
// ========================================================
// FORMULARIO DE EDICIÓN DE USUARIOS (ACTUALIZARUSUARIOS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$CI = isset($_GET['CI']) ? $_GET['CI'] : '';
$Nombre = $Direccion = $Celular = $Rol = $Estado = '';

if (!empty($CI)) {
    $sql = "SELECT * FROM usuarios WHERE CI = '$CI'";
    $resultado = $conexion->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $CI = $fila['CI'];
        $Nombre = isset($fila['Nombre']) ? $fila['Nombre'] : '';
        $Direccion = isset($fila['Direccion']) ? $fila['Direccion'] : '';
        $Celular = isset($fila['Celular']) ? $fila['Celular'] : '';
        $Rol = isset($fila['Rol']) ? $fila['Rol'] : 'cliente';
        $Estado = isset($fila['Estado']) ? $fila['Estado'] : 'Activo';
    }
}
?>