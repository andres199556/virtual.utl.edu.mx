<?php
include "../conexion/conexion.php";
$id = $_GET["id"];
$estado = $_GET["estado"];
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = 1;
if($id == "" || $estado == "" || $id == null ||$estado == null){

}
else{
    //valido que exista
    $buscar = $conexion->query("SELECT id_producto
    FROM productos
    WHERE id_producto = $id");
    $existe = $buscar->rowCount();
    if($existe == 0){

    }
    else{
        try{
            $activo = ($estado == 1 ? 0:1);
            $actualizar = $conexion->query("UPDATE productos SET activo = $activo,
            fecha_hora = '$fecha_hora',
            id_usuario = $id_usuario
            WHERE id_producto = $id
            ");
            header("Location:index.php?resultado=exito_estado");
        }
        catch(PDOException $error){
            header("Location:index.php?resultado=error_estado");
        }
    }
}
?>