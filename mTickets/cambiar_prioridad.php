<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
$ticket = $_POST["ticket"];
$prioridad = $_POST["prioridad"];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
try{
    $asignar = $conexion->prepare("UPDATE servicios SET prioridad = '$prioridad',fecha = '$fecha',hora ='$hora' WHERE codigo_servicio = '$ticket'");
    $asignar->execute();
    header("Location:ticket.php?ticket=$ticket");
}
catch(PDOException $error){
    
}

?>