<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../sesion/validar_sesion.php";
$id_documento = $_POST["id_documento"];
$id_responsable = $_POST["id_responsable"];
$titulo = $_POST["titulo"];
$vigencia = $_POST["fecha_vigencia"];
$version = $_POST["version"];
$comentarios = $_POST["comentarios"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_usuario = 1;
$documento = $_FILES["documento"];
try{
    //agrego el detalle
    $file_string = generar_string(30);
    $tipo = $documento["type"];
    $tmp = $documento["tmp_name"];
    $size = $documento["size"];
    $name = $documento["name"];
    $extension = end(explode(".",$name));
    $file_path = "files/documents/$file_string";
    move_uploaded_file($tmp,"../".$file_path);
    //primero actualizo a 0 los activos
    $desactivar = $conexion->query("UPDATE detalle_documentos SET activo = 0,fecha_hora = '$fecha_hora' WHERE id_documento = $id_documento");
    $agregar = $conexion->query("INSERT INTO detalle_documentos(
        id_documento,
        titulo,
        version,
        id_responsable,
        nombre_archivo,
        comentarios,
        fecha_vigencia,
        fecha_hora,
        activo,
        id_usuario,
        file_string,
        tipo_documento,
        extension,
        filepath
    )VALUES(
        $id_documento,
        '$titulo',
        $version,
        $id_responsable,
        '$titulo',
        '$comentarios',
        '$vigencia',
        '$fecha_hora',
        $activo,
        $id_usuario,
        '$file_string',
        '$tipo',
        '$extension',
        '$file_path'
    )");
    header("Location:index.php?resultado=exito_version");
}
catch(PDOException $error){
    echo $error->getMessage();
}

?>