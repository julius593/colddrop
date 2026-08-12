<?php
include_once '../conexion.php';
$idCodigo=$_GET['idCodigo'];
$sql="DELETE FROM PRODUCTOS WHERE idCodigo=$idCodigo";
if($conn->query($sql)===TRUE) {
    echo"nuevos productos eliminado exitosamente";
} else {
    echo"error:".$sql."<br>";
}




?>