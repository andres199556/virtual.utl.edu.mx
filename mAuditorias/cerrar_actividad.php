<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_actividad = $_POST["id_actividad"];
$id_accion = $_POST["action_id"];
$comentarios = $_POST["comentarios_cierre"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$evidencias = $_FILES["evidencias"];
try{
    //actualizo la actividad
    $update = $conexion->query("UPDATE actividades SET comentarios_cierre = '$comentarios',
    activo = 2,
    fecha_hora = '$fecha_hora'
    WHERE id_actividad = $id_actividad");
    //subo las evidencias
    //print_r($evidencias);
    $cantidad = count($evidencias["name"]);
    for($i = 0;$i<$cantidad;$i++){
        $name = $evidencias["name"][$i];
        $tmp = $evidencias["tmp_name"][$i];
        $type = $evidencias["type"][$i];
        $size = $evidencias["size"][$i];
        $file_string = generar_string(30);
        $extension = end(explode(".",$name));
        $file_path = "files/evidencias_actividades/$file_string";
        move_uploaded_file($tmp,"../".$file_path);
        //agrego el registro
        $insert_evidencia = $conexion->query("INSERT INTO evidencias_actividades(
            id_accion,
            id_actividad,
            name,
            filepath,
            file_string,
            file_type,
            file_size,
            extension,
            fecha_hora,
            activo
        )VALUES(
            $id_accion,
            $id_actividad,
            '$name',
            '$file_path',
            '$file_string',
            '$type',
            '$size',
            '$extension',
            '$fecha_hora',
            $activo
        )");
    }
    //inserto el log de actividad
    $log = "La actividad con el id #$id_actividad de la acción N° $id_accion ha sido cerrada por ".$_SESSION["nombre_persona"]." quedando pendiente de verificar por parte del verificador de la acción";
        $insert_log = $conexion->query("INSERT INTO historial_acciones(
    id_accion,
    log,
    fecha_hora
    )VALUES(
    $id_accion,
    '$log',
    '$fecha'
    )");
}
catch(PDOException $error){
    print_r($_POST);
    echo $error->getMessage();
}
?>