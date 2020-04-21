<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_direccion = $_POST["id_direccion"];
$id_departamento  =$_POST["id_departamento"];
$id_proceso = $_POST["id_proceso"];
$id_tipo_documento = $_POST["id_tipo_documento"];
$id_responsable = $_POST["id_responsable"];
$codigo = $_POST["codigo"];
$titulo = $_POST["titulo"];
$vigencia = $_POST["fecha_vigencia"];
$version = $_POST["version"];
$comentarios = $_POST["comentarios"];
$fecha_hora = date("Y-m-d H:i:s");
$reutilizable = (isset($_POST["reutilizable"]) ? 1:0);
$activo = 1;
$documento = $_FILES["documento"];
try{
    if($reutilizable == 0){
        //el codigo no se puede repetir, lo busco
        $buscar_codigo = $conexion->query("SELECT id_documento FROM documentos WHERE codigo = '$codigo'");
        $existe = $buscar_codigo->rowCount();
        if($existe != 0){
            header("Location:alta.php?resultado=codigo_repetido");
        }
        else{
            goto insertar;
        }
        
    }
    
    else{
        goto insertar;
    }
    insertar:
    $insertar = $conexion->query("INSERT INTO documentos(
        id_tipo_documento,
        id_direccion,
        id_departamento,
        id_proceso,
        codigo,
        fecha_hora,
        activo,
        id_usuario,
        codigo_reutilizable
    )VALUES(
        $id_tipo_documento,
        $id_direccion,
        $id_departamento,
        $id_proceso,
        '$codigo',
        '$fecha_hora',
        $activo,
        $id_usuario_logueado,
        $reutilizable
    )");
    $id_documento = $conexion->lastInsertId();
    //agrego el detalle
    $file_string = generar_string(30);
    $tipo = $documento["type"];
    $tmp = $documento["tmp_name"];
    $size = $documento["size"];
    $name = $documento["name"];
    $extension = end(explode(".",$name));
    $file_path = "files/documents/$file_string";
    move_uploaded_file($tmp,"../".$file_path);
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
        $id_usuario_logueado,
        '$file_string',
        '$tipo',
        '$extension',
        '$file_path'
    )");
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    echo $error->getMessage();
}

?>