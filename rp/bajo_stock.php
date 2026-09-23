<?php
// ========================================================
// REPORTE: PRODUCTOS CON BAJO STOCK - COLDDROP
// ========================================================

include_once '../conexion.php';


// ========================================================
// INICIAR SESIÓN
// ========================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ========================================================
// VALIDAR ACCESO
// ========================================================

if (
    !isset($_SESSION['rol']) ||
    ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')
) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}


// ========================================================
// CONSULTAR PRODUCTOS CON STOCK <= 5
// ========================================================

$sql = "SELECT * 
        FROM productos 
        WHERE CAST(Stock AS UNSIGNED) <= 5 
        ORDER BY CAST(Stock AS UNSIGNED) ASC";

$resultado = $conn->query($sql);


// ========================================================
// VARIABLES PARA EL REPORTE
// ========================================================

$filas = [];

$totalBajoStock = 0;
$totalAgotados = 0;
$totalCriticos = 0;
$totalBajos = 0;


// ========================================================
// DATOS PARA EL GRÁFICO
// ========================================================

$labelsProductos = [];
$stockProductos = [];


// ========================================================
// PROCESAR RESULTADOS
// ========================================================

if ($resultado && $resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        $filas[] = $row;

        $stock = (int)$row['Stock'];

        // ---------------------------------------------
        // CONTAR PRODUCTOS
        // ---------------------------------------------

        $totalBajoStock++;


        if ($stock == 0) {

            $totalAgotados++;

        } elseif ($stock <= 2) {

            $totalCriticos++;

        } else {

            $totalBajos++;

        }


        // ---------------------------------------------
        // DATOS PARA GRÁFICO
        // ---------------------------------------------

        $labelsProductos[] = $row['Nombre'];

        $stockProductos[] = $stock;
    }
}


// ========================================================
// CONVERTIR PHP → JSON
// ========================================================

$jsonLabelsProductos = json_encode($labelsProductos);

$jsonStockProductos = json_encode($stockProductos);

?>
<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Productos con Bajo Stock - ColdDrop</title>


    <link rel="stylesheet" href="../css/tablas.css">


    <!-- ==================================================
         SWEETALERT2
         ================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- ==================================================
         CHART.JS
         ================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body>

<?php include '../princip/header.php'; ?>


<div class="admin-container"
     style="
        max-width:1100px;
        margin:40px auto;
        padding:0 20px;
     ">


    <!-- ==================================================
         TÍTULO
         ================================================== -->

    <h2>
        Reporte: Productos con Bajo Stock
        (≤ 5 Unidades)
    </h2>


    <!-- ==================================================
         BOTÓN VOLVER
         ================================================== -->

    <a href="menu_reportes.php"
       style="
            display:inline-block;
            margin-bottom:20px;
            color:#555;
       ">

        ← Volver al Menú de Reportes

    </a>


    <!-- ==================================================
         NOTIFICACIÓN
         ================================================== -->

    <div style="
        background:#fff3cd;
        border-left:5px solid #ffc107;
        padding:15px;
        margin-bottom:25px;
        border-radius:6px;
    ">

        <strong>
            ⚠️ Notificación de Reposición Sugerida
        </strong>

        <p style="margin:8px 0 0;">

            Los siguientes productos tienen un stock bajo.
            Se recomienda realizar la reposición del inventario.

        </p>

    </div>


    <!-- ==================================================
         RESUMEN DEL STOCK
         ================================================== -->

    <div style="
        display:flex;
        flex-wrap:wrap;
        gap:20px;
        margin-bottom:30px;
    ">


        <!-- TOTAL -->

        <div style="
            flex:1;
            min-width:200px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="margin:0;">
                Productos con bajo stock
            </h3>

            <h1 style="
                color:#dc3545;
                margin:10px 0 0;
            ">

                <?php echo $totalBajoStock; ?>

            </h1>

        </div>


        <!-- AGOTADOS -->

        <div style="
            flex:1;
            min-width:200px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="margin:0;">
                Productos agotados
            </h3>

            <h1 style="
                color:#dc3545;
                margin:10px 0 0;
            ">

                <?php echo $totalAgotados; ?>

            </h1>

        </div>


        <!-- CRÍTICOS -->

        <div style="
            flex:1;
            min-width:200px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="margin:0;">
                Stock crítico
            </h3>

            <h1 style="
                color:#fd7e14;
                margin:10px 0 0;
            ">

                <?php echo $totalCriticos; ?>

            </h1>

        </div>


        <!-- BAJO -->

        <div style="
            flex:1;
            min-width:200px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="margin:0;">
                Stock bajo
            </h3>

            <h1 style="
                color:#ffc107;
                margin:10px 0 0;
            ">

                <?php echo $totalBajos; ?>

            </h1>

        </div>

    </div>


    <!-- ==================================================
         GRÁFICOS
         ================================================== -->

    <?php if (count($filas) > 0): ?>

    <div style="
        display:flex;
        flex-wrap:wrap;
        gap:30px;
        margin-bottom:35px;
    ">


        <!-- ==================================================
             GRÁFICO DE STOCK POR PRODUCTO
             ================================================== -->

        <div style="
            flex:2;
            min-width:350px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="text-align:center;">

                Stock actual por producto

            </h3>


            <div style="height:400px;">

                <canvas id="graficoStock"></canvas>

            </div>

        </div>


        <!-- ==================================================
             GRÁFICO DE ESTADO DEL STOCK
             ================================================== -->

        <div style="
            flex:1;
            min-width:300px;
            background:#fff;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="text-align:center;">

                Estado del inventario

            </h3>


            <div style="height:350px;">

                <canvas id="graficoEstado"></canvas>

            </div>

        </div>

    </div>

    <?php endif; ?>


    <!-- ==================================================
         TABLA DE PRODUCTOS
         ================================================== -->

    <div class="table-responsive">

        <table>

            <thead>

                <tr>

                    <th>Código</th>

                    <th>Nombre</th>

                    <th>Tipo</th>

                    <th>Talla</th>

                    <th>Color</th>

                    <th>Stock Actual</th>

                    <th>Estado / Sugerencia</th>

                </tr>

            </thead>


            <tbody>

            <?php

            if (count($filas) > 0) {

                foreach ($filas as $row) {

                    $st = (int)$row['Stock'];


                    // -------------------------------------
                    // DETERMINAR ESTADO
                    // -------------------------------------

                    if ($st == 0) {

                        $estado = "❌ AGOTADO";

                        $colorEstado = "#dc3545";

                    } elseif ($st <= 2) {

                        $estado = "⚠️ STOCK CRÍTICO";

                        $colorEstado = "#fd7e14";

                    } else {

                        $estado = "⚠️ STOCK BAJO";

                        $colorEstado = "#ffc107";

                    }


                    echo "<tr style='background-color:#fff5f5;'>";


                    echo "<td>"
                        . htmlspecialchars($row['Codigo'])
                        . "</td>";


                    echo "<td>"
                        . htmlspecialchars($row['Nombre'])
                        . "</td>";


                    echo "<td>"
                        . htmlspecialchars($row['Tipo'])
                        . "</td>";


                    echo "<td>"
                        . htmlspecialchars($row['Talla'])
                        . "</td>";


                    echo "<td>"
                        . htmlspecialchars($row['Color'])
                        . "</td>";


                    echo "<td style='
                            color:$colorEstado;
                            font-weight:bold;
                         '>"
                        . $st
                        . " unidades
                        </td>";


                    echo "<td style='
                            color:$colorEstado;
                            font-weight:bold;
                         '>"
                        . $estado
                        . "<br>
                           <small>
                           Se sugiere reponer
                           </small>
                        </td>";


                    echo "</tr>";
                }


            } else {

                echo "
                <tr>

                    <td colspan='7'
                        style='
                            text-align:center;
                            padding:20px;
                        '>

                        ✅ No hay productos con bajo stock.

                    </td>

                </tr>";

            }

            ?>

            </tbody>

        </table>

    </div>


</div>


<?php include '../princip/footer.php'; ?>


<!-- ========================================================
     JAVASCRIPT
     ======================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    // ====================================================
    // DATOS DE PHP
    // ====================================================

    const labelsProductos =
        <?php echo $jsonLabelsProductos; ?>;

    const stockProductos =
        <?php echo $jsonStockProductos; ?>;


    // ====================================================
    // SWEETALERT
    // ====================================================

    <?php if ($totalBajoStock > 0): ?>

        setTimeout(function() {

            Swal.fire({

                icon: 'warning',

                title: '¡Atención!',

                html:

                    'Hay <b>' +
                    <?php echo $totalBajoStock; ?> +
                    '</b> producto(s) con bajo stock.<br><br>' +

                    'Agotados: <b>' +
                    <?php echo $totalAgotados; ?> +
                    '</b><br>' +

                    'Stock crítico: <b>' +
                    <?php echo $totalCriticos; ?> +
                    '</b><br>' +

                    'Stock bajo: <b>' +
                    <?php echo $totalBajos; ?> +
                    '</b>',

                confirmButtonText: 'Revisar productos',

                confirmButtonColor: '#ffc107'

            });

        }, 500);


    <?php else: ?>

        Swal.fire({

            icon: 'success',

            title: 'Inventario correcto',

            text: 'No hay productos con bajo stock.',

            confirmButtonText: 'Aceptar',

            confirmButtonColor: '#28a745'

        });

    <?php endif; ?>


    // ====================================================
    // GRÁFICO DE STOCK POR PRODUCTO
    // ====================================================

    <?php if (count($filas) > 0): ?>

    const ctxStock =
        document.getElementById('graficoStock');


    new Chart(ctxStock, {

        type: 'bar',

        data: {

            labels: labelsProductos,

            datasets: [{

                label: 'Stock actual',

                data: stockProductos,

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text: 'Cantidad disponible por producto'

                },

                legend: {

                    display: false

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' ' +
                                context.parsed.y +
                                ' unidades';

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        stepSize: 1

                    },

                    title: {

                        display: true,

                        text: 'Unidades disponibles'

                    }

                },

                x: {

                    title: {

                        display: true,

                        text: 'Producto'

                    }

                }

            }

        }

    });


    // ====================================================
    // GRÁFICO DE ESTADO DEL STOCK
    // ====================================================

    const ctxEstado =
        document.getElementById('graficoEstado');


    new Chart(ctxEstado, {

        type: 'doughnut',

        data: {

            labels: [

                'Agotados',

                'Stock crítico',

                'Stock bajo'

            ],

            datasets: [{

                data: [

                    <?php echo $totalAgotados; ?>,

                    <?php echo $totalCriticos; ?>,

                    <?php echo $totalBajos; ?>

                ],

                borderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text: 'Clasificación del bajo stock'

                },

                legend: {

                    position: 'bottom'

                }

            }

        }

    });

    <?php endif; ?>

});

</script>


</body>

</html>