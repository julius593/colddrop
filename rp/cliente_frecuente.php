<?php
// ========================================================
// REPORTE: CLIENTE MÁS FRECUENTE - COLDDROP
// ========================================================
include_once '../conexion.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}
<?php
// ========================================================
// REPORTE: CLIENTE MÁS FRECUENTE - COLDDROP
// ========================================================
include_once '../conexion.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador' && $_SESSION['rol'] != 'vendedor')) {
    header("Location: ../princip/iniciosesion.php");
    exit();
}


$sql = "SELECT Nombre as Cliente, COUNT(*) as TotalPedidos FROM pedidos WHERE Nombre IS NOT NULL AND Nombre != '' GROUP BY Nombre ORDER BY TotalPedidos DESC LIMIT 10";
$resultado = $conn->query($sql);
?>
