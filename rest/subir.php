<?php
include "../conexion/conexion.php";
$distancia = $_GET["distancia"];
//agrego
$fecha = date("Y-m-d H:i:s");
$agregar = $conexion->query("INSERT INTO arduino(distancia,fecha_hora,mensaje)VALUES('$distancia','$fecha','Se ha detectado un objeto a una distancia de: $distancia cm')");

?>