<?php
include_once '../conexion.php';
$idPEDIDOS=$_POST['idPEDIDOS'];
$Nombre=$_POST['Nombre'];
$Fecha=$_POST['Fecha'];
$Estado=$_POST['Estado'];
$NombreVendedor=$_POST['NombreVendedor'];

$sql="UPDATE PEDIDOS SET Nombre='$Nombre',Fecha='$Fecha',Estado='$Estado',NombreVendedor='$NombreVendedor' WHERE idPEDIDOS=$idPEDIDOS ";
if($conexion->query($sql)=== TRUE){
    echo "El pedido se proporciono exitosamente:)";
}
?>