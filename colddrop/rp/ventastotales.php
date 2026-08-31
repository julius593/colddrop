<?php
/**
 * Reporte: Producto más vendido (del mes actual)
 * -------------------------------------------------
 * Recorre las ventas del mes en curso, suma las cantidades vendidas
 * por producto (a través de `carrito`, que es donde se guarda el detalle
 * de cada pedido/venta) y muestra el que más unidades vendió.
 */

// ==============================
// 1. Conexión a la base de datos
// ==============================
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$baseDatos = 'colddrop';

$conexion = new mysqli($host, $usuario, $contrasena, $baseDatos);

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

$resultado = $conexion->query($sql);
$masVendido = $resultado ? $resultado->fetch_assoc() : null;

$conexion->close();

// Nombre del mes en español, sin depender de la configuración regional del servidor
$mesesEs = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
];
$mesActualTexto = $mesesEs[(int) date('n')] . ' ' . date('Y');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte - Producto más vendido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 40px;
        }
        .reporte {
            max-width: 420px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
        }
        .reporte h1 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }
        .reporte .periodo {
            color: #777;
            font-size: 14px;
            margin-bottom: 25px;
        }
        .producto-nombre {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .cantidad {
            font-size: 15px;
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .sin-datos {
            color: #999;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="reporte">
        <h1>Producto más vendido</h1>
        <div class="periodo"><?= htmlspecialchars($mesActualTexto) ?></div>

        <?php if ($masVendido): ?>
            <div class="producto-nombre"><?= htmlspecialchars($masVendido['Nombre']) ?></div>
            <div class="cantidad"><?= (int) $masVendido['TotalVendido'] ?> unidades vendidas</div>
        <?php else: ?>
            <div class="sin-datos">Aún no hay ventas registradas este mes.</div>
        <?php endif; ?>
    </div>

</body>
</html>