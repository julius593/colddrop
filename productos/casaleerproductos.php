<?php
// ========================================================
// VER DETALLES DE PRODUCTO (CASALEERPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$Codigo = isset($_GET['Codigo']) ? $_GET['Codigo'] : (isset($_GET['idCodigo']) ? $_GET['idCodigo'] : '');
$productoData = null;

if (!empty($Codigo)) {
    $sql = "SELECT * FROM productos WHERE Codigo = '$Codigo'";
    $resultado = $conexion->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $productoData = $resultado->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto - ColdDrop</title>
    
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
        <h1 class="admin-title">Detalles del Producto</h1>

        <?php if ($productoData): ?>
            <?php $img = !empty($productoData['Imagen']) ? $productoData['Imagen'] : 'default.jpg'; ?>
            <div class="admin-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
                <img src="../imagenes/<?php echo htmlspecialchars($img); ?>" alt="Producto" style="max-width: 250px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                
                <h3><i class="fa-solid fa-tag"></i> <?php echo htmlspecialchars($productoData['Nombre']); ?></h3>
                
                <ul class="profile-info" style="text-align: left;">
                    <li><strong>Código:</strong> <?php echo htmlspecialchars($productoData['Codigo']); ?></li>
                    <li><strong>Tipo de Prenda:</strong> <?php echo htmlspecialchars($productoData['Tipo']); ?></li>
                    <li><strong>Talla:</strong> <?php echo htmlspecialchars($productoData['Talla']); ?></li>
                    <li><strong>Color:</strong> <?php echo htmlspecialchars($productoData['Color']); ?></li>
                    <li><strong>Precio:</strong> $<?php echo number_format($productoData['Costo'], 2); ?></li>
                    <li><strong>Stock Disponible:</strong> <?php echo htmlspecialchars($productoData['Stock']); ?> unidades</li>
                </ul>
                
                <a href="leerproductos.php" class="btn-admin secundario">← Volver a Inventario de Productos</a>
            </div>
        <?php else: ?>
            <div class="admin-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
                <p>No se encontró el producto solicitado.</p>
                <a href="leerproductos.php" class="btn-admin secundario">← Volver a Inventario de Productos</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>
</body>
</html>
