<?php
// ========================================================
// FORMULARIO DE CREACIÓN DE NUEVO PEDIDO
// ========================================================
session_start();

// Obtenemos el nombre del vendedor actual en sesión, o 'General' por defecto
$vendedor = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'General';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Nuevo Pedido - ColdDrop</title>
    
    <!-- Carga de la fuente Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Hoja de estilos externa para generación de pedidos -->
    <link rel="stylesheet" href="../css/frompedido.css">
</head>
<body>
    <div class="form-container">
        <!-- Formulario para crear un nuevo pedido que procesa en nuevo_pedido.php -->
        <form action="nuevo_pedido.php" method="POST">
            <h2>Generar Pedido</h2>

            <label for="nombre">Nombre Cliente:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Ej. Juan Pérez" required>

            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>

            <!-- Campo oculto para indicar el estado inicial del pedido -->
            <input type="hidden" name="estado" value="En Proceso">

            <label for="nombreVendedor">Vendedor:</label>
            <input type="text" name="nombreVendedor" id="nombreVendedor" value="<?php echo htmlspecialchars($vendedor); ?>" readonly>
            <input type="submit" value="Iniciar Nuevo Pedido">
        </form>

        <a href="micarrito.php" class="links">Volver al Carrito</a>
    </div>
</body>
</html>
