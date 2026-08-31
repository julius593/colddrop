<?php
// ========================================================
// EDITAR REGISTRO DE VENTA - SOLO ADMINISTRADOR (EDITAR_VENTA.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Verificación estricta de permisos de Administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: leer_ventas.php");
    exit();
}

$idVenta = isset($_GET['idVenta']) ? $_GET['idVenta'] : '';
$ventaData = null;

if (isset($_POST['guardarVenta'])) {
    $idVentaPost = $_POST['idVenta'];
    $cliente = $_POST['Cliente'];
    $monto = (float)$_POST['MontoTotal'];
    $estado = $_POST['Estado'];

    $sqlUpd = "UPDATE ventas SET Cliente = '$cliente', MontoTotal = '$monto', Estado = '$estado' WHERE idVenta = '$idVentaPost'";
    $conn->query($sqlUpd);

    header("Location: leer_ventas.php");
    exit();
}

if (!empty($idVenta)) {
    $sqlSel = "SELECT * FROM ventas WHERE idVenta = '$idVenta'";
    $resSel = $conn->query($sqlSel);
    if ($resSel && $resSel->num_rows > 0) {
        $ventaData = $resSel->fetch_assoc();
    }
}

if (!$ventaData) {
    header("Location: leer_ventas.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta #<?php echo htmlspecialchars($idVenta); ?> - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container" style="margin: 40px auto;">
        <form method="post">
            <h2>EDITAR VENTA #<?php echo htmlspecialchars($idVenta); ?></h2>

            <input type="hidden" name="idVenta" value="<?php echo htmlspecialchars($idVenta); ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label for="Cliente">Nombre del Cliente</label>
                    <input type="text" name="Cliente" id="Cliente" value="<?php echo htmlspecialchars($ventaData['Cliente']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="MontoTotal">Monto Total ($)</label>
                    <input type="number" step="0.01" name="MontoTotal" id="MontoTotal" value="<?php echo htmlspecialchars($ventaData['MontoTotal']); ?>" required>
                </div>

                <div class="form-group full-width">
                    <label for="Estado">Estado de Venta</label>
                    <select name="Estado" id="Estado">
                        <option value="Completada" <?php echo ($ventaData['Estado'] === 'Completada') ? 'selected' : ''; ?>>Completada</option>
                        <option value="Anulada" <?php echo ($ventaData['Estado'] === 'Anulada') ? 'selected' : ''; ?>>Anulada</option>
                        <option value="Pendiente" <?php echo ($ventaData['Estado'] === 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <input type="submit" name="guardarVenta" value="Guardar Cambios de Venta">
                </div>
            </div>
        </form>

        <a href="leer_ventas.php" class="links">← Volver al Historial de Ventas</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
