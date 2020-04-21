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
$id_auditoria = $_POST["id"];
$resultado = array();
try{
    ;
    $agregar = $conexion->query("UPDATE auditorias SET tipo = '$tipo',
    alcance = '$alcance',
    fecha_apertura = '$fecha_apertura',
    fecha_cierre = '$fecha_cierre',
    objetivo = '$objetivos',
    criterio = '$criterio',
    fecha_hora = '$fecha',
    activo = $activo,
    id_usuario = $id_usuario_logueado
    WHERE id_auditoria = $id_auditoria");
    header("Location:index.php?resultado=exito_actualizar");
}
catch(PDOException $error){
    header("Location:index.php?resultado=error_actualizar");
}
?>