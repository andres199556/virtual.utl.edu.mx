<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../clases/mail.php";
$id_accion  =$_POST["id_accion"];
$actividad = $_POST["actividad"];
$responsable = $_POST["responsable"];
$inicio  =$_POST["fecha_inicio"];
$cierre = $_POST["fecha_cierre"];
$descripcion = $_POST["descripcion"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    
    $agregar = $conexion->query("INSERT INTO actividades(
        id_accion,
        actividad,
        id_responsable,
        fecha_inicio,
        fecha_cierre,
        descripcion,
        fecha_hora,
        activo,
        id_usuario
    )VALUES(
        $id_accion,
        '$actividad',
        $responsable,
        '$inicio',
        '$cierre',
        '$descripcion',
        '$fecha',
        $activo,
        $id_usuario_logueado
    )");
    //agrego el log
    $log = "Se ha creado una nueva actividad para la acción correctiva con el N° $id_accion cuya actividad es: $actividad. Realizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
      id_accion,
      log,
      fecha_hora
      )VALUES(
      $id_accion,
      '$log',
      '$fecha'
      )");
    header("Location:accion.php?id=$id_accion&resultado=exito_actividad");
}
catch(PDOException $error){
    header("Location:accion.php?id=$id_accion&resultado=error_actividad");
}
?>