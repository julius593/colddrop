<?php
// ========================================================
// LISTA DE FORMULARIOS MEDIOAMBIENTALES - COLDDROP
// ========================================================

include_once '../conexion.php';


// ========================================================
// INICIAR SESIÓN
// ========================================================

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ========================================================
// SEGURIDAD
// SOLO EL ADMINISTRADOR PUEDE ACCEDER
// ========================================================

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {

    header('Location: ../princip/iniciosesion.php');
    exit();

}


// ========================================================
// CONSULTAR FORMULARIOS MEDIOAMBIENTALES
// ========================================================

$sql = "SELECT * FROM medioambiental ORDER BY Fecha DESC";

$resultado = $conexion->query($sql);


// Verificar si hubo error en la consulta

if (!$resultado) {

    die("Error al consultar los formularios: " . $conexion->error);

}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Formularios Medioambientales - ColdDrop
    </title>


    <!-- Google Fonts -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
          rel="stylesheet">


    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!-- CSS -->

    <link rel="stylesheet"
          href="../css/tablas.css">

</head>


<body>


<?php include '../princip/header.php'; ?>


<div class="admin-container">


    <!-- ==================================================
         ENCABEZADO
         ================================================== -->

    <div class="admin-header-flex">

        <h1>

            <i class="fa-solid fa-leaf"></i>

            Formularios Medioambientales

        </h1>


        <div>

            <a href="../princip/Administrador.php"
               class="btn-volver">

                ← Volver al Panel Admin

            </a>


            <a href="formulario.php"
               class="btn-crear">

                + Nuevo Formulario

            </a>

        </div>

    </div>


    <!-- ==================================================
         TABLA
         ================================================== -->

    <div class="table-responsive">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Nombre</th>

                    <th>Apellido</th>

                    <th>Tipo de Aporte</th>

                    <th>Importancia</th>

                    <th>Comentario</th>

                    <th>Propuesta</th>

                    <th>Fecha</th>

                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>


            <?php

            if ($resultado->num_rows > 0) {


                while ($fila = $resultado->fetch_assoc()) {


                    // ==================================================
                    // PROTEGER LOS DATOS
                    // ==================================================

                    $id = htmlspecialchars($fila['id']);

                    $nombre = htmlspecialchars($fila['Nombre']);

                    $apellido = htmlspecialchars($fila['Apellido']);

                    $tipo = htmlspecialchars($fila['Tipo']);

                    $importancia = htmlspecialchars($fila['Importancia']);

                    $comentario = htmlspecialchars($fila['Comentario']);

                    $propuesta = htmlspecialchars($fila['Propuesta']);

                    $fecha = htmlspecialchars($fila['Fecha']);


                    // ==================================================
                    // MOSTRAR FILA
                    // ==================================================

                    echo "<tr>";


                    echo "<td>$id</td>";

                    echo "<td>$nombre</td>";

                    echo "<td>$apellido</td>";

                    echo "<td>$tipo</td>";


                    // ==================================================
                    // IMPORTANCIA CON COLOR
                    // ==================================================

                    if ($importancia === 'Alta') {

                        echo "<td>
                                <span class='estado-alto'>
                                    $importancia
                                </span>
                              </td>";

                    } elseif ($importancia === 'Media') {

                        echo "<td>
                                <span class='estado-medio'>
                                    $importancia
                                </span>
                              </td>";

                    } else {

                        echo "<td>
                                <span class='estado-bajo'>
                                    $importancia
                                </span>
                              </td>";

                    }


                    echo "<td>$comentario</td>";

                    echo "<td>$propuesta</td>";

                    echo "<td>$fecha</td>";


                    // ==================================================
                    // ACCIONES
                    // ==================================================

                    echo "<td style='text-align:center;'>";


                    echo "<a href='detalle_medioambiental.php?id=$id'
                              class='btn-action btn-mostrar'>

                            <i class='fa-solid fa-eye'></i>
                            Ver

                          </a>";


                    echo "<a href='eliminar_medioambiental.php?id=$id'
                              class='btn-action btn-eliminar'
                              onclick=\"return confirm('¿Estás seguro de eliminar este formulario?');\">

                            <i class='fa-solid fa-trash'></i>
                            Eliminar

                          </a>";


                    echo "</td>";


                    echo "</tr>";

                }


            } else {


                echo "<tr>";

                echo "<td colspan='9'
                        style='text-align:center; padding:30px;'>";

                echo "<i class='fa-solid fa-leaf'></i>
                      No existen formularios medioambientales registrados.";

                echo "</td>";

                echo "</tr>";

            }


            ?>


            </tbody>

        </table>

    </div>


</div>


<?php include '../princip/footer.php'; ?>


<?php

// ========================================================
// CERRAR CONEXIÓN
// ========================================================

$conexion->close();

?>


</body>

</html>

