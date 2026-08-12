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

