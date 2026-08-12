<?php
// ========================================================
// CONEXIÓN A LA BASE DE DATOS - COLDDROP
// ========================================================

// Datos para conectarnos al servidor MySQL local de XAMPP
$servidor = "localhost";
$usuario = "root";
$contrasena = ""; // Contraseña por defecto o la configurada en XAMPP
$database = "colddrop"; // Nombre de nuestra base de datos

// Creamos la conexión con la base de datos usando mysqli
$conexion = new mysqli($servidor, $usuario, $contrasena, $database);

// Si ocurrió un error al conectarse, mostramos el mensaje y detenemos todo
if ($conexion->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}

// Configuramos los caracteres a UTF-8 para aceptar acentos y la letra ñ
$conexion->set_charset("utf8");

// Guardamos una copia en $conn por si en algún archivo se usa $conn o $conexion
$conn = $conexion;
?>
