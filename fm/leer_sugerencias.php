<?php
// =========================================================
// VER SUGERENCIAS GUARDADAS EN ARCHIVO TEXTO - COLDDROP
// ========================================================
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}
$contenido = "No hay sugerencias registradas aún en el archivo sugerencias.txt.";
if (file_exists("sugerencias.txt")) {
    $contenido = file_get_contents("sugerencias.txt");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sugerencias Registradas (fwrite) - ColdDrop</title>
    <link rel="stylesheet" href="../css/formularios.css">
</head>
<body>
     <?php include '../princip/header.php'; ?>
     
     <div class="form-container" style="margin: 40px auto; max-width: 800px;">
        <h2>BITÁCORA DE SUGERENCIAS (fwrite)</h2>
        <p style="text-align: center; color: #666;">Comentarios guardados en el archivo <code>sugerencias.txt</code></p>

        <textarea rows="15" style="width: 100%; font-family: monospace; padding: 10px; border-radius: 6px; border: 1px solid #ccc; background: #f8f9fa;" readonly><?php echo htmlspecialchars($contenido); ?></textarea>

        <div style="margin-top: 20px; text-align: center;">
            <a href="../princip/Administrador.php" class="links">← Volver al Panel Admin</a>
        </div>
    </div>

    <?php include '../princip/footer.php'; ?>
</body>
</html>