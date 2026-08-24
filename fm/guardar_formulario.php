<?php
// ========================================================
// GUARDAR FORMULARIO MEDIOAMBIENTAL - COLDROP
// ========================================================

include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================================
// COMPROBAR QUE EL FORMULARIO FUE ENVIADO
// ========================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: formulario.php');
    exit();
}

// ========================================================
// RECIBIR Y LIMPIAR DATOS
// ========================================================

$Nombre = trim($_POST['Nombre'] ?? '');
$Apellido = trim($_POST['Apellido'] ?? '');
$Tipo = trim($_POST['Tipo'] ?? '');
$Importancia = trim($_POST['Importancia'] ?? '');
$Comentario = trim($_POST['Comentario'] ?? '');
$Propuesta = trim($_POST['Propuesta'] ?? '');

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

        <h2>❌ Faltan datos obligatorios</h2>

        <p>
            Por favor completa todos los campos requeridos.
        </p>

        <a href='formulario_medioambiental.php'>
            Volver al formulario
        </a>

    </div>
    ";

    exit();
}

// ========================================================
// CONSULTA SQL
// ========================================================

$sql = "INSERT INTO medioambiental
        (Nombre, Apellido, Tipo, Importancia, Comentario, Propuesta)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die(
        "Error al preparar la consulta: "
        . htmlspecialchars($conn->error)
    );

}

// ========================================================
// ASIGNAR VALORES
// ========================================================

$stmt->bind_param(
    "ssssss",
    $Nombre,
    $Apellido,
    $Tipo,
    $Importancia,
    $Comentario,
    $Propuesta
);

// ========================================================
// EJECUTAR
// ========================================================

if ($stmt->execute()) {

    echo "
    <div style='
        font-family: Arial;
        text-align: center;
        margin-top: 50px;
    '>

        <h2>✅ ¡Formulario enviado correctamente!</h2>

        <p>
            Gracias por compartir tu propuesta medioambiental.
        </p>

        <a href='../princip/inicio.php'>
            Volver al Inicio
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

        <h2>❌ Error al guardar el formulario</h2>

        <p>"
        . htmlspecialchars($stmt->error)
        . "</p>

        <a href='formulario_medioambiental.php'>
            Volver al formulario
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