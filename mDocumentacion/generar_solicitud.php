<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$fecha  =date("Y-m-d H:i:s");
$activo = 1;
$estado = 0; //pendiente de validar
$id_tipo_solicitud = $_POST["id_tipo_solicitud"];
$folio = generar_random(10);
echo "<pre>";
print_r($_POST);
print_r($_FILES);
try{
    switch($id_tipo_solicitud){
        case 2:
        //se va a borrar
        $documento  =$_POST["documento"];
        $comentarios  =$_POST["comentarios"];
        //genero la solicitud
        $agregar = $conexion->query("INSERT INTO solicitudes_documentos(
            id_tipo_solicitud,
            id_documento,
            comentarios,
            id_usuario_solicitante,
            fecha_hora,
            activo,
            estado_solicitud,
            id_usuario,
            folio_solicitud
        )VALUES(
            $id_tipo_solicitud,
            $documento,
            '$comentarios',
            $id_usuario_logueado,
            '$fecha',
            $activo,
            $estado,
            $id_usuario_logueado,
            '$folio'
        )");
        break;
        case 1:
            //se va a dar de alta un nuevo documento
            $version  =$_POST["version"];
            $id_tipo_documento  =$_POST["id_tipo_documento"];
            $id_responsable = $_POST["id_responsable"];
            $codigo = $_POST["codigo"];
            $titulo = $_POST["titulo"];
            $fecha_vigencia = $_POST["fecha_vigencia"];
            $comentarios = $_POST["comentarios"];
            $insertar = $conexion->query("INSERT INTO solicitudes_documentos(
                id_tipo_solicitud,
                id_tipo_documento,
                codigo,
                titulo_documento,
                version,
                fecha_vigencia,
                id_usuario_solicitante,
                id_usuario,
                fecha_hora,
                estado_solicitud,
                folio_solicitud,
                activo,
                comentarios
            )VALUES(
                $id_tipo_solicitud,
                $id_tipo_documento,
                '$codigo',
                '$titulo',
                $version,
                '$fecha_vigencia',
                $id_usuario_logueado,
                $id_usuario_logueado,
                '$fecha',
                $estado,
                '$folio',
                1,
                '$comentarios'
            )");
            $id_solicitud = $conexion->lastInsertId();
            //inserto el documento
            $path = "../files/solicitud_documentos/";
            $documento  =$_FILES["documento"];
            $name = $documento["name"];
            $tmp = $documento["tmp_name"];
            $size = $documento["size"];
            $type = $documento["type"];
            $file = generar_string(50);
            move_uploaded_file($tmp,$path.$file);
            //inserto el documento
            $insert = $conexion->query("INSERT INTO documentos_solicitudes(
                id_solicitud_documento,
                name,
                type,
                size,
                fecha_hora,
                activo,
                id_usuario,
                file
            )VALUES(
                $id_solicitud,
                '$name',
                '$type',
                $size,
                '$fecha',
                1,
                $id_usuario_logueado,
                '$file'
            )");
            header("Location:control_documentos.php?resultado=exito_alta_solicitud");
        break;
        case 3:
            //se va a generar una nueva revisión
        break;
        header("Location:control_documentos.php?resultado=exito_alta");
    }
}
catch(Exception $error){
    echo $error->getMessage();
}
?>