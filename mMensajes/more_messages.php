<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_conversacion = $_POST["id_conversacion"];
$array_messages = $_POST["messages"];
$mensajes = implode(",",$array_messages);
$resultado = array();
//busco los ultimos 5 mensajes de la conversacion
$buscar_mensajes = $conexion->query("SELECT
M.id_mensaje,
M.mensaje,
IC.apodo,
M.fecha_hora,
M.acceso_mensaje,
IF(M.id_usuario_remitente = $id_usuario_logueado,'inverse','normal') as class,
(
    SELECT
        COUNT(VM.visto_web)
    FROM
        vistos_mensajes AS VM
    WHERE
        VM.id_mensaje = M.id_mensaje
    AND VM.id_conversacion = $id_conversacion
    AND VM.id_usuario = $id_usuario_logueado
) AS visto,
(
    SELECT
        COUNT(VM.visto_app)
    FROM
        vistos_mensajes AS VM
    WHERE
        VM.id_mensaje = M.id_mensaje
    AND VM.id_conversacion = $id_conversacion
    AND VM.id_usuario = $id_usuario_logueado
) AS visto_app
FROM
mensajes AS M
INNER JOIN integrantes_conversaciones AS IC ON M.id_usuario_remitente = IC.id_usuario
INNER JOIN usuarios AS U ON IC.id_usuario = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
WHERE
M.id_conversacion = $id_conversacion
AND (
    M.acceso_mensaje LIKE '$id_usuario_logueado,%'
    OR M.acceso_mensaje LIKE '%,$id_usuario_logueado'
    OR M.acceso_mensaje LIKE '%,$id_usuario_logueado,%'
) AND M.id_mensaje NOT IN($mensajes)
ORDER BY
M.fecha_hora DESC
LIMIT 5");
$cantidad = $buscar_mensajes->rowCount();
$resultado["resultado"] = "exito";
$resultado["cantidad"] = $cantidad;
$resultado["id_conversacion"] =$id_conversacion;
if($cantidad == 0){
    //no tiene mensajes   
}
else{
    while($row_m = $buscar_mensajes->fetch(PDO::FETCH_NUM)){
        $resultado["mensajes"][] = $row_m;
    }
}
echo json_encode($resultado);
?>