<?php
include_once '../conexion.php';
$idCARRITO=$_GET['idCARRITO'];
$sql="SELECT * FROM CARRITO WHERE idCARRITO=$idCARRITO";
$resultado=$conexion->query($sql);
if($resultado->num_rows>0){
        while($fila=$resultado->fetch_assoc()){
          $ID_Producto=$fila['ID_Producto'];
          $ID_Pedido=$fila['ID_Pedido'];
          $Cantidad=$fila['Cantidad'];
          $CostoTotal =$fila['CostoTotal '];

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
    <form action="casaactualizarcarrito.php" method="post">
<h2>CARRITO</h2>
<label for="">ID de CARRITO</label>
<input type="number" name="idCARRITO" value='<?=$idCARRITO?>'>
<label for="">ID_Producto</label>
<input type="text" name="ID_Producto" value='<?=$ID_Producto?>'> 

<label for="">ID_Pedido</label>
<input type="text" name="ID_Pedido" value='<?=$ID_Pedido?>'>

<label for="">Cantidad</label>
<input type="number" name="Cantidad" value='<?=$Cantidad?>'>

<label for="">CostoTotal </label>
<input type="text" name="CostoTotal " value='<?=$CostoTotal ?>'>
<input type="submit" >
    </form>
    
</body>
</html>
