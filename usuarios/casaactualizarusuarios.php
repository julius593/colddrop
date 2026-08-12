<?php 
include_once '../conexion.php';

$CI=$_POST['CI'];
$Nombre=$_POST['Nombre'];
$Apellido=$_POST['Apellido'];
$Usuario=$_POST['Usuario'];
$Contrasena=$_POST['Contrasena'];
$Direccion=$_POST['Direccion'];
$Celular=$_POST['Celular'];
$Rol=$_POST['Rol'];
$Estado=$_POST['Estado'];
$sql = "INSERT INTO usuarios (CI,Nombre, Apellido, Usuario, Contrasena, Direccion, Celular, Rol, Estado ) VALUES('$CI','$Nombre','$Apellido','$Usuario','$Contrasena','$Direccion','$Celular', '$Rol','$Estado' )";

if($conn->query($sql) === TRUE){
    echo"Nuevo usuario creado exitosamente";
} else{
    echo"Error:". $sql. "<br>". $conn->error;
    
}
$conn->close();
?>
