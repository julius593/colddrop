
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

            <!-- TARJETA 2: GESTIÓN DE USUARIOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-users"></i> Gestión de Usuarios</h3>
                <p>Registra nuevos usuarios del sistema o administra los existentes.</p>
                <a href="../usuarios/crearusuarios.php" class="btn-admin">Registrar Nuevo Usuario</a>
                <a href="../usuarios/leerusuarios.php" class="btn-admin secundario">Ver Lista de Usuarios</a>
            </div>

            <!-- TARJETA 3: GESTIÓN DE PRODUCTOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-shirt"></i> Gestión de Productos</h3>
                <p>Agrega prendas al inventario (poleras, pantalones, hoodies, shorts).</p>
                <a href="../productos/crearproductos.php" class="btn-admin">Registrar Nuevo Producto</a>
                <a href="../productos/leerproductos.php" class="btn-admin secundario">Ver Inventario de Productos</a>
            </div>

            <!-- TARJETA 4: VENTAS Y PEDIDOS -->
            <div class="admin-card">
                <h3><i class="fa-solid fa-cart-shopping"></i> Pedidos y Ventas</h3>
                <p>Crea pedidos de clientes, consulta el historial de ventas y atiende pedidos.</p>
                <a href="frompedido.php" class="btn-admin">Generar Nuevo Pedido</a>
                <a href="micarrito.php" class="btn-admin secundario">Ver Carrito / Pedidos</a>
                <a href="leer_ventas.php" class="btn-admin" style="background-color: #28a745;"><i class="fa-solid fa-receipt"></i> Historial de Ventas (CRUD)</a>
            </div>
        </div>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include 'footer.php'; ?>

</body>
</html>

