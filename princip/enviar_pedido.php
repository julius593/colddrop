<?php
// ========================================================
// ENVIAR / CONFIRMAR PEDIDO DEL CLIENTE (ENVIAR_PEDIDO.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$idPedido = isset($_GET['idPedido']) ? $_GET['idPedido'] : '';

if (empty($idPedido)) {
    header("Location: micarrito.php");
    exit();
}

// 1. Obtener los productos en el carrito para este pedido
$sqlItems = "SELECT c.*, p.Nombre, p.Costo 
             FROM Carrito c 
             JOIN productos p ON c.PRODUCTOS_Codigo = p.Codigo 
             WHERE c.PEDIDOS_idPEDIDOS = '$idPedido'";
$resItems = $conn->query($sqlItems);

// 2. Calcular monto total
$sqlTotal = "SELECT sum(costoTotal) as total FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resTotal = $conn->query($sqlTotal);
$totalRow = $resTotal ? $resTotal->fetch_assoc() : null;
$montoTotal = ($totalRow && $totalRow['total'] !== null) ? (float)$totalRow['total'] : 0;

// Si el formulario fue enviado
if (isset($_POST['confirmarEnvio'])) {
    $nombreCliente = $_POST['nombreCliente'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $notas = isset($_POST['notas']) ? $_POST['notas'] : '';

    $nombreCompleto = $nombreCliente . " (Tel: " . $celular . " - Dir: " . $direccion . ")";

    // Actualizamos el pedido con los datos del cliente y estado 'Pendiente'
    $sqlUpdate = "UPDATE pedidos SET Nombre = '$nombreCompleto', Estado = 'Pendiente' WHERE idPEDIDOS = '$idPedido'";
    $conn->query($sqlUpdate);

    // Redirigimos a la vista de comprobante con código QR y WhatsApp
    header("Location: detalle_pedido.php?idPedido=$idPedido&enviado=1&celular=" . urlencode($celular));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Pedido #<?php echo htmlspecialchars($idPedido); ?> - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="form-container" style="margin: 40px auto;">
        <form method="post">
            <h2><i class="fa-solid fa-paper-plane"></i> ENVIAR PEDIDO #<?php echo htmlspecialchars($idPedido); ?></h2>
            <p style="text-align:center; color:#666; margin-bottom:20px;">Monto Total a Pagar: <strong>$<?php echo number_format($montoTotal, 2); ?></strong></p>

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="nombreCliente">Nombre y Apellido *</label>
                    <input type="text" name="nombreCliente" id="nombreCliente" placeholder="Ej. Carlos Mamani" required>
                </div>

                <div class="form-group">
                    <label for="celular">Celular / WhatsApp *</label>
                    <input type="number" name="celular" id="celular" placeholder="Ej. 77998811" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección de Entrega *</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Ej. Av. Blanco Galindo #123" required>
                </div>

                <div class="form-group full-width">
                    <label for="notas">Notas u Observaciones (Opcional)</label>
                    <input type="text" name="notas" id="notas" placeholder="Ej. Entregar por las tardes o dejar en recepción">
                </div>

                <div class="form-group full-width">
                    <input type="submit" name="confirmarEnvio" value="Confirmar y Enviar Pedido" style="background-color: #28a745; font-size:18px;">
                </div>
            </div>
        </form>

        <a href="micarrito.php?idPedido=<?php echo htmlspecialchars($idPedido); ?>" class="links">← Volver a Modificar Carrito</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
