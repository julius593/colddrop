<?php
// ========================================================
// ENCABEZADO PRINCIPAL Y NAVEGACIÓN (HEADER)
// ========================================================

// Si la sesión no ha iniciado y aún no se han enviado encabezados, la iniciamos de forma segura
if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Carga de fuentes de Google Fonts y Font-Awesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Madimi+One&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para el encabezado -->
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <header>
        <!-- Logo de la marca -->
        <div>
            <a href="../princip/inicio.php"><img id="logoh" src="../imagenes/Captura_de_pantalla_2026-04-23_121404-removebg-preview.png" alt="ColdDrop Logo"></a>
        </div>

        <!-- Menú de categorías desplegable -->
        <div>
            <input class="menu" type="checkbox" id="menu-toggle">
            <label class="menu" for="menu-toggle" id="menu-label">Menu ▾</label>
            <nav class="dropdown">
                <a href="../princip/hoodeis.php" class="menu">Hoodies</a>
                <a href="../princip/poleras.php" class="menu">Poleras</a>
                <a href="../princip/pantalones.php" class="menu">Pantalones</a>
                <a href="../princip/shorts.php" class="menu">Shorts</a>
            </nav>
        </div>

        <!-- Enlace Nosotros -->
        <div>
            <a class="menu" href="../princip/nosotros.php">Nosotros</a>
        </div>

        <!-- Control de sesión -->
        <?php if (isset($_SESSION['usuario'])): ?>
            <div>
                <span class="menu" style="color: #666; cursor: default;">Hola, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
            </div>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador'): ?>
                <div>
                    <a class="menu" href="../princip/Administrador.php"><i class="fa-solid fa-user-gear"></i> Panel Admin</a>
                </div>
            <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'vendedor'): ?>
                <div>
                    <a class="menu" href="../princip/vendedor.php"><i class="fa-solid fa-user-tie"></i> Panel Vendedor</a>
                </div>
            <?php endif; ?>
            <div>
                <a class="menu" href="../princip/cerrarsesion.php">Logout</a>
            </div>
        <?php else: ?>
            <div>
                <a class="menu" href="../princip/iniciosesion.php">Login</a>
            </div>
            <div>
                <a class="menu" href="../usuarios/crearusuarios.php">Register</a>
            </div>
        <?php endif; ?>
         
<div>
    <a class="menu" href="../fm/formulario.php"></a>
</div>
 
        <!-- Acceso al Carrito -->
        <div class="carrito">
            <a href="../princip/micarrito.php" class="btn-carrito">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </a>
        </div>
    </header>
</body>
</html>