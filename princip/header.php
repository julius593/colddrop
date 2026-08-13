
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

        <!-- Acceso al Carrito -->
        <div class="carrito">
            <a href="../princip/micarrito.php" class="btn-carrito">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </a>
        </div>
    </header>
</body>
</html>