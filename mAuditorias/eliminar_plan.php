<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_GET["id"];
//valido que exista el plan
$buscar = $conexion->query("SELECT id_plan FROM planes_auditorias WHERE id_plan = $id");
$existe = $buscar->rowCount();
if($existe == 0){
    header("Location:index.php");
}
else{
    //solo cambio el estado, mas no elimino el plan
    $eliminar = $conexion->query("DELETE FROM planes_auditorias WHERE id_plan  =$id");
    header("Location:index.php?resultado=exito_eliminar_plan");
}
?>