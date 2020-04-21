<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$resultado = array();
$ticket = $_POST["ticket"];
$id_tipo_servicio = $_POST["id_tipo_servicio"];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
try{
    $asignar = $conexion->prepare("UPDATE servicios SET id_tipo_servicio = $id_tipo_servicio,fecha = '$fecha',hora ='$hora' WHERE codigo_servicio = '$ticket'");
    $asignar->execute();
    //busco el nombre
    $buscar = $conexion->prepare("SELECT tipo_servicio FROM tipo_servicios WHERE id_tipo_servicio = $id_tipo_servicio");
    $buscar->execute();
    $row_b = $buscar->fetch(PDO::FETCH_NUM);
    $tipo_servicio = $row_b[0];
    $resultado["resultado"] = "exito";
    $resultado["titulo"] = "Exito!";
    $resultado["icon"] = "info";
    $resultado["tipo_servicio"] = $tipo_servicio;
    $resultado["mensaje"] = "Los cambios se han guardado correctamente!";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["titulo"] = "Error!";
    $resultado["icon"] = "danger";
    $resultado["mensaje"] = "Ha ocurrido un error, vuelve a intentarlo mas tarde!";
}
header("content-type:application/json");
echo json_encode($resultado);
?>