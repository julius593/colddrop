<?php
// ========================================================
// FORMULARIO DE REGISTRO DE PRODUCTOS (CREARPRODUCTOS.PHP)
// ========================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Productos - ColdDrop</title>
    
    <!-- Carga de fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Hoja de estilos externa para formularios -->
    <link rel="stylesheet" href="../css/formularios.css">

    <!-- Librerías de jQuery y jQuery Validate -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
</head>
<body>
    <!-- Incluimos la barra superior de navegación -->
    <?php include '../princip/header.php'; ?>

    <div class="form-container" style="margin: 40px auto;">
        <!-- Formulario horizontal de 2 columnas con soporte para subida de imágenes -->
        <form action="casacrearproductos.php" id="formProductos" method="post" enctype="multipart/form-data">
            <h2>REGISTRO DE PRODUCTO</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="Codigo">Código</label>
                    <input type="text" name="Codigo" id="Codigo" placeholder="Ej. P009" required>
                </div>

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" required>
                </div>

                <div class="form-group">
                    <label for="Tipo">Tipo</label>
                    <select name="Tipo" id="Tipo">
                        <option value="Polera" selected>Polera</option>
                        <option value="Pantalón">Pantalón</option>
                        <option value="Hoodie">Hoodie</option>
                        <option value="Short">Short</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Talla">Talla</label>
                    <input type="text" name="Talla" id="Talla" placeholder="Ej. M, L, XL, 32">
                </div>

                <div class="form-group">
                    <label for="Color">Color</label>
                    <input type="text" name="Color" id="Color">
                </div>

                <div class="form-group">
                    <label for="Costo">Costo ($)</label>
                    <input type="number" name="Costo" id="Costo" required>
                </div>

                <div class="form-group">
                    <label for="Stock">Stock (Cantidad Inicial)</label>
                    <input type="number" name="Stock" id="Stock" required min="0">
                </div>

                <div class="form-group">
                    <label for="ImagenFile">Subir Imagen del Producto</label>
                    <input type="file" name="ImagenFile" id="ImagenFile" accept="image/*">
                </div>

                <div class="form-group full-width">
                    <label for="ImagenText">O bien, escribe el nombre del archivo existente</label>
                    <input type="text" name="Imagen" id="ImagenText" placeholder="ej. polera1.jpg">
                </div>

                <div class="form-group full-width">
                    <input type="submit" value="Registrar Producto">
                </div>
            </div>
        </form>

        <!-- Botón para retornar al Panel Admin si la sesión lo amerita -->

</body>
</html>