?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<meta>
<meta>
<title>bienvenido</title>
<body>
    <form action="casaactualizarusuarios.php" method="post">
<h2>USUARIOS</h2>
<label for="">CI</label>
<input type="number" name="CI" value='<?=$CI?>'>

<label for="">Nombre</label>
<input type="text" name="Nombre" value='<?=$Nombre?>'> 

<label for="">Direccion</label>
<input type="text" name="Direccion" value='<?=$Direccion?>'>

<label for="">Celular</label>
<input type="number" name="Celular" value='<?=$Celular?>'>

<label for="">Rol</label>
<input type="text" name="Rol" value='<?=$Rol?>'>

<label for="">Estado</label>
<input type="number" name="Estado" value='<?=$Estado?>'>


<input type="submit" >
    </form>
</body>
</html>

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario - ColdDrop</title>
    
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
        <form action="casaactualizarusuarios.php" method="post">
            <h2>EDITAR USUARIO</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="CI">Carnet de Identidad (CI)</label>
                    <input type="number" name="CI" id="CI" value="<?php echo htmlspecialchars($CI); ?>" readonly style="background-color:#f0f0f0;">
                </div>

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" value="<?php echo htmlspecialchars($Nombre); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Direccion">Dirección</label>
                    <input type="text" name="Direccion" id="Direccion" value="<?php echo htmlspecialchars($Direccion); ?>" required>
                </div>

                <div class="form-group">
                    <label for="Celular">Celular</label>
                    <input type="number" name="Celular" id="Celular" value="<?php echo htmlspecialchars($Celular); ?>">
                </div>

                <div class="form-group">
                    <label for="Rol">Rol</label>
                    <select name="Rol" id="Rol">
                        <option value="cliente" <?php echo ($Rol === 'cliente') ? 'selected' : ''; ?>>cliente</option>
                        <option value="vendedor" <?php echo ($Rol === 'vendedor') ? 'selected' : ''; ?>>vendedor</option>
                        <option value="Administrador" <?php echo ($Rol === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Estado">Estado</label>
                    <select name="Estado" id="Estado">
                        <option value="Activo" <?php echo ($Estado === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                        <option value="Inactivo" <?php echo ($Estado === 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <input type="submit" value="Guardar Cambios">
                </div>
            </div>
        </form>

        <a href="leerusuarios.php" class="links">← Volver a Lista de Usuarios</a>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>
</body>
</html>