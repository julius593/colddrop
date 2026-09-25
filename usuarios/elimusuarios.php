<?php

include_once '../conexion.php';

// ========================================================
// VERIFICAR QUE SE RECIBIÓ EL CI
// ========================================================

if (!isset($_GET['CI']) || trim($_GET['CI']) === '') {
    $mensaje = "No se especificó el CI del usuario.";
    $exito = false;
} else {

    $idCI = trim($_GET['CI']);

    // ====================================================
    // ELIMINAR USUARIO
    // ====================================================

    $sql = "DELETE FROM usuarios WHERE CI = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {

        $mensaje = "Error al preparar la consulta: " . $conn->error;
        $exito = false;

    } else {

        $stmt->bind_param("s", $idCI);

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {

                $mensaje = "Usuario eliminado exitosamente.";
                $exito = true;

            } else {

                $mensaje = "No se encontró el usuario o ya fue eliminado.";
                $exito = false;
            }

        } else {

            $mensaje = "Error al eliminar el usuario: " . $stmt->error;
            $exito = false;
        }

        $stmt->close();
    }

    $conn->close();
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

    <title>
        <?php echo $exito ? 'Usuario eliminado' : 'Error'; ?>
        - ColdDrop
    </title>


    <!-- Google Fonts -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
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
            margin: 0;
            padding: 0;
        }


        body {

            font-family: 'Poppins', sans-serif;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                linear-gradient(
                    135deg,
                    #eefbf7,
                    #f5f8ff
                );

            padding: 20px;

        }


        /* =========================================
           TARJETA
        ========================================= */

        .resultado-container {

            width: 100%;

            max-width: 650px;

            background: white;

            border-radius: 25px;

            padding: 50px 40px;

            text-align: center;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.10);

            animation: aparecer 0.5s ease;

        }


        /* =========================================
           ICONO
        ========================================= */

        .icono-exito {

            width: 100px;

            height: 100px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #20b26b;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 48px;

            box-shadow:
                0 10px 25px rgba(32, 178, 107, 0.30);

            animation: aparecerIcono 0.6s ease;

        }


        .icono-error {

            width: 100px;

            height: 100px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #dc3545;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 48px;

        }


        /* =========================================
           TITULO
        ========================================= */

        h1 {

            font-size: 30px;

            font-weight: 700;

            color: #176b4d;

            margin-bottom: 15px;

        }


        .error-title {

            color: #dc3545;

        }


        /* =========================================
           TEXTO
        ========================================= */

        p {

            color: #667085;

            font-size: 16px;

            line-height: 1.7;

            margin-bottom: 25px;

        }


        /* =========================================
           LINEA
        ========================================= */

        .separador {

            width: 100%;

            height: 1px;

            background: #e8eeee;

            margin: 25px 0;

        }


        /* =========================================
           BOTON
        ========================================= */

        .btn-volver {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            text-decoration: none;

            background: #20b26b;

            color: white;

            padding: 14px 30px;

            border-radius: 12px;

            font-size: 16px;

            font-weight: 600;

            transition: all 0.3s ease;

        }


        .btn-volver:hover {

            background: #168f54;

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px rgba(32, 178, 107, 0.25);

        }


        .btn-error {

            background: #dc3545;

        }


        .btn-error:hover {

            background: #b02a37;

        }


        /* =========================================
           ANIMACIONES
        ========================================= */

        @keyframes aparecer {

            from {

                opacity: 0;

                transform: translateY(20px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

            }

        }


        @keyframes aparecerIcono {

            from {

                opacity: 0;

                transform: scale(0.5);

            }

            to {

                opacity: 1;

                transform: scale(1);

            }

        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 600px) {

            .resultado-container {

                padding: 35px 20px;

            }

            h1 {

                font-size: 24px;

            }

            .icono-exito,
            .icono-error {

                width: 80px;

                height: 80px;

                font-size: 38px;

            }

        }

    </style>

</head>


<body>


<div class="resultado-container">


    <?php if ($exito): ?>

        <!-- =========================================
             ÉXITO
        ========================================== -->

        <div class="icono-exito">

            <i class="fa-solid fa-check"></i>

        </div>


        <h1>
            Usuario eliminado exitosamente.
        </h1>


        <p>
            El usuario ha sido eliminado correctamente
            de la base de datos.
        </p>


        <div class="separador"></div>


        <a
            href="leerusuarios.php"
            class="btn-volver"
        >

            <i class="fa-solid fa-users"></i>

            Volver a la lista

        </a>


    <?php else: ?>

        <!-- =========================================
             ERROR
        ========================================== -->

        <div class="icono-error">

            <i class="fa-solid fa-xmark"></i>

        </div>


        <h1 class="error-title">
            No se pudo eliminar
        </h1>


        <p>

            <?php
            echo htmlspecialchars($mensaje);
            ?>

        </p>


        <div class="separador"></div>


        <a
            href="leerusuarios.php"
            class="btn-volver btn-error"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver

        </a>


    <?php endif; ?>


</div>


</body>

</html>