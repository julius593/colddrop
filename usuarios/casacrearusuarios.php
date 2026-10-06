<?php
// ========================================================
// PROCESAR E INSERTAR NUEVO USUARIO - COLDROP
// ========================================================

include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ========================================================
// RECIBIR DATOS
// ========================================================

$CI = trim($_POST['CI'] ?? '');
$Nombre = trim($_POST['Nombre'] ?? '');
$Apellido = trim($_POST['Apellido'] ?? '');
$Usuario = trim($_POST['Usuario'] ?? '');
$Contrasena = trim($_POST['Contrasena'] ?? '');
$Direccion = trim($_POST['Direccion'] ?? '');
$Celular = trim($_POST['Celular'] ?? '');


// ========================================================
// DETERMINAR ROL Y ESTADO
// ========================================================

$esAdministrador =
    isset($_SESSION['rol']) &&
    $_SESSION['rol'] === 'Administrador';

$Rol = $esAdministrador
    ? ($_POST['Rol'] ?? '')
    : 'cliente';

$Estado = $esAdministrador
    ? ($_POST['Estado'] ?? '')
    : 'Activo';


// ========================================================
// VALIDAR CAMPOS
// ========================================================

if (
    $CI === '' ||
    $Nombre === '' ||
    $Apellido === '' ||
    $Usuario === '' ||
    $Contrasena === '' ||
    $Direccion === '' ||
    $Celular === ''
) {

    $exito = false;

    $mensaje = 'Completa todos los campos obligatorios.';

} else {

    // ====================================================
    // INSERTAR USUARIO
    // ====================================================

    $sql = "INSERT INTO usuarios
            (
                CI,
                Nombre,
                Apellido,
                Usuario,
                Contrasena,
                Direccion,
                Celular,
                Rol,
                Estado
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);


    if (!$stmt) {

        $exito = false;

        $mensaje =
            'Error al preparar la consulta: ' .
            $conn->error;

    } else {

        $stmt->bind_param(
            'sssssssss',
            $CI,
            $Nombre,
            $Apellido,
            $Usuario,
            $Contrasena,
            $Direccion,
            $Celular,
            $Rol,
            $Estado
        );


        // ================================================
        // EJECUTAR
        // ================================================

        if ($stmt->execute()) {

            $exito = true;

            $mensaje = 'El usuario fue registrado correctamente.';

        } else {

            $exito = false;

            $mensaje =
                'Error al registrar el usuario: ' .
                $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();

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
        <?php echo $exito
            ? 'Usuario creado'
            : 'Error al registrar'; ?>
        - ColdDrop
    </title>


    <!-- ==================================================
         GOOGLE FONTS
    =================================================== -->

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


    <!-- ==================================================
         FONT AWESOME
    =================================================== -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >


    <style>

        /* ==================================================
           GENERAL
        ================================================== */

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


        /* ==================================================
           CONTENEDOR PRINCIPAL
        ================================================== */

        .resultado-container {

            width: 100%;

            max-width: 700px;

            background: #ffffff;

            border-radius: 25px;

            padding: 50px 45px;

            text-align: center;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.10);

            animation:
                aparecer 0.6s ease;

        }


        /* ==================================================
           ICONO DE ÉXITO
        ================================================== */

        .icono-exito {

            width: 110px;

            height: 110px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #20b26b;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 52px;

            box-shadow:
                0 10px 30px
                rgba(32, 178, 107, 0.30);

            animation:
                aparecerIcono 0.7s ease;

        }


        /* ==================================================
           ICONO ERROR
        ================================================== */

        .icono-error {

            width: 110px;

            height: 110px;

            margin: 0 auto 25px;

            border-radius: 50%;

            background: #dc3545;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            font-size: 52px;

        }


        /* ==================================================
           TITULOS
        ================================================== */

        h1 {

            color: #176b4d;

            font-size: 32px;

            font-weight: 700;

            margin-bottom: 15px;

        }


        .titulo-error {

            color: #dc3545;

        }


        /* ==================================================
           TEXTO
        ================================================== */

        .mensaje {

            color: #667085;

            font-size: 17px;

            line-height: 1.7;

            margin-bottom: 25px;

        }


        /* ==================================================
           DATOS DEL USUARIO
        ================================================== */

        .usuario-creado {

            background: #f0faf5;

            border: 1px solid #d7f0e3;

            border-radius: 15px;

            padding: 20px;

            margin: 25px 0;

            text-align: left;

        }


        .usuario-creado p {

            margin: 7px 0;

            color: #475467;

        }


        .usuario-creado strong {

            color: #176b4d;

        }


        /* ==================================================
           SEPARADOR
        ================================================== */

        .separador {

            width: 100%;

            height: 1px;

            background: #e6eaea;

            margin: 30px 0;

        }


        /* ==================================================
           BOTONES
        ================================================== */

        .botones {

            display: flex;

            justify-content: center;

            gap: 15px;

            flex-wrap: wrap;

        }


        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding: 14px 25px;

            border-radius: 12px;

            text-decoration: none;

            font-size: 15px;

            font-weight: 600;

            transition: all 0.3s ease;

        }


        /* ==================================================
           BOTÓN INICIAR SESIÓN
        ================================================== */

        .btn-login {

            background: #20b26b;

            color: white;

        }


        .btn-login:hover {

            background: #168f54;

            transform: translateY(-2px);

            box-shadow:
                0 8px 20px
                rgba(32, 178, 107, 0.25);

        }


        /* ==================================================
           BOTÓN USUARIOS
        ================================================== */

        .btn-usuarios {

            background: #f1f5f9;

            color: #475467;

        }


        .btn-usuarios:hover {

            background: #e2e8f0;

            transform: translateY(-2px);

        }


        /* ==================================================
           BOTÓN ERROR
        ================================================== */

        .btn-error {

            background: #dc3545;

            color: white;

        }


        .btn-error:hover {

            background: #b02a37;

        }


        /* ==================================================
           ANIMACIONES
        ================================================== */

        @keyframes aparecer {

            from {

                opacity: 0;

                transform: translateY(25px);

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


        /* ==================================================
           RESPONSIVE
        ================================================== */

        @media (max-width: 600px) {

            .resultado-container {

                padding: 35px 20px;

            }


            h1 {

                font-size: 25px;

            }


            .icono-exito,
            .icono-error {

                width: 85px;

                height: 85px;

                font-size: 40px;

            }


            .btn {

                width: 100%;

            }

        }

    </style>

</head>


<body>


<div class="resultado-container">


    <?php if ($exito): ?>


        <!-- =================================================
             REGISTRO EXITOSO
        ================================================== -->

        <div class="icono-exito">

            <i class="fa-solid fa-check"></i>

        </div>


        <h1>
            ¡Usuario creado exitosamente!
        </h1>


        <p class="mensaje">

            El usuario fue registrado correctamente
            en el sistema <strong>ColdDrop</strong>.

        </p>


        <!-- =================================================
             INFORMACIÓN DEL USUARIO
        ================================================== -->

        <div class="usuario-creado">

            <p>
                <strong>
                    <i class="fa-solid fa-id-card"></i>
                    CI:
                </strong>

                <?php echo htmlspecialchars($CI); ?>

            </p>


            <p>
                <strong>
                    <i class="fa-solid fa-user"></i>
                    Nombre:
                </strong>

                <?php
                echo htmlspecialchars(
                    $Nombre . ' ' . $Apellido
                );
                ?>

            </p>


            <p>
                <strong>
                    <i class="fa-solid fa-at"></i>
                    Usuario:
                </strong>

                <?php echo htmlspecialchars($Usuario); ?>

            </p>


            <p>
                <strong>
                    <i class="fa-solid fa-user-tag"></i>
                    Rol:
                </strong>

                <?php echo htmlspecialchars($Rol); ?>

            </p>


            <p>
                <strong>
                    <i class="fa-solid fa-circle-check"></i>
                    Estado:
                </strong>

                <?php echo htmlspecialchars($Estado); ?>

            </p>

        </div>


        <p class="mensaje">

            Ahora puedes utilizar las credenciales
            registradas para iniciar sesión.

        </p>


        <div class="separador"></div>


        <!-- =================================================
             BOTONES
        ================================================== -->

        <div class="botones">


            <a
                href="../princip/iniciosesion.php"
                class="btn btn-login"
            >

                <i class="fa-solid fa-right-to-bracket"></i>

                Iniciar Sesión

            </a>


            <a
                href="leerusuarios.php"
                class="btn btn-usuarios"
            >

                <i class="fa-solid fa-users"></i>

                Ver Usuarios

            </a>


        </div>


    <?php else: ?>


        <!-- =================================================
             ERROR
        ================================================== -->

        <div class="icono-error">

            <i class="fa-solid fa-xmark"></i>

        </div>


        <h1 class="titulo-error">

            No se pudo registrar

        </h1>


        <p class="mensaje">

            <?php
            echo htmlspecialchars($mensaje);
            ?>

        </p>


        <div class="separador"></div>


        <div class="botones">


            <a
                href="crearusuarios.php"
                class="btn btn-error"
            >

                <i class="fa-solid fa-arrow-left"></i>

                Volver al formulario

            </a>


        </div>


    <?php endif; ?>


</div>


</body>

</html>

