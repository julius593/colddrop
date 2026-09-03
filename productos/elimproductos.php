<?php
include_once '../conexion.php';

// ========================================================
// ELIMINAR PRODUCTO
// ========================================================

// 1. Validar que el código llegó
if (!isset($_GET['Codigo']) || trim($_GET['Codigo']) === '') {
    $mensaje = "Error: no se especificó el código del producto.";
    $tipo = "error";
} else {

    $codigo = $_GET['Codigo'];

    // 2. Consulta preparada
    $sql = "DELETE FROM productos WHERE Codigo = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {

        $mensaje = "Error interno al preparar la consulta.";
        $tipo = "error";

    } else {

        $stmt->bind_param('s', $codigo);
        $stmt->execute();

        // 3. Verificar si se eliminó
        if ($stmt->affected_rows > 0) {
            $mensaje = "¡Producto eliminado exitosamente!";
            $tipo = "success";
        } else {
            $mensaje = "No se encontró ningún producto con ese código.";
            $tipo = "error";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Eliminar Producto - ColdDrop</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
            color: #000000;
        }

        /* Barra superior */
        .top-bar {
            height: 34px;
            background-color: #333333;
            border-bottom: 1px solid #777777;
        }

        /* Contenedor principal */
        .mensaje-container {
            text-align: center;
            padding-top: 50px;
        }

        /* Título */
        .mensaje-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        /* Mensaje correcto */
        .success {
            color: #000000;
        }

        /* Mensaje de error */
        .error {
            color: #b00000;
        }

        /* Enlaces */
        .enlace {
            display: inline-block;
            margin: 5px 10px;
            color: #551a8b;
            text-decoration: underline;
            font-size: 16px;
        }

        .enlace:hover {
            color: #0000ee;
        }

    </style>

</head>

<body>

    <!-- Barra superior -->
    <div class="top-bar"></div>

    <!-- Mensaje -->
    <div class="mensaje-container">

        <h1 class="<?php echo $tipo; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </h1>

        <?php if ($tipo === "success"): ?>

            <a href="leerproductos.php" class="enlace">
                Volver a Productos
            </a>

        <?php else: ?>

            <a href="leerproductos.php" class="enlace">
                Volver a Productos
            </a>

        <?php endif; ?>

    </div>

</body>
</html>