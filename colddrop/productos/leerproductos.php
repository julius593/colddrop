<?php
// ========================================================
// LISTA DE PRODUCTOS CON ALERTA Y DESTACADO DE BAJO STOCK (LEERPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header('Location: ../princip/iniciosesion.php');
    exit();
}

$sql = "SELECT * FROM productos ORDER BY CAST(Stock AS UNSIGNED) ASC";
$resultado = $conexion->query($sql);

$productosBajoStockCount = 0;
$productosList = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productosList[] = $fila;
        if ((int)$fila['Stock'] <= 5) {
            $productosBajoStockCount++;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos - ColdDrop</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link rel="stylesheet" href="../css/tablas.css">
    <style>
        .badge-stock {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 13px;
        }
        .badge-stock-danger {
            background-color: #dc3545;
            color: #ffffff;
        }
        .badge-stock-warning {
            background-color: #ffc107;
            color: #000000;
        }
        .badge-stock-normal {
            background-color: #28a745;
            color: #ffffff;
        }
        .row-low-stock {
            background-color: #fff5f5 !important;
        }
        .alert-banner {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

    <?php include '../princip/header.php'; ?>

    <div class="admin-container">
        <div class="admin-header-flex">
            <h1><i class="fa-solid fa-shirt"></i> Inventario de Productos</h1>
            <div>
                <a href="../princip/Administrador.php" class="btn-volver">← Volver al Panel Admin</a>
                <a href="crearproductos.php" class="btn-crear">+ Registrar Producto</a>
            </div>
        </div>

        <!-- NOTIFICACIÓN DE PRODUCTOS CON BAJO STOCK (REQUERIMIENTO SPRINT 4) -->
        <?php if ($productosBajoStockCount > 0): ?>
            <div class="alert-banner">
                <div>
                    <strong style="color: #856404;"><i class="fa-solid fa-triangle-exclamation"></i> Notificación de Inventario:</strong>
                    <span style="color: #856404;"> Se identificaron <strong><?php echo $productosBajoStockCount; ?> productos</strong> con stock bajo (igual o menor a 5 unidades). Se sugiere reponer inventario.</span>
                </div>
                <a href="../rp/bajo_stock.php" style="background: #dc3545; color: #fff; text-decoration: none; padding: 6px 14px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                    Ver Reporte de Bajo Stock
                </a>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Talla</th>
                        <th>Color</th>
                        <th>Costo ($)</th>
                        <th>Stock</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($productosList) > 0) {
                        foreach ($productosList as $fila) {
                            $id = htmlspecialchars($fila['Codigo']);
                            $nombre = htmlspecialchars($fila['Nombre']);
                            $tipo = htmlspecialchars($fila['Tipo']);
                            $talla = htmlspecialchars($fila['Talla']);
                            $color = htmlspecialchars($fila['Color']);
                            $costo = number_format($fila['Costo'], 2);
                            $stockNum = (int)$fila['Stock'];

                            // Asignar estilo de alerta según cantidad de stock
                            if ($stockNum == 0) {
                                $stockBadge = "<span class='badge-stock badge-stock-danger'><i class='fa-solid fa-ban'></i> Agotado (0)</span>";
                                $rowCls = "class='row-low-stock'";
                            } elseif ($stockNum <= 5) {
                                $stockBadge = "<span class='badge-stock badge-stock-warning'><i class='fa-solid fa-triangle-exclamation'></i> Bajo ({$stockNum})</span>";
                                $rowCls = "class='row-low-stock'";
                            } else {
                                $stockBadge = "<span class='badge-stock badge-stock-normal'>{$stockNum} unid.</span>";
                                $rowCls = "";
                            }

                            echo "<tr $rowCls>";
                                echo "<td>$id</td>";
                                echo "<td>$nombre</td>";
                                echo "<td>$tipo</td>";
                                echo "<td>$talla</td>";
                                echo "<td>$color</td>";
                                echo "<td>$$costo</td>";
                                echo "<td>$stockBadge</td>";
                                echo "<td style='text-align: center;'>";
                                    echo "<a href='actualizarproductos.php?Codigo=$id' class='btn-action btn-editar'>Editar</a>";
                                    echo "<a href='elimproductos.php?Codigo=$id' class='btn-action btn-eliminar' onclick='confirmarEliminacion(\"$id\"); return false;'>Eliminar</a>";
                                    echo "<a href='casaleerproductos.php?Codigo=$id' class='btn-action btn-mostrar'>Detalles</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>No hay productos en inventario.</td></tr>";
                    }

                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script de confirmación con SweetAlert2 -->
    <script>
    function confirmarEliminacion(codigo) {
        Swal.fire({
            title: '¿Eliminar Producto?',
            text: "Esta acción eliminará el producto " + codigo + " del inventario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'elimproductos.php?Codigo=' + codigo;
            }
        });
    }
    </script>

    <?php include '../princip/footer.php'; ?>

</body>
</html>
