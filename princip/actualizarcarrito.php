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