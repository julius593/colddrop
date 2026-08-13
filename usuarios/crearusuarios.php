<?php
// ========================================================
// FORMULARIO DE REGISTRO DE USUARIOS (CREARUSUARIOS.PHP)
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
    <title>Registro de Usuarios - ColdDrop</title>
    
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
        <!-- Formulario horizontal de 2 columnas que envía los datos a casacrearusuarios.php -->
        <form action="casacrearusuarios.php" id="formUsuarios" method="post">
            <h2>REGISTRO DE USUARIO</h2>

            <div class="form-grid">
                <div class="form-group">
                    <label for="CI">Carnet de Identidad (CI)</label>
                    <input type="number" name="CI" id="CI" required>
                </div>

                <div class="form-group">
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" required> 
                </div>

                <div class="form-group">
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" id="Apellido" required>
                </div>

                <div class="form-group">
                    <label for="Usuario">Nombre de Usuario</label>
                    <input type="text" name="Usuario" id="Usuario" required>
                </div>

                <div class="form-group">
                    <label for="Contrasena">Contraseña</label>
                    <input type="password" name="Contrasena" id="Contrasena" required>
                </div>

                <div class="form-group">
                    <label for="Direccion">Dirección</label>
                    <input type="text" name="Direccion" id="Direccion" required>
                </div>

                <div class="form-group">
                    <label for="Celular">Celular</label>
                    <input type="number" name="Celular" id="Celular">
                </div>

                <div class="form-group">
                    <label for="Rol">Rol</label>
                    <select name="Rol" id="Rol">
                        <option value="cliente" selected>cliente</option>
                        <option value="vendedor" selected>vendedor</option>
                        <option value="Administrador" selected>Administrador</option>
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador'): ?>
                            <option value="vendedor">vendedor</option>
                            <option value="Administrador">Administrador</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="Estado">Estado</label>
                    <select name="Estado" id="Estado">
                        <option value="Activo" selected>Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <input type="submit" value="Registrar Usuario">
                </div>
            </div>
        </form>
       <!-- Botón para retornar al Panel Admin si la sesión lo amerita -->
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Administrador'): ?>
            <a href="../princip/Administrador.php" class="links">← Volver al Panel Admin</a>
        <?php else: ?>
            <a href="../princip/iniciosesion.php" class="links">Volver a Iniciar Sesión</a>
        <?php endif; ?>
    </div>

    <!-- Incluimos el pie de página -->
    <?php include '../princip/footer.php'; ?>

    <!-- Script de validación JavaScript externo -->
    <script src="../js/validar_usuario.js"></script>
</body>
</html>
