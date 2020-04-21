<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$ticket = $_POST["ticket"];
$id_usuario = $_POST["id_usuario_responsable"];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
try{
    $asignar = $conexion->prepare("UPDATE servicios SET id_usuario_responsable = $id_usuario,fecha = '$fecha',hora ='$hora' WHERE codigo_servicio = '$ticket'");
    $asignar->execute();
    if($asignar == true){
        //cambio el estado del servicio
        $update = $conexion->prepare("UPDATE servicios SET id_estado_servicio = 2 WHERE codigo_servicio = '$ticket'");
        $update->execute();
        //envio un correo con la asignación
    }
    header("Location:ticket.php?ticket=$ticket");
}
catch(PDOException $error){
    
}

?>