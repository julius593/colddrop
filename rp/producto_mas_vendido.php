<?php
// ========================================================
// REPORTE: PRODUCTO MÁS VENDIDO EN EL MES - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}

$sql = "SELECT p.Codigo, p.Nombre, p.Tipo, p.Costo, p.Imagen, SUM(c.cantidad) AS TotalVendido
        FROM carrito c
        INNER JOIN productos p ON p.Codigo = c.PRODUCTOS_Codigo
        GROUP BY p.Codigo, p.Nombre, p.Tipo, p.Costo, p.Imagen
        ORDER BY TotalVendido DESC
        LIMIT 1";

$resultado = $conn->query($sql);
$producto = $resultado ? $resultado->fetch_assoc() : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Producto Más Vendido - ColdDrop</title>
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
    <?php include '../princip/header.php'; ?>

    <div class="form-container" style="margin: 40px auto; max-width: 600px; text-align: center;">
        <h2>PRODUCTO MÁS VENDIDO (EN EL MES)</h2>
        <a href="menu_reportes.php" style="display:inline-block; margin-bottom: 20px; color: #555;">← Volver al Menú de Reportes</a>

        <?php if ($producto): ?>
            <div style="border: 2px solid #111; padding: 25px; border-radius: 10px; background: #fff;">
                <?php $img = !empty($producto['Imagen']) ? $producto['Imagen'] : 'default.jpg'; ?>
                <img src="../imagenes/<?php echo htmlspecialchars($img); ?>" width="150" height="150" style="object-fit: cover; border-radius: 8px;">
                <h3 style="margin-top: 15px;"><?php echo htmlspecialchars($producto['Nombre']); ?></h3>
                <p><strong>Código:</strong> <?php echo htmlspecialchars($producto['Codigo']); ?> | <strong>Tipo:</strong> <?php echo htmlspecialchars($producto['Tipo']); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($producto['Costo'], 2); ?></p>
                <h3 style="color: #28a745; margin-top: 15px;">Total Vendidos: <?php echo $producto['TotalVendido']; ?> unidades</h3>
            </div>
        <?php else: ?>
            <p>No hay datos suficientes de ventas este mes.</p>
        <?php endif; ?>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>
