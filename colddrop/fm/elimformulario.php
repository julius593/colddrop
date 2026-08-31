<?php
// ========================================================
// ELIMINAR FORMULARIO MEDIOAMBIENTAL - COLDROP
// ========================================================

include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ========================================================
// VERIFICAR ADMINISTRADOR
// ========================================================

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header('Location: ../princip/iniciosesion.php');
    exit();
}

// ========================================================
// RECIBIR ID
// ========================================================

$id = $_GET['id_medioambiental'] ?? '';

if ($id === '' || !is_numeric($id)) {
    echo "ID de formulario no válido.";
    exit();
}

$id = (int)$id;

// ========================================================
// ELIMINAR REGISTRO
// ========================================================

$sql = "DELETE FROM medioambiental
        WHERE id_medioambiental = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    die(
        "Error al preparar la consulta: "
        . htmlspecialchars($conexion->error)
    );
}

$stmt->bind_param("i", $id);

// ========================================================
// EJECUTAR
// ========================================================

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        echo "
        <div style='
            font-family: Arial;
            text-align: center;
            margin-top: 50px;
        '>

            <h2>✅ Formulario eliminado correctamente</h2>

            <p>
                El registro medioambiental fue eliminado.
            </p>

            <a href='medioambiental.php'>
                ← Volver a formularios
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

            <h2>⚠️ Registro no encontrado</h2>

            <p>
                No existe un formulario con ese ID.
            </p>

            <a href='medioambiental.php'>
                ← Volver
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

        <h2>❌ Error al eliminar</h2>

        <p>"
        . htmlspecialchars($stmt->error)
        . "</p>

        <a href='medioambiental.php'>
            ← Volver
        </a>

    </div>
    ";
}

// ========================================================
// CERRAR
// ========================================================

$stmt->close();
$conexion->close();

?>