<?php
include_once '../conexion.php';
$idPEDIDOS=$_GET['idPEDIDOS'];
$sql="SELECT * FROM PEDIDOS WHERE idPEDIDOS=$idPEDIDOS";
$resultado=$conexion->query($sql);
if($resultado->num_rows>0){
        while($fila=$resultado->fetch_assoc()){
          $Nombre=$fila['Nombre'];
          $Fecha=$fila['Fecha'];
          $Estado=$fila['Estado'];
          $NombreVendedor=$fila['NombreVendedor'];

}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como hacer un CRUD</title>
</head>
<body>
    <form action="casaactualizarpedidos.php" method="post">
<h2>PEDIDOS</h2>

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