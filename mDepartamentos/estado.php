<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
try{
    
    $id = $_GET["id"];
    $estado = $_GET["estado"];
    $fecha = date("Y-m-d H:i:s");
    $activo = ($estado == 1) ? 0:1;
    $update = $conexion->query("UPDATE departamentos SET activo = $activo,id_usuario = $id_usuario_logueado, WHERE id_departamento = $id");
    header("Location:index.php?resultado=exito_estado");
}
catch(Exception $error){
    echo $error->getMessage();
        header("Location:index.php?resultado=error_alta");
}
?>