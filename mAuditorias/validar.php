<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_accion  =$_GET["id"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    
    $update = $conexion->query("UPDATE detalle_acciones
    SET pendiente_validar = 0,
    validado = 1,
    fecha_hora = '$fecha',
    id_usuario = $id_usuario_logueado
    WHERE id_accion = $id_accion  AND pendiente_validar = 1 AND validado = 0");
    $log = "Se ha validado en análisis de la acción correctiva conl el n° $id a la fecha $fecha, autorizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
        id_accion,
        log,
        fecha_hora
        )VALUES(
        $id_accion,
        '$log',
        '$fecha'
        )");
    header("Location:accion.php?id=$id_accion&resultado=exito_validar");
}
catch(PDOException $error){
    header("Location:accion.php?id=$id_accion&resultado=error_validar");
}
?>