<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$periodo  =$_POST["periodo"];
$fecha_inicio = $_POST["fecha_inicio"];
$fecha_cierre = $_POST["fecha_cierre"];
$descripcion = $_POST["descripcion"];
$activo = 1;
$resultado = array();
$fecha_hora = date("Y-m-d H:i:S");
try{
    $insert = $conexion->query("INSERT INTO periodos(
        periodo,
        fecha_inicio,
        fecha_cierre,
        descripcion,
        fecha_hora,
        activo,
        id_usuario
    )VALUES(
        '$periodo',
        '$fecha_inicio',
        '$fecha_cierre',
        '$descripcion',
        '$fecha_hora',
        $activo,
        $id_usuario_logueado
    )");
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Periodo agregado correctamente!.";
}
catch(Exception $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>