<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$fecha = $_POST["date"];
$id = $_POST["id"];
$fecha_hora = date("Y-m-d H:i:s");
$resultado  =array();
try{
    $update = $conexion->query("UPDATE detalle_acciones
    SET fecha_vencimiento = '$fecha',
    fecha_hora = '$fecha_hora'
    WHERE id_accion = $id");
    //agrego el log
    $log = "Se ha actualizado la fecha de vencimiento de la acción correctiva conl el n° $id a la fecha $fecha, autorizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
        id_accion,
        log,
        fecha_hora
        )VALUES(
        $id,
        '$log',
        '$fecha_hora'
        )");
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Se ha actualizado la fecha correctamente!.";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>