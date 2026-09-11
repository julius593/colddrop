<?php
// ========================================================
// REPORTE: INGRESOS TOTALES
// POR DÍA, SEMANA, MES Y AÑO - COLDDROP
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
// OBTENER PERIODO
// ========================================================

$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : 'mes';


// ========================================================
// FECHAS
// ========================================================

$hoySql = date('Y-m-d');
$inicioSemana = date('Y-m-d', strtotime('monday this week'));
$finSemana = date('Y-m-d', strtotime('sunday this week'));
$mesActual = date('m');
$anoActual = date('Y');


// ========================================================
// CONSULTA SEGÚN EL PERIODO
// ========================================================

switch ($periodo) {
    case 'dia': $sql = "SELECT * FROM ventas WHERE DATE(Fecha) = '$hoySql' ORDER BY idVenta DESC"; $tituloPeriodo = "Ingresos del Día";
     break;
case 'semana': $sql = "SELECT * FROM ventas WHERE DATE(Fecha) BETWEEN '$inicioSemana' AND '$finSemana' ORDER BY idVenta DESC"; $tituloPeriodo = "Ingresos de la Semana";
    break;
case 'ano': $sql = "SELECT * FROM ventas WHERE YEAR(Fecha) = '$anoActual' ORDER BY idVenta DESC"; $tituloPeriodo = "Ingresos del Año";
    break;
case 'mes':
default: $sql = "SELECT * FROM ventas WHERE MONTH(Fecha) = '$mesActual' AND YEAR(Fecha) = '$anoActual' ORDER BY idVenta DESC"; $tituloPeriodo = "Ingresos del Mes";
    break;
}


// ========================================================
// EJECUTAR CONSULTA
// ========================================================

$resultado = $conn->query($sql);


// ========================================================
// VARIABLES
// ========================================================

$totalIngresos = 0;

$filas = [];


// Datos para gráfico
$labelsGrafico = [];
$montosGrafico = [];


// Datos para vendedor
$ventasVendedor = [];
$montosVendedor = [];


// ========================================================
// PROCESAR VENTAS
// ========================================================

if ($resultado && $resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        $filas[] = $row;

        $monto = (float)$row['MontoTotal'];

        // ---------------------------------------------
        // TOTAL DE INGRESOS
        // ---------------------------------------------

        $totalIngresos += $monto;


        // ---------------------------------------------
        // DATOS DEL GRÁFICO
        // ---------------------------------------------

        $fecha = $row['Fecha'];

        $labelsGrafico[] = $fecha;
        $montosGrafico[] = $monto;


        // ---------------------------------------------
        // INGRESOS POR VENDEDOR
        // ---------------------------------------------

        $vendedor = !empty($row['NombreVendedor'])
            ? $row['NombreVendedor']
            : 'Sin vendedor';

        if (!isset($ventasVendedor[$vendedor])) {
            $ventasVendedor[$vendedor] = 0;
        }

        $ventasVendedor[$vendedor] += $monto;
    }
}


// ========================================================
// CONVERTIR DATOS PHP → JAVASCRIPT
// ========================================================

$jsonLabels = json_encode($labelsGrafico);

$jsonMontos = json_encode($montosGrafico);

$jsonVendedores = json_encode(array_keys($ventasVendedor));

$jsonMontosVendedor = json_encode(array_values($ventasVendedor));

?>
<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ingresos Totales - ColdDrop</title>

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
        Reporte de Ingresos Totales
    </h2>


    <a href="menu_reportes.php"
       style="
            display:inline-block;
            margin-bottom:20px;
            color:#555;
       ">

        ← Volver al Menú de Reportes

    </a>


    <!-- ==================================================
         BOTONES DE FILTRO
         ================================================== -->

    <div style="
        margin-bottom:30px;
        text-align:center;
    ">


        <a href="ingresostotales.php?periodo=dia"
           style="
                display:inline-block;
                padding:10px 18px;
                background:#111;
                color:#fff;
                text-decoration:none;
                margin:5px;
                border-radius:6px;
           ">

            📅 Por Día

        </a>


        <a href="ingresostotales.php?periodo=semana"
           style="
                display:inline-block;
                padding:10px 18px;
                background:#111;
                color:#fff;
                text-decoration:none;
                margin:5px;
                border-radius:6px;
           ">

            📊 Por Semana

        </a>


        <a href="ingresostotales.php?periodo=mes"
           style="
                display:inline-block;
                padding:10px 18px;
                background:#111;
                color:#fff;
                text-decoration:none;
                margin:5px;
                border-radius:6px;
           ">

            📈 Por Mes

        </a>


        <a href="ingresostotales.php?periodo=ano"
           style="
                display:inline-block;
                padding:10px 18px;
                background:#111;
                color:#fff;
                text-decoration:none;
                margin:5px;
                border-radius:6px;
           ">

            📆 Por Año

        </a>

    </div>


    <!-- ==================================================
         RESUMEN
         ================================================== -->

    <div style="
        background:#fff;
        padding:25px;
        border-radius:12px;
        margin-bottom:30px;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);
        text-align:center;
    ">

        <h3 style="
            margin:0;
            color:#28a745;
        ">

            <?php echo $tituloPeriodo; ?>

        </h3>


        <p style="
            margin:10px 0;
            color:#666;
        ">

            Total de ventas:
            <strong><?php echo count($filas); ?></strong>

        </p>


        <h1 style="
            margin:10px 0 0;
            color:#28a745;
            font-size:36px;
        ">

            $<?php echo number_format($totalIngresos, 2); ?>

        </h1>

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
             GRÁFICO DE INGRESOS
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

                <?php echo $tituloPeriodo; ?>

            </h3>


            <div style="height:350px;">

                <canvas id="graficoIngresos"></canvas>

            </div>

        </div>


        <!-- ==================================================
             GRÁFICO VENDEDORES
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

                Ingresos por vendedor

            </h3>


            <div style="height:350px;">

                <canvas id="graficoVendedores"></canvas>

            </div>

        </div>

    </div>

    <?php endif; ?>


    <!-- ==================================================
         TABLA
         ================================================== -->

    <div class="table-responsive">

        <table>

            <thead>

                <tr>

                    <th># Venta</th>

                    <th>Fecha</th>

                    <th>Cliente</th>

                    <th>Vendedor</th>

                    <th>Monto Total ($)</th>

                </tr>

            </thead>


            <tbody>

            <?php

            if (count($filas) > 0) {

                foreach ($filas as $row) {

                    echo "<tr>";

                    echo "<td>"
                        . htmlspecialchars($row['idVenta'])
                        . "</td>";

                    echo "<td>"
                        . htmlspecialchars($row['Fecha'])
                        . "</td>";

                    echo "<td>"
                        . htmlspecialchars($row['Cliente'])
                        . "</td>";

                    echo "<td>"
                        . htmlspecialchars($row['NombreVendedor'])
                        . "</td>";

                    echo "<td>$"
                        . number_format(
                            (float)$row['MontoTotal'],
                            2
                        )
                        . "</td>";

                    echo "</tr>";
                }

            } else {

                echo "
                <tr>

                    <td colspan='5'
                        style='
                            text-align:center;
                            padding:20px;
                        '>

                        No se encontraron ventas para este periodo.

                    </td>

                </tr>";

            }

            ?>

            </tbody>

        </table>

    </div>



    <!-- ==================================================
         TOTAL
         ================================================== -->

    <h3 style="
        margin-top:20px;
        text-align:right;
        color:#28a745;
    ">

        Total Ingresos en Filtro:

        $<?php echo number_format($totalIngresos, 2); ?>

    </h3>


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

    const labels =
        <?php echo $jsonLabels; ?>;

    const montos =
        <?php echo $jsonMontos; ?>;

    const vendedores =
        <?php echo $jsonVendedores; ?>;

    const montosVendedor =
        <?php echo $jsonMontosVendedor; ?>;


    // ====================================================
    // SWEETALERT SI NO HAY VENTAS
    // ====================================================

    <?php if (count($filas) == 0): ?>

        Swal.fire({

            icon: 'info',

            title: 'Sin ventas',

            text: 'No se encontraron ventas para este periodo.',

            confirmButtonText: 'Aceptar',

            confirmButtonColor: '#28a745'

        });

    <?php endif; ?>


    // ====================================================
    // CREAR GRÁFICOS
    // ====================================================

    <?php if (count($filas) > 0): ?>


    // ====================================================
    // GRÁFICO DE INGRESOS
    // ====================================================

    const ctxIngresos =
        document.getElementById('graficoIngresos');


    new Chart(ctxIngresos, {

        type: 'bar',

        data: {

            labels: labels,

            datasets: [{

                label: 'Ingresos ($)',

                data: montos,

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text:
                        '<?php echo $tituloPeriodo; ?>'

                },

                legend: {

                    display: true

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' $' +
                                context.parsed.y
                                .toFixed(2);

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    title: {

                        display: true,

                        text: 'Ingresos ($)'

                    }

                },

                x: {

                    title: {

                        display: true,

                        text: 'Ventas'

                    }

                }

            }

        }

    });


    // ====================================================
    // GRÁFICO DE VENDEDORES
    // ====================================================

    const ctxVendedores =
        document.getElementById('graficoVendedores');


    new Chart(ctxVendedores, {

        type: 'doughnut',

        data: {

            labels: vendedores,

            datasets: [{

                data: montosVendedor,

                borderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text: 'Distribución de ingresos'

                },

                legend: {

                    position: 'bottom'

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' ' +
                                context.label +
                                ': $' +
                                context.parsed
                                .toFixed(2);

                        }

                    }

                }

            }

        }

    });


    // ====================================================
    // SWEETALERT DEL REPORTE
    // ====================================================

    setTimeout(function() {

        Swal.fire({

            icon: 'success',

            title: 'Reporte generado',

            html:

                'Periodo: <b>' +
                '<?php echo $tituloPeriodo; ?>' +
                '</b><br><br>' +

                'Ventas encontradas: <b>' +
                '<?php echo count($filas); ?>' +
                '</b><br><br>' +

                'Total de ingresos:<br>' +

                '<strong style="\
                    font-size:25px;\
                    color:#28a745;\
                ">' +

                '$<?php echo number_format($totalIngresos, 2); ?>' +

                '</strong>',

            confirmButtonText: 'Ver reporte',

            confirmButtonColor: '#28a745'

        });

    }, 500);


    <?php endif; ?>


});

</script>


</body>

</html>