<?php
// ========================================================
// LISTA DE FORMULARIOS MEDIOAMBIENTALES - COLDROP
// ========================================================

include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// ========================================================
// VERIFICAR QUE SEA ADMINISTRADOR
// ========================================================

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header('Location: ../princip/iniciosesion.php');
    exit();
}

// ========================================================
// OBTENER FORMULARIOS MEDIOAMBIENTALES
// ========================================================

$sql = "SELECT *
        FROM medioambiental
        ORDER BY id_medioambiental DESC";

$resultado = $conexion->query($sql);

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

    <!-- FUENTES -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
          rel="stylesheet">

    <!-- ICONOS -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- CSS -->

    <link rel="stylesheet"
          href="../css/tablas.css">

</head>

<body>


<!-- =====================================================
     HEADER
===================================================== -->

<?php include '../princip/header.php'; ?>


<!-- =====================================================
     CONTENEDOR PRINCIPAL
===================================================== -->

<div class="admin-container">


    <!-- =================================================
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

        </div>

    </div>


    <!-- =================================================
         TABLA
    ================================================== -->

    <div class="table-responsive">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Nombre</th>

                    <th>Apellido</th>

                    <th>Tipo de aporte</th>

                    <th>Importancia</th>

                    <th>Comentario</th>

                    <th>Propuesta</th>

                    <th>Fecha</th>

                    <th style="text-align:center;">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

            <?php

            // =================================================
            // COMPROBAR RESULTADOS
            // =================================================

            if ($resultado && $resultado->num_rows > 0) {

                while ($fila = $resultado->fetch_assoc()) {


                    // =============================================
                    // PROTEGER INFORMACIÓN
                    // =============================================

                    $id = htmlspecialchars(
                        $fila['id_medioambiental']
                    );

                    $nombre = htmlspecialchars(
                        $fila['Nombre'] ?? ''
                    );

                    $apellido = htmlspecialchars(
                        $fila['Apellido'] ?? ''
                    );

                    $tipo = htmlspecialchars(
                        $fila['Tipo'] ?? ''
                    );

                    $importancia = htmlspecialchars(
                        $fila['Importancia'] ?? ''
                    );

                    $comentario = htmlspecialchars(
                        $fila['Comentario'] ?? ''
                    );

                    $propuesta = htmlspecialchars(
                        $fila['Propuesta'] ?? ''
                    );

                    $fecha = htmlspecialchars(
                        $fila['Fecha'] ?? ''
                    );


                    // =============================================
                    // MOSTRAR FILA
                    // =============================================

                    echo "<tr>";


                    // ID

                    echo "<td>
                            $id
                          </td>";


                    // NOMBRE

                    echo "<td>
                            $nombre
                          </td>";


                    // APELLIDO

                    echo "<td>
                            $apellido
                          </td>";


                    // TIPO

                    echo "<td>
                            $tipo
                          </td>";


                    // IMPORTANCIA

                    echo "<td>";

                    if ($importancia === 'Alta') {

                        echo "<span style='
                            color:#dc3545;
                            font-weight:600;
                        '>
                            🔴 Alta
                        </span>";

                    } elseif ($importancia === 'Media') {

                        echo "<span style='
                            color:#fd7e14;
                            font-weight:600;
                        '>
                            🟠 Media
                        </span>";

                    } else {

                        echo "<span style='
                            color:#28a745;
                            font-weight:600;
                        '>
                            🟢 Baja
                        </span>";

                    }

                    echo "</td>";


                    // COMENTARIO

                    echo "<td style='max-width:250px;'>";

                    echo nl2br(
                        $comentario
                    );

                    echo "</td>";


                    // PROPUESTA

                    echo "<td style='max-width:250px;'>";

                    if ($propuesta !== '') {

                        echo nl2br(
                            $propuesta
                        );

                    } else {

                        echo "<span style='color:#888;'>
                                Sin propuesta
                              </span>";

                    }

                    echo "</td>";


                    // FECHA

                    echo "<td>
                            $fecha
                          </td>";


                    // =============================================
                    // ACCIONES
                    // =============================================

                    echo "<td style='text-align:center;'>";


                    // EDITAR

                    echo "
                    <a
                        href='actualizar_medioambiental.php?id_medioambiental=$id'
                        class='btn-action btn-editar'
                    >
                        ✏️ Editar
                    </a>
                    ";


                    // ELIMINAR

                    echo "
                    <a
                        href='eliminar_medioambiental.php?id_medioambiental=$id'
                        class='btn-action btn-eliminar'
                        onclick='
                            return confirm(
                                \"¿Estás seguro de eliminar este formulario?\"
                            );
                        '
                    >
                        🗑️ Eliminar
                    </a>
                    ";


                    // DETALLES

                    echo "
                    <a
                        href='casaleer_medioambiental.php?id_medioambiental=$id'
                        class='btn-action btn-mostrar'
                    >
                        👁️ Detalles
                    </a>
                    ";


                    echo "</td>";


                    echo "</tr>";

                }

            } else {

                echo "
                <tr>

                    <td
                        colspan='9'
                        style='text-align:center;'
                    >

                        🌱 No hay formularios
                        medioambientales registrados.

                    </td>

                </tr>
                ";

            }


            // =================================================
            // CERRAR CONEXIÓN
            // =================================================

            $conexion->close();

            ?>

            </tbody>

        </table>

    </div>

</div>


<!-- =====================================================
     FOOTER
===================================================== -->

<?php include '../princip/footer.php'; ?>


</body>

</html>
