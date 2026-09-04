<?php
// ========================================================
// PANEL DE ADMINISTRACIÓN EJECUTIVO - COLDDROP
// ========================================================
if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header('Location: iniciosesion.php');
    exit();
}

include_once '../conexion.php';

// Datos del usuario logueado en la sesión
$nombreAdmin = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Administrador';
$ciAdmin = isset($_SESSION['id']) ? $_SESSION['id'] : 'Sin registrar';
$dirAdmin = isset($_SESSION['dir']) ? $_SESSION['dir'] : 'Sin registrar';
$rolAdmin = isset($_SESSION['rol']) ? $_SESSION['rol'] : 'Administrador';

// Consultas para los KPI Widgets superiores
$fechaHoy = date('d/m/Y');
$fechaHoySql = date('Y-m-d');

// 1. Total Productos
$resProd = $conn->query("SELECT COUNT(*) as Total FROM productos");
$totalProductos = $resProd ? (int)$resProd->fetch_assoc()['Total'] : 0;

// 2. Total Pedidos Registrados
$resPed = $conn->query("SELECT COUNT(*) as Total FROM pedidos");
$totalPedidos = $resPed ? (int)$resPed->fetch_assoc()['Total'] : 0;

// 3. Ventas de Hoy
$resVentas = $conn->query("SELECT SUM(MontoTotal) as Total FROM ventas WHERE Fecha LIKE '%$fechaHoy%' OR Fecha LIKE '%$fechaHoySql%'");
$montoHoy = 0;
if ($resVentas) {
    $rowV = $resVentas->fetch_assoc();
    $montoHoy = $rowV['Total'] ? (float)$rowV['Total'] : 0;
}

// 4. Productos con Bajo Stock
$resStock = $conn->query("SELECT COUNT(*) as Total FROM productos WHERE CAST(Stock AS UNSIGNED) <= 5");
$totalBajoStock = $resStock ? (int)$resStock->fetch_assoc()['Total'] : 0;
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
        <!-- HEADER DE BIENVENIDA ADMINISTRATIVA -->
        <div class="admin-welcome-header">
            <div>
                <h1><i class="fa-solid fa-gauge-high"></i> Panel de Administración</h1>
                <p>Bienvenido de nuevo, gestiona tu catálogo, pedidos, usuarios y reportes en tiempo real.</p>
            </div>
            <div class="admin-user-pill">
                <i class="fa-solid fa-circle-user" style="font-size: 20px; color: #2ec4b6;"></i>
                <div>
                    <strong><?php echo htmlspecialchars($nombreAdmin); ?></strong>
                    <div style="font-size: 11px; color: #94a3b8;"><?php echo htmlspecialchars($rolAdmin); ?></div>
                </div>
            </div>
        </div>

        <!-- BARRA DE ESTADÍSTICAS EN VIVO (KPIs) -->
        <div class="admin-stats-bar">
            <div class="stat-widget">
                <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fa-solid fa-shirt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo $totalProductos; ?></div>
                    <div class="stat-label">Productos Activos</div>
                </div>
            </div>

            <div class="stat-widget">
                <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value"><?php echo $totalPedidos; ?></div>
                    <div class="stat-label">Pedidos Registrados</div>
                </div>
            </div>

            <div class="stat-widget">
                <div class="stat-icon" style="background: #fefce8; color: #ca8a04;">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">$<?php echo number_format($montoHoy, 2); ?></div>
                    <div class="stat-label">Ventas de Hoy</div>
                </div>
            </div>

            <div class="stat-widget">
                <div class="stat-icon" style="background: #fef2f2; color: #dc2626;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value" style="color: <?php echo $totalBajoStock > 0 ? '#dc2626' : '#16a34a'; ?>;">
                        <?php echo $totalBajoStock; ?>
                    </div>
                    <div class="stat-label">Alertas de Bajo Stock</div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 1: CENTRO DE GESTIÓN Y OPERACIONES -->
        <div class="section-heading"><i class="fa-solid fa-sliders"></i> Operaciones Principales</div>

        <div class="admin-grid">
            <!-- TARJETA: GESTIÓN DE PRODUCTOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-shirt" style="color: #0284c7;"></i> Productos e Inventario</h3>
                <p>Administra las prendas del catálogo (poleras, pantalones, hoodies, shorts) y controla existencias.</p>
                <a href="../productos/crearproductos.php" class="btn-admin"><i class="fa-solid fa-plus"></i> Registrar Nuevo Producto</a>
                <a href="../productos/leerproductos.php" class="btn-admin secundario"><i class="fa-solid fa-boxes-stacked"></i> Ver Inventario Completo</a>
            </div>

            <!-- TARJETA: GESTIÓN DE USUARIOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-users" style="color: #6366f1;"></i> Usuarios y Personal</h3>
                <p>Controla las cuentas de Administradores y Vendedores. Registra o bloquea usuarios del sistema.</p>
                <a href="../usuarios/crearusuarios.php" class="btn-admin"><i class="fa-solid fa-user-plus"></i> Registrar Nuevo Usuario</a>
                <a href="../usuarios/leerusuarios.php" class="btn-admin secundario"><i class="fa-solid fa-users-gear"></i> Administrar Usuarios</a>
            </div>

            <!-- TARJETA: VENTAS Y PEDIDOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-cash-register" style="color: #16a34a;"></i> Pedidos y Registro de Ventas</h3>
                <p>Genera pedidos de clientes, procesa el carrito de compra y administra el historial de ventas.</p>
                <a href="frompedido.php" class="btn-admin exito"><i class="fa-solid fa-cart-plus"></i> Generar Nuevo Pedido</a>
                <a href="micarrito.php" class="btn-admin secundario"><i class="fa-solid fa-basket-shopping"></i> Ver Carrito / Pedidos</a>
                <a href="leer_ventas.php" class="btn-admin info"><i class="fa-solid fa-receipt"></i> Historial de Ventas (CRUD)</a>
            </div>
        </div>

        <!-- SECCIÓN 2: CENTRO DE REPORTES Y ANALÍTICA -->
        <div class="section-heading"><i class="fa-solid fa-chart-pie"></i> Reportes Ejecutivos & Estadísticas</div>

        <div class="admin-grid">
            <!-- TARJETA DESTACADA: MENÚ PRINCIPAL DE REPORTES -->
            <div class="admin-card" style="border: 2px solid #0f172a; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
                <h3 style="color: #0f172a;"><i class="fa-solid fa-chart-column" style="color: #0f172a;"></i> Menú Principal de Reportes</h3>
                <p>Accede al centro ejecutivo unificado de reportes para una visión analítica global del sistema.</p>
                <a href="../rp/menu_reportes.php" class="btn-admin" style="padding: 15px; font-size: 15px; background: #0f172a;">
                    <i class="fa-solid fa-chart-line"></i> Abrir Centro de Reportes
                </a>
            </div>

            <!-- ACCESOS RÁPIDOS A REPORTES POPULARES -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-bolt" style="color: #eab308;"></i> accesos Rápidos a Reportes</h3>
                <p>Ingresa directamente a las consultas más utilizadas de ventas e inventario.</p>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <a href="../rp/ventastotales_dia.php" class="btn-admin secundario" style="font-size: 12px; padding: 10px;"><i class="fa-solid fa-calendar-day"></i> Ventas Hoy</a>
                    <a href="../rp/producto_mas_vendido.php" class="btn-admin secundario" style="font-size: 12px; padding: 10px;"><i class="fa-solid fa-trophy"></i> Producto Top</a>
                    <a href="../rp/ingresostotales.php" class="btn-admin secundario" style="font-size: 12px; padding: 10px;"><i class="fa-solid fa-sack-dollar"></i> Ingresos</a>
                    <a href="../rp/bajo_stock.php" class="btn-admin peligro" style="font-size: 12px; padding: 10px;"><i class="fa-solid fa-triangle-exclamation"></i> Bajo Stock</a>
                </div>
            </div>

            <!-- TARJETA: PERFIL DEL ADMINISTRADOR -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-user-shield" style="color: #64748b;"></i> Perfil de Administrador</h3>
                <ul class="profile-info">
                    <li><span>Carnet CI:</span> <strong><?php echo htmlspecialchars($ciAdmin); ?></strong></li>
                    <li><span>Dirección:</span> <strong><?php echo htmlspecialchars($dirAdmin); ?></strong></li>
                    <li><span>Rol:</span> <strong><?php echo htmlspecialchars($rolAdmin); ?></strong></li>
                </ul>
                <a href="cerrarsesion.php" class="btn-admin peligro"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>

</body>
</html>
