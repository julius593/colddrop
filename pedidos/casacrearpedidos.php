<?php 
include_once '../conexion.php';
$Nombre=$_POST['Nombre'];
$Fecha=$_POST['Fecha'];
$Estado=$_POST['Estado'];
$NombreVendedor=$_POST['NombreVendedor'];
$sql = "INSERT INTO pedidos (idPEDIDOS, Nombre, Fecha, Estado, NombreVendedor) VALUES('$idPEDIDOS','$Nombre','$Fecha', '$Estado','$NombreVendedor' )";

