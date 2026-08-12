<?php
// ========================================================
// VER DETALLES DE USUARIO (CASALEERUSUARIOS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$CI = isset($_GET['CI']) ? $_GET['CI'] : (isset($_GET['idCI']) ? $_GET['idCI'] : '');
$usuarioData = null;

if (!empty($CI)) {
    $sql = "SELECT * FROM usuarios WHERE CI = '$CI'";
    $resultado = $conexion->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $usuarioData = $resultado->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario - ColdDrop</title>
    
    <!-- Carga de fuentes e iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para panel admin -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- Incluimos la cabecera superior -->
    <?php include '../princip/header.php'; ?>

    <div class="admin-container">
        <h1 class="admin-title">Detalles del Usuario</h1>

        <?php if ($usuarioData): ?>
            <div class="admin-card" style="max-width: 600px; margin: 0 auto;">
                <h3><i class="fa-solid fa-id-card"></i> Información del Usuario</h3>
                <ul class="profile-info">
                    <li><strong>Carnet de Identidad (CI):</strong> <?php echo htmlspecialchars($usuarioData['CI']); ?></li>
                    <li><strong>Nombre:</strong> <?php echo htmlspecialchars(isset($usuarioData['Nombre']) ? $usuarioData['Nombre'] : ''); ?></li>
                    <li><strong>Apellido:</strong> <?php echo htmlspecialchars(isset($usuarioData['Apellido']) ? $usuarioData['Apellido'] : ''); ?></li>
                    <li><strong>Usuario:</strong> <?php echo htmlspecialchars(isset($usuarioData['Usuario']) ? $usuarioData['Usuario'] : ''); ?></li>
                    <li><strong>Dirección:</strong> <?php echo htmlspecialchars(isset($usuarioData['Direccion']) ? $usuarioData['Direccion'] : ''); ?></li>
                    <li><strong>Celular:</strong> <?php echo htmlspecialchars(isset($usuarioData['Celular']) ? $usuarioData['Celular'] : ''); ?></li>
                    <li><strong>Rol:</strong> <?php echo htmlspecialchars(isset($usuarioData['Rol']) ? $usuarioData['Rol'] : ''); ?></li>
                    <li><strong>Estado:</strong> <?php echo htmlspecialchars(isset($usuarioData['Estado']) ? $usuarioData['Estado'] : ''); ?></li>
                </ul>
                
                <a href="leerusuarios.php" class="btn-admin secundario">← Volver a Lista de Usuarios</a>
            </div>
        <?php else: ?>
            <div class="admin-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
                <p>No se encontró el usuario solicitado.</p>
                <a href="leerusuarios.php" class="btn-admin secundario">← Volver a Lista de Usuarios</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>
</body>
</html>
