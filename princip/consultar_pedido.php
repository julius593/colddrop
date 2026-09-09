<?php
// ========================================================
// CONSULTAR ESTADO DE PEDIDO DEL CLIENTE - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$pedido = null;

if (!empty($busqueda)) {
    $sql = "SELECT * FROM pedidos WHERE idPEDIDOS = '$busqueda' OR Nombre LIKE '%$busqueda%' ORDER BY idPEDIDOS DESC LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows > 0) {
        $pedido = $res->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Estado de Pedido - ColdDrop</title>
    <link rel="stylesheet" href="../css/formularios.css">
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container" style="margin: 40px auto; max-width: 700px;">
        <h2>VER ESTADO DE MI PEDIDO</h2>
        <p style="text-align: center; color: #666;">Ingresa tu código de pedido o tu nombre/celular:</p>

        <form method="get" action="consultar_pedido.php">
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <input type="text" name="busqueda" placeholder="Ej. 12 o tu nombre" value="<?php echo htmlspecialchars($busqueda); ?>" required style="flex:1;">
                <input type="submit" value="Buscar Pedido" style="width: auto; background: #111; color: #fff; border-radius: 6px; cursor: pointer;">
            </div>
        </form>

        <?php if (!empty($busqueda) && !$pedido): ?>
            <p style="color: red; text-align: center;">No se encontró ningún pedido con el dato ingresado.</p>
        <?php endif; ?>

        <?php if ($pedido): ?>
            <div style="background: #fff; padding: 20px; border: 1px solid #ccc; border-radius: 8px; margin-top: 20px;">
                <h3>Pedido #<?php echo $pedido['idPEDIDOS']; ?></h3>
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['Nombre']); ?></p>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['Fecha']); ?></p>
                <p><strong>Estado Actual:</strong> <span style="font-weight: bold; color: #28a745;"><?php echo htmlspecialchars($pedido['Estado']); ?></span></p>
                <p><strong>Vendedor asignado:</strong> <?php echo htmlspecialchars($pedido['NombreVendedor']); ?></p>
            </div>
        <?php endif; ?>

        <div style="margin-top: 20px; text-align: center;">
            <a href="poleras.php" class="links">← Volver al Catálogo</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
