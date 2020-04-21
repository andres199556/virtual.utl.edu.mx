<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$resultado = array();
$id = $_POST["id"];
try{
    $fecha = date("Y-m-d H:i:s");
$delete = $conexion->query("UPDATE indicadores SET activo = 0,fecha_hora = '$fecha',id_usuario  =$id_usuario_logueado WHERE id_indicador = $id");
$resultado["resultado"] = "exito";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
}
echo json_encode($resultado);
?>