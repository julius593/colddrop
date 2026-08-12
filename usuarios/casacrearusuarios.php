<?php
include_once '../conexion.php';
$CI=$_GET['idCI'];
$sql="SELECT * FROM usuarios WHERE CI=$CI";

$resultado=$conexion-> query($sql);
if($resultado->num_rows>0){
 while($fila=$resultado->fetch_assoc()){
   echo $fila['CI']."".$fila['Nombre']."".$fila['Direccion']."".$fila['Celular']." ".$fila['Rol']." ".$fila['Estado']." ".$fila['CI']." ";
   $CI=$fila['CI'];

 }

}

?>
