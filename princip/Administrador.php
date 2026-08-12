<?php
// ========================================================
// PANEL DE ADMINISTRACIÓN - COLDDROP
// ========================================================
if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header('Location: iniciosesion.php');
    exit();
}

// Datos del usuario logueado en la sesión
$nombreAdmin = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Administrador';
$ciAdmin = isset($_SESSION['id']) ? $_SESSION['id'] : 'Sin registrar';
$dirAdmin = isset($_SESSION['dir']) ? $_SESSION['dir'] : 'Sin registrar';
$rolAdmin = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - ColdDrop</title>
    
    <!-- Carga de fuentes e iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para el panel de administración -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <!-- Incluimos la cabecera superior estándar -->
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <h1 class="admin-title">Panel de Administración</h1>

        <div class="admin-grid">
            <!-- TARJETA 1: PERFIL DEL ADMINISTRADOR -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-user-gear"></i> Datos del Administrador</h3>
                <ul class="profile-info">
                    <li><strong>Nombre:</strong> <?php echo htmlspecialchars($nombreAdmin); ?></li>
                    <li><strong>Carnet (CI):</strong> <?php echo htmlspecialchars($ciAdmin); ?></li>
                    <li><strong>Dirección:</strong> <?php echo htmlspecialchars($dirAdmin); ?></li>
                    <li><strong>Rol de Sistema:</strong> <?php echo htmlspecialchars($rolAdmin); ?></li>
                </ul>
                <a href="cerrarsesion.php" class="btn-admin peligro">Cerrar Sesión</a>
            </div>



