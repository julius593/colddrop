<?php
// ========================================================
// ACTUALIZAR FORMULARIO MEDIOAMBIENTAL - COLDROP
// ========================================================

include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================================
// COMPROBAR QUE SE RECIBIÓ EL FORMULARIO
// ========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: medioambiental.php');
    exit();
}

// ========================================================
// RECIBIR DATOS
// ========================================================

$id = $_POST['id_medioambiental'] ?? '';

$Nombre       = trim($_POST['Nombre'] ?? '');
$Apellido     = trim($_POST['Apellido'] ?? '');
$Tipo         = trim($_POST['Tipo'] ?? '');
$Importancia  = trim($_POST['Importancia'] ?? '');
$Comentario   = trim($_POST['Comentario'] ?? '');
$Propuesta    = trim($_POST['Propuesta'] ?? '');


// ========================================================
// VALIDAR ID
// ========================================================

if ($id === '' || !is_numeric($id)) {

    echo "
    <div style='
        font-family: Arial;
        text-align: center;
        margin-top: 50px;
    '>
        <h2>❌ ID inválido</h2>

        <p>
            No se recibió un identificador válido.
        </p>

        <a href='medioambiental.php'>
            Volver
        </a>
    </div>
    ";

    exit();
}


// ========================================================
// VALIDAR CAMPOS OBLIGATORIOS
// ========================================================

if (
    $Nombre === '' ||
    $Apellido === '' ||
    $Tipo === '' ||
    $Importancia === '' ||
    $Comentario === ''
) {

    echo "
    <div style='
        font-family: Arial;
        text-align: center;
        margin-top: 50px;
    '>

        <h2>❌ Faltan datos</h2>

        <p>
            Completa todos los campos obligatorios.
        </p>

        <a href='medioambiental.php'>
            Volver
        </a>

    </div>
    ";

    exit();
}


// ========================================================
// ACTUALIZAR INFORMACIÓN
// ========================================================

$sql = "UPDATE medioambiental
        SET Nombre = ?,
            Apellido = ?,
            Tipo = ?,
            Importancia = ?,
            Comentario = ?,
            Propuesta = ?
        WHERE id_medioambiental = ?";

$stmt = $conn->prepare($sql);


// ========================================================
// COMPROBAR PREPARACIÓN
// ========================================================

if (!$stmt) {

    die(
        "Error al preparar la consulta: "
        . htmlspecialchars($conn->error)
    );
}


// ========================================================
// ASIGNAR VALORES
// ========================================================

$id = (int)$id;

$stmt->bind_param(
    "ssssssi",
    $Nombre,
    $Apellido,
    $Tipo,
    $Importancia,
    $Comentario,
    $Propuesta,
    $id
);


// ========================================================
// EJECUTAR ACTUALIZACIÓN
// ========================================================

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        echo "
        <div style='
            font-family: Arial;
            text-align: center;
            margin-top: 50px;
        '>

            <h2>✅ Información actualizada correctamente</h2>

            <p>
                El formulario medioambiental fue actualizado exitosamente.
            </p>

            <a href='medioambiental.php'>
                Volver al formulario
            </a>

        </div>
        ";

    } else {

        echo "
        <div style='
            font-family: Arial;
            text-align: center;
            margin-top: 50px;
        '>

            <h2>⚠️ Sin cambios</h2>

            <p>
                El registro existe, pero no se realizaron cambios.
            </p>

            <a href='medioambiental.php'>
                Volver
            </a>

        </div>
        ";
    }

} else {

    echo "
    <div style='
        font-family: Arial;
        text-align: center;
        margin-top: 50px;
    '>

        <h2>❌ Error al actualizar</h2>

        <p>"
        . htmlspecialchars($stmt->error)
        . "</p>

        <a href='medioambiental.php'>
            Volver
        </a>

    </div>
    ";
}


// ========================================================
// CERRAR
// ========================================================

$stmt->close();
$conn->close();

?>