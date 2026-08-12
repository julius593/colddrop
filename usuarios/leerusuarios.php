</head>
<body>
    <h3>El valor de la variable es: <?php echo $cd; ?></h3>
    <?php
        echo "<h2> El valor de esta etiqueta es: ".$cd."</h2>";
    ?>
    <table>
        <tr>
            <td>Nombre_y_Apellido</td>
            <td>Direccion</td>
            <td>Celular</td>
            <td>Rol</td>
            <td>Estado</td>
            <td>CI</td>
            
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - ColdDrop</title>
    
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
            <h1><i class="fa-solid fa-users"></i> Lista de Usuarios</h1>
            <div>
                <a href="../princip/Administrador.php" class="btn-volver">← Volver al Panel Admin</a>
                <a href="crearusuarios.php" class="btn-crear">+ Registrar Usuario</a>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Dirección</th>
                        <th>Celular</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($fila = $resultado->fetch_assoc()) {
                            $CI = htmlspecialchars($fila['CI']);
                            $nombre = isset($fila['Nombre']) ? htmlspecialchars($fila['Nombre']) : '';
                            $apellido = isset($fila['Apellido']) ? htmlspecialchars($fila['Apellido']) : '';
                            $usuario = isset($fila['Usuario']) ? htmlspecialchars($fila['Usuario']) : '';
                            $direccion = isset($fila['Direccion']) ? htmlspecialchars($fila['Direccion']) : '';
                            $celular = isset($fila['Celular']) ? htmlspecialchars($fila['Celular']) : '';
                            $rol = isset($fila['Rol']) ? htmlspecialchars($fila['Rol']) : '';
                            $estado = isset($fila['Estado']) ? htmlspecialchars($fila['Estado']) : '';

                            echo "<tr>";
                                echo "<td>$CI</td>";
                                echo "<td>$nombre</td>";
                                echo "<td>$apellido</td>";
                                echo "<td>$usuario</td>";
                                echo "<td>$direccion</td>";
                                echo "<td>$celular</td>";
                                echo "<td><span style='font-weight:600;'>$rol</span></td>";
                                echo "<td>$estado</td>";
                                echo "<td style='text-align: center;'>";
                                    echo "<a href='actualizarusuarios.php?CI=$CI' class='btn-action btn-editar'>Editar</a>";
                                    if ($estado === 'Bloqueado') {
                                        echo "<a href='bloquear_usuario.php?CI=$CI' class='btn-action btn-mostrar' style='background-color:#28a745;'>Desbloquear</a>";
                                    } else {
                                        echo "<a href='bloquear_usuario.php?CI=$CI' class='btn-action btn-eliminar' style='background-color:#fd7e14;'>Bloquear</a>";
                                    }
                                    echo "<a href='elimusuarios.php?CI=$CI' class='btn-action btn-eliminar' onclick='return confirm(\"¿Estás seguro de eliminar este usuario?\");'>Eliminar</a>";
                                    echo "<a href='casaleerusuarios.php?CI=$CI' class='btn-action btn-mostrar'>Detalles</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align:center;'>No hay usuarios registrados.</td></tr>";
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
