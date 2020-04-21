<?php
include "../conexion/conexion.php";
print_r($_POST);
$id_producto = $_POST["id_p_imagen"];
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = 1;
$imagen = $_FILES["nueva_imagen"];
$tmp = $imagen["tmp_name"];
$nombre = $imagen["name"];
$extension = end(explode(".",$nombre));
$ruta_imagen = "../images/productos/$id_producto.$extension";
try{
    //muevo la imagen
    move_uploaded_file($tmp,$ruta_imagen);
    $actualizar = $conexion->query("UPDATE productos SET
    imagen_producto = '$ruta_imagen',
    fecha_hora = '$fecha_hora',
    id_usuario = $id_usuario
    WHERE id_producto = $id_producto
    ");
    header("Location:index.php?resultado=exito_imagen");
}
catch(Exception $error){
    echo $error->getMessage();
}
?>