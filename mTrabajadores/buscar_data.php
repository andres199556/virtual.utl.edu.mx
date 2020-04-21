<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
$resultado = array();
try{
    $data = $conexion->query("SELECT periodo,fecha_inicio,fecha_cierre,descripcion FROM periodos WHERE id_periodo = $id");
    $row_datos = $data->fetch(PDO::FETCH_ASSOC);
    $resultado["data"] = $row_datos;
    $resultado["resultado"] = "exito";
}
catch(Exception $error){
    $resultado["resultado"] = "error";
}
echo json_encode($resultado);
?>