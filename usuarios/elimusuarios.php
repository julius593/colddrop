<?php
include_once '../conexion.php';
$idCI=$_GET['idCI'];
$sql="DELETE FROM usuarios WHERE CI=$CI";
if($conn->query($sql)===TRUE) {
    echo"nuevos usuarios eliminado exitosamente";
} else {
    echo"error:".$sql."<br>";
}




?>