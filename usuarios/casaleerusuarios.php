<?php
// ========================================================
// VER DETALLES DE USUARIO - COLDROP
// ========================================================

include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// ========================================================
// RECIBIR CI
// ========================================================

$CI = isset($_GET['CI']) ? trim($_GET['CI']) : '';

$usuarioData = null;

// ========================================================
// BUSCAR USUARIO
// ========================================================

if ($CI !== '') {

    $sql = "SELECT * FROM usuarios WHERE CI = ?";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("s", $CI);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $usuarioData = $resultado->fetch_assoc();
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalles del Usuario - ColdDrop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link rel="stylesheet" href="../css/admin.css">

</head>

<body>

<?php include '../princip/header.php'; ?>

<div class="admin-container">

    <h1 class="admin-title">
        Detalles del Usuario
    </h1>


    <?php if ($usuarioData): ?>

        <div class="admin-card" style="max-width: 600px; margin: 0 auto;">

            <h3>
                <i class="fa-solid fa-id-card"></i>
                Información del Usuario
            </h3>

            <ul class="profile-info">

                <li>
                    <strong>Carnet de Identidad (CI):</strong>
                    <?php echo htmlspecialchars($usuarioData['CI']); ?>
                </li>

                <li>
                    <strong>Nombre:</strong>
                    <?php echo htmlspecialchars($usuarioData['Nombre'] ?? ''); ?>
                </li>

                <li>
                    <strong>Apellido:</strong>
                    <?php echo htmlspecialchars($usuarioData['Apellido'] ?? ''); ?>
                </li>

                <li>
                    <strong>Usuario:</strong>
                    <?php echo htmlspecialchars($usuarioData['Usuario'] ?? ''); ?>
                </li>

                <li>
                    <strong>Dirección:</strong>
                    <?php echo htmlspecialchars($usuarioData['Direccion'] ?? ''); ?>
                </li>

                <li>
                    <strong>Celular:</strong>
                    <?php echo htmlspecialchars($usuarioData['Celular'] ?? ''); ?>
                </li>

                <li>
                    <strong>Rol:</strong>
                    <?php echo htmlspecialchars($usuarioData['Rol'] ?? ''); ?>
                </li>

                <li>
                    <strong>Estado:</strong>
                    <?php echo htmlspecialchars($usuarioData['Estado'] ?? ''); ?>
                </li>

            </ul>

            <div style="margin-top: 20px;">

                <a href="leerusuarios.php" class="btn-nuevo">
                    <i class="fa-solid fa-arrow-left"></i>
                    Volver
                </a>

            </div>

        </div>


    <?php else: ?>

        <div class="admin-card" style="text-align: center;">

            <h3>
                <i class="fa-solid fa-circle-exclamation"></i>
                Usuario no encontrado
            </h3>

            <p>
                No se encontró ningún usuario con el CI:
                <strong>
                    <?php echo htmlspecialchars($CI); ?>
                </strong>
            </p>

            <a href="listausuarios.php" class="btn-nuevo">
                <i class="fa-solid fa-arrow-left"></i>
                Volver a usuarios
            </a>

        </div>

    <?php endif; ?>

</div>

</body>
</html>

