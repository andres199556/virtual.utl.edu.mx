<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_detalle = $_POST["id_detalle"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$mes = $_POST["mes"];
$anio = $_POST["anio"];
$resultado = $_POST["resultado"];
$comentarios = $_POST["comentarios"];
$id_indicador = $_POST["id"];
if($id_detalle == 0){
    //no existe, por lo tanto lo creo
    $agregar = $conexion->query("INSERT INTO detalle_indicadores(
        id_indicador,
        anio,
        mes,
        valor,
        comentarios,
        fecha_hora,
        activo,
        id_usuario
    )VALUES(
        $id_indicador,
        $anio,
        $mes,
        $resultado,
        '$comentarios',
        '$fecha',
        $activo,
        $id_usuario_logueado
    )");
}
else{
    $actualizar = $conexion->query("UPDATE detalle_indicadores
    SET valor = $resultado,
    comentarios = '$comentarios',
    fecha_hora = '$fecha',
    id_usuario = $id_usuario_logueado
    WHERE id_indicador = $id_indicador AND id_valor = $id_detalle
    ");
}
header("Location:indicador.php?id=$id_indicador");
?>