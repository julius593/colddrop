<?php 
include_once '../conexion.php';

$idPEDIDOS=$_POST['idPEDIDOS'];
$Nombre=$_POST['Nombre'];
$Fecha=$_POST['Fecha'];
$Estado=$_POST['Estado'];
$NombreVendedor=$_POST['NombreVendedor'];
$sql = "INSERT INTO pedidos (idPEDIDOS, Nombre, Fecha, Estado, NombreVendedor) VALUES('$idPEDIDOS','$Nombre','$Fecha', '$Estado','$NombreVendedor' )";

if($conn->query($sql) === TRUE){
    header("location:../princip/micarrito.php?idPEDIDOS=".$idPEDIDOS);
} else{
    echo"Error:". $sql. "<br>". $conn->error;
}
$conn->close();
?>
