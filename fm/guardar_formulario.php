<?php
// ========================================================
// GUARDAR FORMULARIO DE SUGERENCIAS - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST['Apellido'];
    $Tipo = $_POST['Tipo'];
    $Importancia = $_POST['Importancia'];
    $Comentario = $_POST['Comentario'];
    $Propuesta = isset($_POST['Propuesta']) ? $_POST['Propuesta'] : '';

    // 1. Guardar en archivo de texto sugerencias.txt usando fwrite()
    $fecha = date('Y-m-d H:i:s');
    $linea = "Fecha: $fecha | Cliente: $Nombre $Apellido | Tipo: $Tipo | Importancia: $Importancia | Comentario: $Comentario\n";
    
    $fp = fopen("sugerencias.txt", "a");
    if ($fp) {
        fwrite($fp, $linea);
        fclose($fp);
    }

    // 2. Guardar en la base de datos MySQL
    $sql = "INSERT INTO medioambiental (Nombre, Apellido, Tipo, Importancia, Comentario, Propuesta) 
            VALUES ('$Nombre', '$Apellido', '$Tipo', '$Importancia', '$Comentario', '$Propuesta')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h2 style='color:#28a745;'>¡Formulario y sugerencia guardados correctamente!</h2>";
        echo "<p>Tu comentario ha sido registrado en el sistema.</p>";
        echo "<a href='../princip/inicio.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver al Inicio</a>";
        echo "</div>";
    } else {
        echo "Error al guardar en la base de datos: " . $conn->error;
    }
} else {
    header("Location: formulario.php");
    exit();
}
?>