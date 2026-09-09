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
<label for="">ID de PEDIDOS</label>
<input type="number" name="idPEDIDOS" value='<?=$idPEDIDOS?>'>
<label for="">Nombre</label>
<input type="text" name="Nombre" value='<?=$Nombre?>'> 

<label for="">Fecha</label>
<input type="text" name="Fecha" value='<?=$Fecha?>'>

<label for="">Estado</label>
<input type="number" name="Estado" value='<?=$Estado?>'>

<label for="">NombreVendedor</label>
<input type="text" name="NombreVendedor" value='<?=$NombreVendedor?>'>

<input type="submit" >
    </form>
    
</body>
</html>
