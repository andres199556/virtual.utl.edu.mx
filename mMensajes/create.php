<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$integrantes = $_POST["integrantes"];
array_push($integrantes,$id_usuario_logueado);
sort($integrantes);
$resultado = array();
$name = $_POST["name_new"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$string_integrantes = implode(",",$integrantes);
$crear = $conexion->query("INSERT INTO conversaciones(
    nombre_conversacion,
    color,
    fecha_hora,
    imagen_conversacion,
    tipo_conversacion,
    array_integrantes,
    activo
)VALUES(
    '$name',
    '\#FF0000',
    '$fecha',
    'images/generales/conversation.jpg',
    'grupal',
    '$string_integrantes',
    $activo
)");
$id_conversacion = $conexion->lastInsertId();
//agrego los integrantes
foreach($integrantes as $id_integrante){
    //busco su nombre
    $persona = $conexion->query("SELECT CONCAT(P.nombre,' ',P.ap_paterno, ' ',P.ap_materno) as persona
    FROM personas as P
    INNER JOIN usuarios as U ON P.id_persona = U.id_persona
    WHERE U.id_usuario = $id_integrante");
    $row_d = $persona->fetch(PDO::FETCH_NUM);
    $nombre = $row_d[0];
    $agregar_integrante = $conexion->query("INSERT INTO integrantes_conversaciones(
        id_conversacion,
        id_usuario,
        apodo,
        fecha_hora,
        activo
    )VALUES(
        $id_conversacion,
        $id_integrante,
        '$nombre',
        '$fecha',
        $activo
    )");
}
//agrego el mensaje
$mensaje = $_SESSION["nombre_corto"]." ha creado la converasción.";

    $insert = $conexion->query("INSERT INTO mensajes(
        id_conversacion,
        id_usuario_remitente,
        tipo_mensaje,
        mensaje,
        fecha_hora,
        activo,
        acceso_mensaje
    )VALUES(
        $id_conversacion,
        0,
        'system',
        '$mensaje',
        '$fecha',
        1,
        '$string_integrantes'
    )");
$resultado["resultado"] = "exito";
$resultado["id"] = $id_conversacion;
$resultado["name"] = $name;
$resultado["type"] = "grupal";
echo json_encode($resultado);
?>