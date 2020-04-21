<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_organigrama = $_POST["id"];
$resultado = array();
try{
    $delete = $conexion->query("DELETE FROM organigramas WHERE id_organigrama = $id_organigrama");
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Organigrama eliminado correctamente!";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>