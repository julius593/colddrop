<?php
// ========================================================
// REPORTE: VENTAS TOTALES DEL DÍA - COLDDROP
// ========================================================

include_once '../conexion.php';

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
// FECHA ACTUAL
// ========================================================

$hoy = date('d/m/Y');
$hoySql = date('Y-m-d');

// ========================================================
// CONSULTAR VENTAS DEL DÍA
// ========================================================

$sql = "SELECT * 
        FROM ventas 
        WHERE Fecha LIKE '%$hoy%' 
           OR Fecha LIKE '%$hoySql%' 
        ORDER BY idVenta DESC";

$resultado = $conn->query($sql);

// ========================================================
// VARIABLES PARA EL REPORTE
// ========================================================

$totalMonto = 0;

$labelsVentas = [];
$montosVentas = [];

$porVendedor = [];

$filas = [];

// ========================================================
// PROCESAR RESULTADOS
// ========================================================

if ($resultado && $resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        $filas[] = $row;

        // Monto de la venta
        $monto = (float) $row['MontoTotal'];

        // Total general
        $totalMonto += $monto;

        // Datos para gráfico de ventas
        $labelsVentas[] = 'Venta #' . $row['idVenta'];
        $montosVentas[] = $monto;

        // ====================================================
        // ACUMULAR POR VENDEDOR
        // ====================================================

        $vendedor = !empty($row['NombreVendedor'])
            ? $row['NombreVendedor']
            : 'Sin vendedor';

        if (!isset($porVendedor[$vendedor])) {
            $porVendedor[$vendedor] = 0;
        }

        $porVendedor[$vendedor] += $monto;
    }
}

// ========================================================
// CONVERTIR DATOS PHP A JSON PARA JAVASCRIPT
// ========================================================

$jsonLabelsVentas = json_encode($labelsVentas);
$jsonMontosVentas = json_encode($montosVentas);

$jsonVendedores = json_encode(array_keys($porVendedor));
$jsonMontosVendedores = json_encode(array_values($porVendedor));

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ventas Totales del Día - ColdDrop</title>

    <link rel="stylesheet" href="../css/tablas.css">

    <!-- ==================================================
         SWEETALERT2
         ================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ==================================================
         CHART.JS
         NECESARIO PARA LOS GRÁFICOS
         ================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<?php include '../princip/header.php'; ?>


<div class="admin-container"
     style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">

    <!-- ==================================================
         TÍTULO
         ================================================== -->

    <h2>
        Reporte: Ventas Totales del Día
        (<?php echo $hoy; ?>)
    </h2>


    <!-- ==================================================
         BOTÓN VOLVER
         ================================================== -->

    <a href="menu_reportes.php"
       class="btn-volver"
       style="
            display:inline-block;
            margin-bottom:20px;
            padding:8px 15px;
            background:#6c757d;
            color:#fff;
            text-decoration:none;
            border-radius:4px;
       ">

        ← Volver al Menú de Reportes

    </a>


    <!-- ==================================================
         RESUMEN DEL TOTAL
         ================================================== -->

    <div style="
        background:#fff;
        padding:20px;
        border-radius:12px;
        margin-bottom:30px;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);
        text-align:center;
    ">

        <h3 style="margin:0; color:#28a745;">
            Total Recaudado Hoy
        </h3>

        <h1 style="
            margin:10px 0 0;
            color:#28a745;
            font-size:35px;
        ">

            $<?php echo number_format($totalMonto, 2); ?>

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
        margin-bottom:30px;
    ">


        <!-- ==================================================
             GRÁFICO DE VENTAS
             ================================================== -->

        <div style="
            flex:2;
            min-width:350px;
            background:#fff;
            border-radius:12px;
            padding:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="text-align:center;">
                Ventas realizadas hoy
            </h3>

            <div style="height:350px;">

                <canvas id="graficoMontos"></canvas>

            </div>

        </div>


        <!-- ==================================================
             GRÁFICO POR VENDEDOR
             ================================================== -->

        <div style="
            flex:1;
            min-width:300px;
            background:#fff;
            border-radius:12px;
            padding:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
        ">

            <h3 style="text-align:center;">
                Recaudado por vendedor
            </h3>

            <div style="height:350px;">

                <canvas id="graficoVendedores"></canvas>

            </div>

        </div>

    </div>

    <?php endif; ?>


    <!-- ==================================================
         TABLA DE VENTAS
         ================================================== -->

    <div class="table-responsive">

        <table>

            <thead>

                <tr>

                    <th># Venta</th>

                    <th># Pedido</th>

                    <th>Fecha</th>

                    <th>Cliente</th>

                    <th>Vendedor</th>

                    <th>Monto Total ($)</th>

                    <th>Estado</th>

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
                        . htmlspecialchars($row['PEDIDOS_idPEDIDOS'])
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
                        . number_format((float)$row['MontoTotal'], 2)
                        . "</td>";

                    echo "<td>"
                        . htmlspecialchars($row['Estado'])
                        . "</td>";

                    echo "</tr>";
                }

            } else {

                echo "
                <tr>

                    <td colspan='7'
                        style='text-align:center;'>

                        No se registraron ventas el día de hoy.

                    </td>

                </tr>";

            }

            ?>

            </tbody>

        </table>

    </div>


    <!-- ==================================================
         TOTAL FINAL
         ================================================== -->

    <h3 style="
        margin-top:20px;
        text-align:right;
        color:#28a745;
    ">

        Total Recaudado Hoy:

        $<?php echo number_format($totalMonto, 2); ?>

    </h3>

</div>


<?php include '../princip/footer.php'; ?>


<!-- ========================================================
     JAVASCRIPT
     ======================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ====================================================
    // DATOS OBTENIDOS DESDE PHP
    // ====================================================

    const labelsVentas =
        <?php echo $jsonLabelsVentas; ?>;

    const montosVentas =
        <?php echo $jsonMontosVentas; ?>;

    const vendedores =
        <?php echo $jsonVendedores; ?>;

    const montosPorVendedor =
        <?php echo $jsonMontosVendedores; ?>;


    // ====================================================
    // COMPROBAR SI HAY VENTAS
    // ====================================================

    <?php if (count($filas) == 0): ?>

        Swal.fire({

            icon: 'info',

            title: 'Sin ventas',

            text: 'No se registraron ventas el día de hoy.',

            confirmButtonText: 'Aceptar',

            confirmButtonColor: '#28a745'

        });

    <?php endif; ?>


    // ====================================================
    // GRÁFICO DE MONTOS POR VENTA
    // ====================================================

    <?php if (count($filas) > 0): ?>

    const ctxMontos =
        document.getElementById('graficoMontos');


    new Chart(ctxMontos, {

        type: 'line',

        data: {

            labels: labelsVentas,

            datasets: [{

                label: 'Monto de venta ($)',

                data: montosVentas,

                borderWidth: 3,

                tension: 0.3,

                fill: false,

                pointRadius: 5,

                pointHoverRadius: 7

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text: 'Monto de cada venta realizada hoy',

                    font: {

                        size: 16

                    }

                },

                legend: {

                    display: true

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            return ' $' +
                                context.parsed.y.toFixed(2);

                        }

                    }

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    title: {

                        display: true,

                        text: 'Monto ($)'

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
    // GRÁFICO DE DONA POR VENDEDOR
    // ====================================================

    const ctxVendedores =
        document.getElementById('graficoVendedores');


    new Chart(ctxVendedores, {

        type: 'doughnut',

        data: {

            labels: vendedores,

            datasets: [{

                label: 'Recaudado ($)',

                data: montosPorVendedor,

                borderWidth: 2

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                title: {

                    display: true,

                    text: 'Distribución de ventas por vendedor',

                    font: {

                        size: 16

                    }

                },

                legend: {

                    position: 'bottom'

                },

                tooltip: {

                    callbacks: {

                        label: function(context) {

                            let valor =
                                context.parsed;

                            return ' ' +
                                context.label +
                                ': $' +
                                valor.toFixed(2);

                        }

                    }

                }

            }

        }

    });


    // ====================================================
    // ALERTA CON EL TOTAL DEL DÍA
    // ====================================================

    setTimeout(function() {

        Swal.fire({

            icon: 'success',

            title: 'Reporte generado',

            html:
                'Se registraron <b>' +
                <?php echo count($filas); ?> +
                '</b> venta(s).<br><br>' +

                'Total recaudado:<br>' +

                '<strong style="font-size:25px; color:#28a745;">' +

                '$<?php echo number_format($totalMonto, 2); ?>' +

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