<?php
// ========================================================
// LISTA DE PRODUCTOS - COLDDROP
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header('Location: ../princip/iniciosesion.php');
    exit();
}

$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos - ColdDrop</title>
    
    <!-- Carga de fuentes e iconos -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Hoja de estilos externa para tablas -->
    <link rel="stylesheet" href="../css/tablas.css">
</head>
<body>

    <!-- Incluimos la cabecera superior -->
    <?php include '../princip/header.php'; ?>

    <div class="admin-container">
        <div class="admin-header-flex">
            <h1><i class="fa-solid fa-shirt"></i> Inventario de Productos</h1>
            <div>
                <a href="../princip/Administrador.php" class="btn-volver">← Volver al Panel Admin</a>
                <a href="crearproductos.php" class="btn-crear">+ Registrar Producto</a>
            </div>
        </div>

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
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            $id = htmlspecialchars($fila['Codigo']);
                            $nombre = htmlspecialchars($fila['Nombre']);
                            $tipo = htmlspecialchars($fila['Tipo']);
                            $talla = htmlspecialchars($fila['Talla']);
                            $color = htmlspecialchars($fila['Color']);
                            $costo = number_format($fila['Costo'], 2);
                            $stock = htmlspecialchars($fila['Stock']);

                            echo "<tr>";
                                echo "<td>$id</td>";
                                echo "<td>$nombre</td>";
                                echo "<td>$tipo</td>";
                                echo "<td>$talla</td>";
                                echo "<td>$color</td>";
                                echo "<td>$$costo</td>";
                                echo "<td>$stock</td>";
                                echo "<td style='text-align: center;'>";
                                    echo "<a href='actualizarproductos.php?Codigo=$id' class='btn-action btn-editar'>Editar</a>";
                                    echo "<a href='elimproductos.php?Codigo=$id' class='btn-action btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\");'>Eliminar</a>";
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

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>

</body>
</html>
