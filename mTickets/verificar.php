<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
include "../funciones/correos.php";
$ticket = $_POST["ticket"];
$resultado  =array();
$comentarios = $_POST["comentarios"];
if($comentarios == "" || $comentarios == null){
    $comentarios = "NA";
}
$fecha = date("Y-m-d");
$hora = date("H:i:s");
try{
    $verificar = $conexion->prepare("UPDATE servicios SET verificacion_aprobada = 1,id_estado_servicio = 8,comentarios_verificacion = '$comentarios',fecha = '$fecha',hora = '$hora' WHERE codigo_servicio = '$ticket'");
    $verificar->execute();
    $resultado["resultado"] = "exito_liberar";
}
catch(PDOException $error){
    echo $error->getMessage();
    $resultado["resultado"] = "error_liberar";
}

header("Content-type:application/json");
echo json_encode($resultado);
?>