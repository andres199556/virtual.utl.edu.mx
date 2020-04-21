<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
$estado = $_POST["val"];
$fecha_hora = date("Y-m-d H:i:s");
$resultado = array();
try{
    $activo = ($estado == 1 ? 0:1);
    $actualizar = $conexion->query("UPDATE periodos SET activo = $activo,
    fecha_hora = '$fecha_hora',
    id_usuario = $id_usuario_logueado
    WHERE id_periodo = $id
    ");
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "El estado se ha cambiado correctamente!.";
    if($estado == 1){
        $resultado["anterior"] = "btn-success";
        $resultado["nuevo"] = "btn-danger";
        $resultado["text"] = "Desactivado";
    }
    else{
        $resultado["nuevo"] = "btn-success";
        $resultado["anterior"] = "btn-danger";
        $resultado["text"] = "Activo";
    }
    $resultado["activo"] = $activo;
    
    
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>