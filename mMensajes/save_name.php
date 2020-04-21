<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$resultado = array();
$id_conversacion  =$_POST["id_conversacion"];
$name = $_POST["name"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
try{
    $update = $conexion->query("UPDATE conversaciones
    SET nombre_conversacion = '$name',
    fecha_hora = '$fecha_hora'
    WHERE id_conversacion = $id_conversacion");
    $resultado["resultado"] = "exito";
    $resultado["nombre_conversacion"] = $name;
    //inserto el mensaje
    $mensaje = $_SESSION["nombre_corto"]." ha cambiado el nombre de la conversación a ".$name;
    $insert = $conexion->query("INSERT INTO mensajes(
        id_conversacion,
        id_usuario_remitente,
        tipo_mensaje,
        mensaje,
        fecha_hora,
        activo
    )VALUES(
        $id_conversacion,
        0,
        'system',
        '$mensaje',
        '$fecha_hora',
        0
    )");
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>