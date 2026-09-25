<?php
// ========================================================
// CASA ACTUALIZAR USUARIOS - COLDROP
// ========================================================

include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ========================================================
// OBTENER CI
// ========================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $CI = trim($_POST['CI'] ?? '');

} else {

    $CI = trim($_GET['CI'] ?? '');

}


// ========================================================
// COMPROBAR CI
// ========================================================

if ($CI === '') {

    die("
        <div style='
            font-family: Arial;
            text-align: center;
            margin-top: 80px;
        '>

            <h2>❌ No se especificó el CI</h2>

            <p>
                No se recibió el CI del usuario.
            </p>

        </div>
    ");

}


// ========================================================
// BUSCAR USUARIO
// ========================================================

$sql = "SELECT * FROM usuarios WHERE CI = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conn->error);
}

$stmt->bind_param("s", $CI);

$stmt->execute();

$resultado = $stmt->get_result();


// ========================================================
// COMPROBAR SI EXISTE
// ========================================================

if ($resultado->num_rows === 0) {

    die("
        <div style='
            font-family: Arial;
            text-align: center;
            margin-top: 80px;
        '>

            <h2>❌ Usuario no encontrado</h2>

            <p>
                No existe un usuario con el CI:
                <strong>"
                . htmlspecialchars($CI) .
                "</strong>
            </p>

        </div>
    ");
}

$usuarioData = $resultado->fetch_assoc();

$stmt->close();


// ========================================================
// SI SE ENVIO EL FORMULARIO → ACTUALIZAR
// ========================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ====================================================
    // RECIBIR DATOS
    // Si algún campo viene vacío, conservamos el anterior
    // ====================================================

    $Nombre = trim($_POST['Nombre'] ?? '');

    $Apellido = trim($_POST['Apellido'] ?? '');

    $Usuario = trim($_POST['Usuario'] ?? '');

    $Contrasena = trim($_POST['Contrasena'] ?? '');

    $Direccion = trim($_POST['Direccion'] ?? '');

    $Celular = trim($_POST['Celular'] ?? '');

    $Rol = trim($_POST['Rol'] ?? '');

    $Estado = trim($_POST['Estado'] ?? '');


    // ====================================================
    // CONSERVAR DATOS ANTERIORES SI VIENEN VACÍOS
    // ====================================================

    if ($Nombre === '') {
        $Nombre = $usuarioData['Nombre'];
    }

    if ($Apellido === '') {
        $Apellido = $usuarioData['Apellido'];
    }

    if ($Usuario === '') {
        $Usuario = $usuarioData['Usuario'];
    }

    if ($Direccion === '') {
        $Direccion = $usuarioData['Direccion'];
    }

    if ($Celular === '') {
        $Celular = $usuarioData['Celular'];
    }

    if ($Rol === '') {
        $Rol = $usuarioData['Rol'];
    }

    if ($Estado === '') {
        $Estado = $usuarioData['Estado'];
    }


    // ====================================================
    // ACTUALIZAR SIN CAMBIAR CONTRASEÑA
    // ====================================================

    if ($Contrasena === '') {

        $sql = "UPDATE usuarios
                SET Nombre = ?,
                    Apellido = ?,
                    Usuario = ?,
                    Direccion = ?,
                    Celular = ?,
                    Rol = ?,
                    Estado = ?
                WHERE CI = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die(
                "Error al preparar la consulta: "
                . htmlspecialchars($conn->error)
            );
        }

        $stmt->bind_param(
            "ssssssss",
            $Nombre,
            $Apellido,
            $Usuario,
            $Direccion,
            $Celular,
            $Rol,
            $Estado,
            $CI
        );

    } else {

        // =================================================
        // ACTUALIZAR TAMBIÉN CONTRASEÑA
        // =================================================

        $sql = "UPDATE usuarios
                SET Nombre = ?,
                    Apellido = ?,
                    Usuario = ?,
                    Contrasena = ?,
                    Direccion = ?,
                    Celular = ?,
                    Rol = ?,
                    Estado = ?
                WHERE CI = ?";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die(
                "Error al preparar la consulta: "
                . htmlspecialchars($conn->error)
            );
        }

        $stmt->bind_param(
            "sssssssss",
            $Nombre,
            $Apellido,
            $Usuario,
            $Contrasena,
            $Direccion,
            $Celular,
            $Rol,
            $Estado,
            $CI
        );
    }


    // ====================================================
    // EJECUTAR
    // ====================================================

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();

        header(
            "Location: casaactualizarusuarios.php?CI="
            . urlencode($CI)
            . "&actualizado=1"
        );

        exit();

    } else {

        die(
            "Error al actualizar: "
            . htmlspecialchars($stmt->error)
        );
    }
}


// ========================================================
// MENSAJE DE ACTUALIZACIÓN
// ========================================================

$actualizado = (
    isset($_GET['actualizado']) &&
    $_GET['actualizado'] === '1'
);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Actualizar Usuario - ColdDrop</title>

    <link
        rel="stylesheet"
        href="../css/admin.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

</head>

<body>

<?php include '../princip/header.php'; ?>


<div class="admin-container">

    <h1 class="admin-title">
        Actualizar Usuario
    </h1>


    <?php if ($actualizado): ?>

        <div style="
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px auto;
            max-width: 600px;
            text-align: center;
            border-radius: 8px;
        ">

            <strong>
                ✅ Usuario actualizado correctamente.
            </strong>

        </div>

    <?php endif; ?>


    <div
        class="admin-card"
        style="max-width: 600px; margin: 0 auto;"
    >

        <h3>
            <i class="fa-solid fa-user-pen"></i>
            Información del Usuario
        </h3>


        <form
            action="casaactualizarusuarios.php"
            method="POST"
        >

            <!-- CI -->

            <label>
                Carnet de Identidad (CI):
            </label>

            <input
                type="text"
                name="CI"
                value="<?php
                    echo htmlspecialchars($usuarioData['CI']);
                ?>"
                readonly
            >


            <!-- NOMBRE -->

            <label>
                Nombre:
            </label>

            <input
                type="text"
                name="Nombre"
                value="<?php
                    echo htmlspecialchars($usuarioData['Nombre']);
                ?>"
            >


            <!-- APELLIDO -->

            <label>
                Apellido:
            </label>

            <input
                type="text"
                name="Apellido"
                value="<?php
                    echo htmlspecialchars($usuarioData['Apellido']);
                ?>"
            >


            <!-- USUARIO -->

            <label>
                Usuario:
            </label>

            <input
                type="text"
                name="Usuario"
                value="<?php
                    echo htmlspecialchars($usuarioData['Usuario']);
                ?>"
            >


            <!-- CONTRASEÑA -->

            <label>
                Contraseña:
            </label>

            <input
                type="password"
                name="Contrasena"
                placeholder="Dejar vacío para mantener la actual"
            >


            <!-- DIRECCIÓN -->

            <label>
                Dirección:
            </label>

            <input
                type="text"
                name="Direccion"
                value="<?php
                    echo htmlspecialchars($usuarioData['Direccion']);
                ?>"
            >


            <!-- CELULAR -->

            <label>
                Celular:
            </label>

            <input
                type="text"
                name="Celular"
                value="<?php
                    echo htmlspecialchars($usuarioData['Celular']);
                ?>"
            >


            <!-- ROL -->

            <label>
                Rol:
            </label>

            <select name="Rol">

                <option value="Administrador"
                    <?php
                    echo ($usuarioData['Rol'] === 'Administrador')
                        ? 'selected'
                        : '';
                    ?>
                >
                    Administrador
                </option>

                <option value="vendedor"
                    <?php
                    echo ($usuarioData['Rol'] === 'vendedor')
                        ? 'selected'
                        : '';
                    ?>
                >
                    Vendedor
                </option>

                <option value="cliente"
                    <?php
                    echo ($usuarioData['Rol'] === 'cliente')
                        ? 'selected'
                        : '';
                    ?>
                >
                    Cliente
                </option>

            </select>


            <!-- ESTADO -->

            <label>
                Estado:
            </label>

            <select name="Estado">

                <option value="Activo"
                    <?php
                    echo ($usuarioData['Estado'] === 'Activo')
                        ? 'selected'
                        : '';
                    ?>
                >
                    Activo
                </option>

                <option value="Inactivo"
                    <?php
                    echo ($usuarioData['Estado'] === 'Inactivo')
                        ? 'selected'
                        : '';
                    ?>
                >
                    Inactivo
                </option>

            </select>


            <br><br>


            <button type="submit">
                <i class="fa-solid fa-floppy-disk"></i>
                Actualizar Usuario
            </button>

        </form>

    </div>

</div>

</body>

</html>