
// 1. Consultar información del pedido
$sqlPedido = "SELECT * FROM pedidos WHERE idPEDIDOS = '$idPedido'";
$resPedido = $conn->query($sqlPedido);
$pedido = ($resPedido && $resPedido->num_rows > 0) ? $resPedido->fetch_assoc() : null;

if (!$pedido) {
    echo "<h2 style='text-align:center; margin-top:50px;'>Pedido no encontrado</h2>";
    exit();
}

// 2. Consultar ítems del carrito
$sqlItems = "SELECT c.*, p.Nombre, p.Costo, p.Talla, p.Color 
             FROM Carrito c 
             JOIN productos p ON c.PRODUCTOS_Codigo = p.Codigo 
             WHERE c.PEDIDOS_idPEDIDOS = '$idPedido'";
$resItems = $conn->query($sqlItems);

// 3. Calcular total
$sqlTotal = "SELECT sum(costoTotal) as total FROM Carrito WHERE PEDIDOS_idPEDIDOS = '$idPedido'";
$resTotal = $conn->query($sqlTotal);
$totalRow = $resTotal ? $resTotal->fetch_assoc() : null;
$montoTotal = ($totalRow && $totalRow['total'] !== null) ? (float)$totalRow['total'] : 0;

$st = $pedido['Estado'];
$esAdminOVendedor = isset($_SESSION['rol']) && ($_SESSION['rol'] === 'Administrador' || $_SESSION['rol'] === 'vendedor');
$esAprobado = ($st === 'Entregado' || $st === 'Aprobado');

// Mensaje y enlace para WhatsApp
$msgWs = urlencode("¡Hola ColdDrop! Envíe el pedido #" . $idPedido . " por $" . number_format($montoTotal, 2) . ". Cliente: " . $pedido['Nombre']);
$urlWs = "https://api.whatsapp.com/send?text=" . $msgWs;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pedido #<?php echo htmlspecialchars($idPedido); ?> - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Librería html2pdf.js para descarga directa en PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .header-receipt {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #111;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .brand-title {
            font-size: 28px;
            font-weight: 700;
            color: #111;
            margin: 0;
        }
        .receipt-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }
        .bg-pendiente { background-color: #ffc107; color: #000; }
        .bg-proceso { background-color: #17a2b8; }
        .bg-entregado { background-color: #28a745; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        th {
            background-color: #111;
            color: #fff;
        }
        .summary-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #eee;
        }
        .btn-action-group {
            text-align: right;
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }
        .btn-pdf, .btn-print, .btn-back, .btn-ws, .btn-aprobar {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }
        .btn-pdf { background-color: #dc3545; color: #fff; }
        .btn-print { background-color: #111; color: #fff; }
        .btn-back { background-color: #6c757d; color: #fff; }
        .btn-ws { background-color: #25d366; color: #fff; }
        .btn-aprobar { background-color: #28a745; color: #fff; }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .invoice-box { box-shadow: none; margin: 0; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <?php include 'header.php'; ?>
    </div>

    <!-- Banner informativo según el estado de aprobación -->
    <?php if ($esAprobado): ?>
        <div class="no-print" style="max-width: 800px; margin: 30px auto -10px auto; background: #d4edda; color: #155724; padding: 20px; border-radius: 12px; text-align: center; font-weight: 600; border: 1px solid #c3e6cb;">
            <i class="fa-solid fa-circle-check" style="font-size: 24px; vertical-align: middle; margin-right: 8px;"></i>
            ¡Pedido #<?php echo htmlspecialchars($idPedido); ?> APROBADO! Ya puedes descargar e imprimir tu comprobante oficial en PDF.
        </div>
    <?php else: ?>
        <div class="no-print" style="max-width: 800px; margin: 30px auto -10px auto; background: #fff3cd; color: #856404; padding: 20px; border-radius: 12px; text-align: center; font-weight: 600; border: 1px solid #ffeeba;">
            <i class="fa-solid fa-clock" style="font-size: 24px; vertical-align: middle; margin-right: 8px;"></i>
            Tu pedido #<?php echo htmlspecialchars($idPedido); ?> se encuentra <strong>PENDIENTE DE APROBACIÓN</strong> por nuestro equipo. Una vez APROBADO por el administrador/vendedor, se habilitará la opción para imprimir y descargar tu recibo en PDF.
        </div>
    <?php endif; ?>

    <div class="invoice-box" id="documentToPdf">
        <div class="header-receipt">
            <div>
                <h1 class="brand-title">COLDDROP</h1>
                <p>Comprobante Oficial de Pedido</p>
            </div>
            <div style="text-align: right;">
                <h3 style="margin:0;">Pedido #<?php echo htmlspecialchars($idPedido); ?></h3>
                <p>Fecha: <?php echo htmlspecialchars($pedido['Fecha']); ?></p>
            </div>
        </div>

        <div class="receipt-info" style="display: flex; justify-content: space-between;">
            <div>
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['Nombre']); ?></p>
                <p><strong>Vendedor:</strong> <?php echo htmlspecialchars($pedido['NombreVendedor']); ?></p>
            </div>
            <div style="text-align: right;">
                <p><strong>Estado del Pedido:</strong> 
                    <?php 
                    $badgeClass = ($esAprobado) ? 'bg-entregado' : (($st === 'En proceso' || $st === 'En Proceso') ? 'bg-proceso' : 'bg-pendiente');
                    ?>
                    <span class="status-badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($st); ?></span>
                </p>
            </div>
        </div>

        <!-- Formulario para cambiar estado del pedido (Solo Vendedor/Admin) -->
        <?php if ($esAdminOVendedor): ?>
            <div class="no-print" style="margin-top: 20px; background: #f8f9fa; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                <form method="post" style="display: flex; align-items: center; gap: 10px;">
                    <label style="font-weight: 600;">Estado:</label>
                    <select name="Estado" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
                        <option value="Pendiente" <?php echo ($st === 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="En proceso" <?php echo ($st === 'En proceso' || $st === 'En Proceso') ? 'selected' : ''; ?>>En proceso</option>
                        <option value="Entregado" <?php echo ($st === 'Entregado' || $st === 'Aprobado') ? 'selected' : ''; ?>>Entregado / Aprobado</option>
                    </select>
                    <input type="submit" name="actualizarEstado" value="Actualizar Estado" style="padding: 8px 15px; background: #111; color: #fff; border: none; border-radius: 6px; cursor: pointer;">
                </form>

                <!-- Botón de Aprobar Pedido y Descontar Stock para Admin/Vendedor -->
                <?php if (!$esAprobado): ?>
                    <a href="registrar_venta.php?idPedido=<?php echo htmlspecialchars($idPedido); ?>" class="btn-aprobar" onclick="return confirm('¿Aprobar este pedido y descontar el stock en la base de datos?');">
                        <i class="fa-solid fa-check-double"></i> Aprobar Pedido (Descontar Stock)
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de Productos -->
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Talla / Color</th>
                    <th>Precio Unit.</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resItems && $resItems->num_rows > 0) {
                    while($row = $resItems->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td>".htmlspecialchars($row['PRODUCTOS_Codigo'])."</td>";
                            echo "<td>".htmlspecialchars($row['Nombre'])."</td>";
                            echo "<td>".htmlspecialchars($row['Talla'])." / ".htmlspecialchars($row['Color'])."</td>";
                            echo "<td>$".number_format($row['Costo'], 2)."</td>";
                            echo "<td>".htmlspecialchars($row['cantidad'])."</td>";
                            echo "<td>$".number_format($row['costoTotal'], 2)."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No hay productos registrados en este pedido.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Resumen de Pago -->
        <div class="summary-container">
            <div style="text-align: right;">
                <h2 style="margin: 0; font-size: 24px; color: #111;">Total General: $<?php echo number_format($montoTotal, 2); ?></h2>
                <p style="color: #666; font-size: 13px; margin-top: 5px;">¡Gracias por tu preferencia en ColdDrop!</p>
            </div>
        </div>
    </div>

    <!-- Botones de Impresión y PDF (Disponibles cuando esté APROBADO o sea Admin/Vendedor) -->
    <div class="no-print btn-action-group" style="max-width: 800px; margin: 0 auto 50px auto;">
        <a href="micarrito.php?idPedido=<?php echo htmlspecialchars($idPedido); ?>" class="btn-back">← Volver al Carrito</a>
        <a href="<?php echo $urlWs; ?>" target="_blank" class="btn-ws"><i class="fa-brands fa-whatsapp"></i> Notificar por WhatsApp</a>
        
        <?php if ($esAprobado || $esAdminOVendedor): ?>
            <button onclick="window.print();" class="btn-print"><i class="fa-solid fa-print"></i> Imprimir Recibo</button>
            <button onclick="descargarPDF();" class="btn-pdf"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</button>
        <?php else: ?>
            <button class="btn-print" disabled style="background:#aaa; cursor:not-allowed;" title="Impresión disponible cuando el pedido sea APROBADO por un Administrador"><i class="fa-solid fa-lock"></i> PDF disponible al ser Aprobado</button>
        <?php endif; ?>
    </div>

    <script>
    function descargarPDF() {
        const element = document.getElementById('documentToPdf');
        const opt = {
            margin:       0.5,
            filename:     'Pedido_ColdDrop_#<?php echo $idPedido; ?>.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
    </script>

    <div class="no-print">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
