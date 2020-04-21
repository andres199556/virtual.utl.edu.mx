<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_node = $_POST["id_node"];
$resultado = array();
try{
    $delete = $conexion->query("DELETE FROM nodos_organigramas WHERE id_nodo = $id_node");
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Nodo eliminado correctamente!";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>