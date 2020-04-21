<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$direccion  =$_POST["id_direccion"];
$tipo_accion = $_POST["origen"];
$numero  =$_POST["numero"];
$fecha_creacion = $_POST["fecha_creacion"];
$descripcion = $_POST["descripcion"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    
    $agregar = $conexion->query("INSERT INTO acciones(
        id_direccion,
        id_tipo_accion,
        numero,
        fecha_alta,
        descripcion,
        fecha_hora,
        activo,
        id_usuario,
        id_estado
    )VALUES(
        $direccion,
        $tipo_accion,
        '$numero',
        '$fecha_creacion',
        '$descripcion',
        '$fecha',
        $activo,
        $id_usuario_logueado,
        1
    )");
    $id_accion = $conexion->lastInsertId();
    //agrego el log
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
    id_accion,
    log,
    fecha_hora
    )VALUES(
    $id_accion,
    'La acción con el n° $id_accion ha sido creada',
    '$fecha'
    )");
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    header("Location:index.php?resultado=error_alta");
}
?>