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
