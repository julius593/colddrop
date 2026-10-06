<?php
// ========================================================
// GUARDAR FORMULARIO DE SUGERENCIAS CON PROTOCOLOS DE SEGURIDAD - COLDDROP
// ========================================================
include_once '../conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Protocolo Seguridad Inyección SQL & Inyección PHP/HTML:
    // 1. strip_tags() para evitar inyección de código PHP/HTML en archivos de texto
    // 2. real_escape_string() para evitar inyección SQL en la base de datos
    
    $Nombre = isset($_POST['Nombre']) ? $conn->real_escape_string(strip_tags(trim($_POST['Nombre']))) : '';
    $Apellido = isset($_POST['Apellido']) ? $conn->real_escape_string(strip_tags(trim($_POST['Apellido']))) : '';
    $Tipo = isset($_POST['Tipo']) ? $conn->real_escape_string(strip_tags(trim($_POST['Tipo']))) : '';
    $Importancia = isset($_POST['Importancia']) ? $conn->real_escape_string(strip_tags(trim($_POST['Importancia']))) : '';
    $Comentario = isset($_POST['Comentario']) ? $conn->real_escape_string(strip_tags(trim($_POST['Comentario']))) : '';
    $Propuesta = isset($_POST['Propuesta']) ? $conn->real_escape_string(strip_tags(trim($_POST['Propuesta']))) : '';

    // 1. Guardar en archivo sugerencias.txt limpiando etiquetas PHP/HTML (Evita Inyección PHP en archivos)
    $fecha = date('Y-m-d H:i:s');
    $linea = "Fecha: $fecha | Cliente: $Nombre $Apellido | Tipo: $Tipo | Importancia: $Importancia | Comentario: $Comentario\n";
    
    $fp = fopen("sugerencias.txt", "a");
    if ($fp) {
        fwrite($fp, $linea);
        fclose($fp);
    }

    // 2. Guardar en la base de datos MySQL de forma segura
    $sql = "INSERT INTO medioambiental (Nombre, Apellido, Tipo, Importancia, Comentario, Propuesta) 
            VALUES ('$Nombre', '$Apellido', '$Tipo', '$Importancia', '$Comentario', '$Propuesta')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
        echo "<h2 style='color:#28a745;'>¡Formulario y sugerencia guardados correctamente!</h2>";
        echo "<p>Tu comentario ha sido registrado en el sistema.</p>";
        echo "<a href='../princip/inicio.php' style='display:inline-block; margin-top:15px; padding:10px 20px; background:#111; color:#fff; text-decoration:none; border-radius:6px;'>Volver al Inicio</a>";
        echo "</div>";
    } else {
        echo "Error al guardar en la base de datos: " . htmlspecialchars($conn->error);
    }
} else {
    header("Location: formulario.php");
    exit();
}
?>