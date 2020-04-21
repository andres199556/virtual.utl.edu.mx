<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
$ticket = $_POST["ticket"];
$id_estado  =$_POST["id_estado"];
$comentarios = (isset($_POST["comentarios"]) ? $_POST["comentarios"]:"NA");
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$id_usuario = $_SESSION["id_usuario"];
$resultado = array();
try{
    $cambiar = $conexion->prepare("INSERT INTO historial_cambio_estados (
        ticket,
        id_estado,
        comentarios,
        fecha,
        hora,
        id_usuario
    )
    VALUES
        (
            '$ticket',
            $id_estado,
            '$comentarios',
            '$fecha',
            '$hora',
            $id_usuario
        )");
    $cambiar->execute();
    //cambiar el id del estado
    $actualizar = $conexion->prepare("UPDATE servicios SET id_estado_servicio = $id_estado,fecha = '$fecha',hora = '$hora',id_usuario = $id_usuario WHERE codigo_servicio = '$ticket'");
    $actualizar->execute();
    $resultado["resultado"] = "exito";
    $resultado["titulo"] = "Exito!";
    $resultado["mensaje"] = "El estado del ticket se cambio correctamente.!";
    $resultado["icon"] = "success";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["titulo"] = "Error!";
    $resultado["mensaje"] = "Ha ocurrido un error: ".$error->getMessage();
    $resultado["icon"] = "danger";
}
header("Content-type:application/json");
echo json_encode($resultado);
?>