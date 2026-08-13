<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ColdDrop</title>
    
    <!-- Carga de fuentes de Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Hoja de estilos externa para inicio de sesión -->
    <link rel="stylesheet" href="../css/iniciosesion.css">
</head>
<body>
    <div class="form-container">
        <!-- Formulario que envía los datos a bdvali.php mediante POST -->
        <form action="bdvali.php" method="post">
            <h2>INICIAR SESIÓN</h2>
            
            <label for="Usuario">Usuario</label>
            <input type="text" name="Usuario" id="Usuario" required placeholder="Tu nombre de usuario">

            <label for="Contrasena">Contraseña</label>
            <input type="password" name="Contrasena" id="Contrasena" required placeholder="Tu contraseña"> 

            <input type="submit" value="Ingresar">
        </form>

        <!-- Botones de navegación adicional -->
        <a href="../usuarios/crearusuarios.php" class="links">Registrar Nuevo Usuario</a>
        <a href="inicio.php" class="links">← Volver al Inicio</a>
        
    </div>
</body>
</html>