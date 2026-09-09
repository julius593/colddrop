<?php
include_once '../conexion.php';
$CI=$_POST['CI'];
$Nombre=$_POST['Nombre'];
$Direccion=$_POST['Direccion'];
$Celular=$_POST['Celular'];
$Rol=$_POST['Rol'];
$Estado=$_POST['Estado'];

$sql="UPDATE usuarios SET Nombre='$Nombre',Direccion='$Direccion',Celular='$Celular',Rol='$Rol',Estado='$Estado',CI='$CI' WHERE CI=$CI ";
if($conexion->query($sql)=== TRUE){
    echo "El usuario se proporciono exitosamente:)";
}
?>