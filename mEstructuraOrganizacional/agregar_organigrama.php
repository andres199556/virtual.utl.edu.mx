<?php

include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$nombre = $_POST["nombre_organigrama"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    $agregar = $conexion->query("INSERT INTO organigramas(nombre_organigrama,
    fecha_hora,
    activo,
    id_usuario)VALUES(
        '$nombre',
        '$fecha',
        $activo,
        $id_usuario_logueado
    )");


$id_organigrama = $conexion->lastInsertId();
    $resultado["resultado"] = "exito";
    $resultado["id"] = $id_organigrama;
    $resultado["nombre"] = $nombre;
    $resultado["mensaje"] = "El organigrama se ha creado correctamente!.";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}

echo json_encode($resultado);
?>