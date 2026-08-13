<?php
// ========================================================
// HISTORIAL DE PEDIDOS Y VENTAS - COLDDROP
// ========================================================

session_start();


// ========================================================
// COMPROBAR QUE EL USUARIO SEA ADMINISTRADOR
// ========================================================

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: iniciosesion.php");
    exit();
}


// ========================================================
// CONEXIÓN A LA BASE DE DATOS
// ========================================================

include_once "../conexion.php";


// ========================================================
// CONSULTA DE PEDIDOS
// ========================================================

// Unimos:
// pedidos + carrito + productos
//
// pedidos  -> información del pedido
// carrito  -> cantidad y costo total
// productos -> stock del producto

$sql = "
SELECT
    p.idPEDIDOS AS pedido,
    p.Estado AS estado,
    p.Metodo AS metodo,
    COALESCE(SUM(c.costoTotal), 0) AS costoTotal,
    COALESCE(SUM(pr.Stock), 0) AS stock

FROM pedidos p

LEFT JOIN carrito c
    ON p.idPEDIDOS = c.PEDIDOS_idPEDIDOS

LEFT JOIN productos pr
    ON c.PRODUCTOS_Codigo = pr.Codigo

GROUP BY
    p.idPEDIDOS,
    p.Estado,
    p.Metodo

ORDER BY
    p.idPEDIDOS DESC
";

$resultado = $conexion->query($sql);


// ========================================================
// COMPROBAR ERROR EN LA CONSULTA
// ========================================================

if (!$resultado) {

    die(
        "Error en la consulta: "
        . htmlspecialchars($conexion->error)
    );

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Historial de Ventas - ColdDrop</title>


    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >


    <style>

        * {
            box-sizing: border-box;
        }

        body {

            margin: 0;

            padding: 0;

            font-family: 'Poppins', sans-serif;

            background: #f5f5f5;

            color: #222;
        }


        .contenedor {

            width: 95%;

            max-width: 1200px;

            margin: 40px auto;

            background: white;

            padding: 30px;

            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0,0,0,0.10);
        }


        h1 {

            text-align: center;

            margin-bottom: 30px;

            font-size: 28px;
        }


        .tabla-contenedor {

            width: 100%;

            overflow-x: auto;
        }


        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 700px;
        }


        thead {

            background: #111;

            color: white;
        }


        th {

            padding: 15px;

            text-align: center;

            font-weight: 600;
        }


        td {

            padding: 13px;

            text-align: center;

            border-bottom: 1px solid #ddd;
        }


        tbody tr:hover {

            background: #f5f5f5;
        }


        .estado {

            display: inline-block;

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: 600;
        }


        .en-proceso {

            background: #fff3cd;

            color: #856404;
        }


        .completado {

            background: #d4edda;

            color: #155724;
        }


        .cancelado {

            background: #f8d7da;

            color: #721c24;
        }


        .sin-estado {

            background: #e2e3e5;

            color: #383d41;
        }


        .botones {

            margin-top: 25px;

            display: flex;

            justify-content: center;

            gap: 15px;

            flex-wrap: wrap;
        }


        .boton {

            display: inline-block;

            padding: 12px 20px;

            border-radius: 8px;

            text-decoration: none;

            background: #111;

            color: white;

            transition: 0.3s;
        }


        .boton:hover {

            opacity: 0.8;
        }


        .mensaje {

            text-align: center;

            padding: 30px;

            color: #666;
        }

    </style>

</head>


<body>


<?php

// Cabecera del administrador

if (file_exists("header.php")) {

    include "header.php";

}

?>


<div class="contenedor">

    <h1>

        <i class="fa-solid fa-receipt"></i>

        Historial de Ventas

    </h1>


    <div class="tabla-contenedor">

        <table>

            <thead>

                <tr>

                    <th>Pedido</th>

                    <th>Costo Total</th>

                    <th>Estado</th>

                    <th>Método</th>

                    <th>Stock</th>

                </tr>

            </thead>


            <tbody>

            <?php

            // ========================================================
            // MOSTRAR LOS RESULTADOS
            // ========================================================

            if ($resultado->num_rows > 0) {

                while ($fila = $resultado->fetch_assoc()) {

                    // Datos

                    $pedido = $fila['pedido'];

                    $costoTotal = $fila['costoTotal'];

                    $estado = $fila['estado'];

                    $metodo = $fila['metodo'];

                    $stock = $fila['stock'];


                    // ====================================================
                    // CLASE PARA EL ESTADO
                    // ====================================================

                    $claseEstado = "sin-estado";


                    if ($estado === "En Proceso") {

                        $claseEstado = "en-proceso";

                    } elseif ($estado === "Completado") {

                        $claseEstado = "completado";

                    } elseif ($estado === "Cancelado") {

                        $claseEstado = "cancelado";

                    }

                    ?>

                    <tr>

                        <!-- PEDIDO -->

                        <td>

                            <strong>

                                #<?php
                                echo htmlspecialchars($pedido);
                                ?>

                            </strong>

                        </td>


                        <!-- COSTO TOTAL -->

                        <td>

                            $<?php

                            echo number_format(
                                (float)$costoTotal,
                                2
                            );

                            ?>

                        </td>


                        <!-- ESTADO -->

                        <td>

                            <span
                                class="estado <?php
                                echo $claseEstado;
                                ?>"
                            >

                                <?php

                                echo htmlspecialchars(
                                    $estado ?: "Sin estado"
                                );

                                ?>

                            </span>

                        </td>


                        <!-- MÉTODO -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $metodo ?: "No especificado"
                            );

                            ?>

                        </td>


                        <!-- STOCK -->

                        <td>

                            <?php

                            echo htmlspecialchars(
                                $stock
                            );

                            ?>

                        </td>

                    </tr>

                    <?php

                }

            } else {

                ?>

                <tr>

                    <td
                        colspan="5"
                        class="mensaje"
                    >

                        <i class="fa-solid fa-box-open"></i>

                        No existen pedidos registrados.

                    </td>

                </tr>

                <?php

            }

            ?>

            </tbody>

        </table>

    </div>


    <!-- BOTONES -->

    <div class="botones">

        <a
            href="Administrador.php"
            class="boton"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver al Administrador

        </a>


        <a
            href="frompedido.php"
            class="boton"
        >

            <i class="fa-solid fa-plus"></i>

            Nuevo Pedido

        </a>

    </div>

</div>


<?php

// Footer

if (file_exists("footer.php")) {

    include "footer.php";

}

?>


</body>

</html>