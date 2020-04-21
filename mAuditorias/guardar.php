<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$tipo = $_POST["tipo_auditoria"];
$alcance = $_POST["alcance"];
$fecha_apertura = $_POST["fecha_apertura"];
$fecha_cierre = $_POST["fecha_cierre"];
$objetivos = $_POST["objetivo"];
$criterio  =$_POST["criterio"];
$fecha = date("Y-m-d H:i:s");
$folio_auditoria = generar_string(15);
$activo = 1;
$resultado = array();
try{
    
    $agregar = $conexion->query("INSERT INTO auditorias(
        tipo,
        alcance,
        fecha_apertura,
        fecha_cierre,
        objetivo,
        criterio,
        fecha_hora,
        activo,
        id_usuario,
        folio_auditoria
    )VALUES(
        '$tipo',
        '$alcance',
        '$fecha_apertura',
        '$fecha_cierre',
        '$objetivos',
        '$criterio',
        '$fecha',
        $activo,
        $id_usuario_logueado,
        '$folio_auditoria'
    )");
    $id_auditoria = $conexion->lastInsertId();
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    header("Location:index.php?resultado=error_alta");
}
?>