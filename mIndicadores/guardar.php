<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_direccion = $_POST["id_direccion"];
$id_departamento  =$_POST["id_departamento"];
$id_proceso = $_POST["id_proceso"];
$clave = $_POST["clave"];
$id_frecuencia = $_POST["id_frecuencia"];
$id_unidad = $_POST["id_unidad"];
$fecha_inicio = $_POST["fecha_inicio"];
$meta = $_POST["meta"];
$id_responsable = $_POST["id_responsable"];
$titulo = $_POST["titulo"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
try{
    
    $insertar = $conexion->query("INSERT INTO indicadores(
        id_direccion,
        id_departamento,
        id_proceso,
        clave,
        titulo,
        meta,
        id_unidad,
        id_frecuencia,
        id_responsable,
        fecha_inicio,
        fecha_hora,
        activo,
        id_usuario
    )VALUES(
        $id_direccion,
        $id_departamento,
        $id_proceso,
        '$clave',
        '$titulo',
        $meta,
        $id_unidad,
        $id_frecuencia,
        $id_responsable,
        '$fecha_inicio',
        '$fecha_hora',
        $activo,
        $id_usuario_logueado
    )");
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    echo $error->getMessage();
}

?>