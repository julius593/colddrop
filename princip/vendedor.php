<?php
// ========================================================
// PANEL DEL VENDEDOR - COLDDROP
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'vendedor') {
    header('Location: iniciosesion.php');
    exit();
}

// Datos del vendedor en la sesión activa
$nombreVendedor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Vendedor';
$ciVendedor = isset($_SESSION['id']) ? $_SESSION['id'] : 'Sin registrar';
$dirVendedor = isset($_SESSION['dir']) ? $_SESSION['dir'] : 'Sin registrar';
$rolVendedor = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'Vendedor';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Vendedor - ColdDrop</title>
    
    <!-- Carga de fuentes e iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para el panel -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

    <!-- Incluimos la cabecera superior estándar -->
    <?php include 'header.php'; ?>

    <div class="admin-container">
        <h1 class="admin-title">Panel del Vendedor</h1>

        <div class="admin-grid">
            <!-- TARJETA 1: PERFIL DEL VENDEDOR -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-user-tie"></i> Datos del Vendedor</h3>
                <ul class="profile-info">
                    <li><strong>Nombre:</strong> <?php echo htmlspecialchars($nombreVendedor); ?></li>
                    <li><strong>Carnet (CI):</strong> <?php echo htmlspecialchars($ciVendedor); ?></li>
                    <li><strong>Dirección:</strong> <?php echo htmlspecialchars($dirVendedor); ?></li>
                    <li><strong>Rol de Sistema:</strong> <?php echo htmlspecialchars($rolVendedor); ?></li>
                </ul>
                <a href="cerrarsesion.php" class="btn-admin peligro">Cerrar Sesión</a>
            </div>

            <!-- TARJETA 2: OPERACIONES DE VENTAS Y PEDIDOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-cash-register"></i> Ventas y Pedidos</h3>
                <p>Genera ventas rápidas de clientes, consulta tu historial de ventas y atiende pedidos activos.</p>
                <a href="frompedido.php" class="btn-admin">Generar Nuevo Pedido</a>
                <a href="micarrito.php" class="btn-admin secundario">Ver Carrito / Pedidos Activos</a>
                <a href="leer_ventas.php" class="btn-admin" style="background-color: #28a745;"><i class="fa-solid fa-receipt"></i> Mi Historial de Ventas</a>
            </div>

            <!-- TARJETA 3: CATÁLOGO Y PRODUCTOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-boxes-stacked"></i> Catálogo de Prendas</h3>
                <p>Consulta las prendas disponibles en el inventario.</p>
                <a href="poleras.php" class="btn-admin secundario">Ver Poleras</a>
                <a href="pantalones.php" class="btn-admin secundario">Ver Pantalones</a>
            </div>
        </div>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>

</body>
</html>
