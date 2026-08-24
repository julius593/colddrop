<?php
// ========================================================
// VER DETALLES DEL FORMULARIO MEDIOAMBIENTAL - COLDROP
// ========================================================

include_once '../conexion.php';

if (!headers_sent() && session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================================
// OBTENER ID
// ========================================================

$id = $_GET['id_medioambiental'] ?? '';

$medioambientalData = null;

// ========================================================
// BUSCAR REGISTRO
// ========================================================

if (!empty($id)) {

    $sql = "SELECT *
            FROM medioambiental
            WHERE id_medioambiental = ?";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $medioambientalData = $resultado->fetch_assoc();
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Detalles Medioambientales - ColdDrop</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="../css/admin.css">

</head>

<body>

<?php include '../princip/header.php'; ?>


<div class="admin-container">

    <h1 class="admin-title">
        Formulario Medioambiental
    </h1>


    <?php if ($medioambientalData): ?>

        <div class="admin-card"
             style="max-width: 700px; margin: 0 auto;">

            <h3>
                🌱 Información Medioambiental
            </h3>


            <ul class="profile-info">

                <li>
                    <strong>ID:</strong>

                    <?php
                    echo htmlspecialchars(
                        $medioambientalData['id_medioambiental']
                    );
                    ?>
                </li>


                <li>
                    <strong>Nombre:</strong>

                    <?php
                    echo htmlspecialchars(
                        $medioambientalData['Nombre']
                    );
                    ?>
                </li>


                <li>
                    <strong>Apellido:</strong>

                    <?php
                    echo htmlspecialchars(
                        $medioambientalData['Apellido']
                    );
                    ?>
                </li>


                <li>
                    <strong>Tipo de aporte:</strong>

                    <?php
                    echo htmlspecialchars(
                        $medioambientalData['Tipo']
                    );
                    ?>
                </li>


                <li>
                    <strong>Importancia:</strong>

                    <?php
                    echo htmlspecialchars(
                        $medioambientalData['Importancia']
                    );
                    ?>
                </li>


                <li>
                    <strong>Comentario:</strong>

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $medioambientalData['Comentario']
                        )
                    );
                    ?>
                </li>


                <li>
                    <strong>Propuesta:</strong>

                    <?php

                    echo !empty(
                        $medioambientalData['Propuesta']
                    )
                    ?
                    nl2br(
                        htmlspecialchars(
                            $medioambientalData['Propuesta']
                        )
                    )
                    :
                    'No se registró una propuesta';

                    ?>

                </li>


                <?php if (isset($medioambientalData['Fecha'])): ?>

                    <li>

                        <strong>Fecha:</strong>

                        <?php
                        echo htmlspecialchars(
                            $medioambientalData['Fecha']
                        );
                        ?>

                    </li>

                <?php endif; ?>

            </ul>


            <br>

            <a href="medioambiental.php"
               class="links">

                ← Volver a formularios

            </a>

        </div>


    <?php else: ?>

        <div class="admin-card"
             style="max-width: 600px; margin: 0 auto; text-align: center;">

            <h3>⚠️ Registro no encontrado</h3>

            <p>
                No se encontró el formulario medioambiental solicitado.
            </p>

            <a href="medioambiental.php"
               class="links">

                ← Volver

            </a>

        </div>

    <?php endif; ?>


</div>


<?php include '../princip/footer.php'; ?>

</body>

</html>