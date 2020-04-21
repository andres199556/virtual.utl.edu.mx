<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_node = $_POST["id"];
$resultado = array();
try{
    $buscar = $conexion->query("SELECT id_trabajador,id_puesto,color,comentarios FROM nodos_organigramas WHERE id_nodo = $id_node");
    $row_datos = $buscar->fetch(PDO::FETCH_ASSOC);
    $resultado["resultado"] = "exito";
    $resultado["data"] = $row_datos;
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>