<?php
// ========================================================
// FORMULARIO DE EDICIÓN DE PRODUCTOS (ACTUALIZARPRODUCTOS.PHP)
// ========================================================
include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

$Codigo = isset($_GET['Codigo']) ? $_GET['Codigo'] : '';
$Nombre = $Tipo = $Talla = $Color = $Costo = $Stock = $Imagen = '';

if (!empty($Codigo)) {
    $sql = "SELECT * FROM productos WHERE Codigo = '$Codigo'";
    $resultado = $conexion->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $Codigo = $fila['Codigo'];
        $Nombre = isset($fila['Nombre']) ? $fila['Nombre'] : '';
        $Tipo = isset($fila['Tipo']) ? $fila['Tipo'] : 'Polera';
        $Talla = isset($fila['Talla']) ? $fila['Talla'] : '';
        $Color = isset($fila['Color']) ? $fila['Color'] : '';
        $Costo = isset($fila['Costo']) ? $fila['Costo'] : '0';
        $Stock = isset($fila['Stock']) ? $fila['Stock'] : '0';
        $Imagen = isset($fila['Imagen']) ? $fila['Imagen'] : '';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto - ColdDrop</title>
    
    <!-- Carga de fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Hoja de estilos externa para formularios -->
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
    <!-- Incluimos la barra superior de navegación -->
    <?php include '../princip/header.php'; ?>

    <div class="form-container" style="margin: 40px auto;">
        <form action="casaactualizarproductos.php" method="post" enctype="multipart/form-data">
            <h2>EDITAR PRODUCTO</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="Codigo">Código</label>
                    <input type="text" name="Codigo" id="Codigo" value="<?php echo htmlspecialchars($Codigo); ?>" readonly style="background-color:#f0f0f0;">
                </div>

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($Nombre); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Tipo">Tipo</label>
                    <select name="Tipo" id="Tipo">
                        <option value="Polera" <?php echo ($Tipo === 'Polera') ? 'selected' : ''; ?>>Polera</option>
                        <option value="Pantalón" <?php echo ($Tipo === 'Pantalón') ? 'selected' : ''; ?>>Pantalón</option>
                        <option value="Hoodie" <?php echo ($Tipo === 'Hoodie') ? 'selected' : ''; ?>>Hoodie</option>
                        <option value="Short" <?php echo ($Tipo === 'Short') ? 'selected' : ''; ?>>Short</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Talla">Talla</label>
                    <input type="text" name="Talla" id="Talla" value="<?php echo htmlspecialchars($Talla); ?>">
                </div>

                <div class="form-group">
                    <label for="Color">Color</label>
                    <input type="text" name="Color" id="Color" value="<?php echo htmlspecialchars($Color); ?>">
                </div>

                <div class="form-group">
                    <label for="Costo">Costo ($)</label>
                    <input type="number" name="Costo" id="Costo" value="<?php echo htmlspecialchars($Costo); ?>">
                </div>

                <div class="form-group">
                    <label for="Stock">Stock</label>
                    <input type="number" name="Stock" id="Stock" value="<?php echo htmlspecialchars($Stock); ?>">
                </div>

                <div class="form-group">
                    <label for="ImagenFile">Cambiar Imagen (Archivo)</label>
                    <input type="file" name="ImagenFile" id="ImagenFile" accept="image/*">
                </div>

                <div class="form-group full-width">
                    <label for="Imagen">Nombre de Imagen Actual</label>
                    <input type="text" name="Imagen" id="Imagen" value="<?php echo htmlspecialchars($Imagen); ?>">
                </div>

                <div class="form-group full-width">
                    <input type="submit" value="Guardar Cambios">
                </div>
            </div>
        </form>

        <a href="leerproductos.php" class="links">← Volver a Inventario de Productos</a>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>
</body>
</html>
