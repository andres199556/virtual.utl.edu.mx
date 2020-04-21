<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../clases/mail.php";
$id = $_POST["id"];
$comentarios = $_POST["comentarios_cierre_accion"];
$resultado  =$_POST["resultado_accion"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    //cierro la acción
    $update = $conexion->query("UPDATE detalle_acciones
    SET fecha_cierre = '$fecha',
    comentarios_cierre = '$comentarios',
    resultado = $resultado
    usuario_cerro = $id_usuario_logueado
    WHERE id_accion  =$id");

$update = $conexion->query("UPDATE acciones
SET id_estado = 5
WHERE id_accion  =$id");
    //busco el id de acion
    $buscar = $conexion->query("SELECT T.correo,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable
    FROM detalle_acciones as DA
    INNER JOIN usuarios as U ON DA.id_responsable = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    WHERE DA.id_accion = $id");
    $row_buscar = $buscar->fetch(PDO::FETCH_ASSOC);
    $responsable = $row_buscar["responsable"];
    $correo = $row_buscar["correo"];
    //inserto el log
    $log = "La acción correctiva con el N° $id_accion ha sido cerrada  a la fecha $fecha, realizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
        id_accion,
        log,
        fecha_hora
        )VALUES(
        $id,
        '$log',
        '$fecha'
        )");

        //envio el correo
        $asunto = "La acción ha sido cerrada";
        $cuerpo = "<p>El siguiente correo es para notificar que la acción correctiva con el  n° $id_accion ha sido liberada, los detalles son los siguientes: </p>
    <p><b>Acción n°</b>: $id_accion</p>
    <p><b>Estado:</b> Cerrada</p>
    <p><b>Comentarios:</b> $comentarios</p>
    <p>Atentamente: gestión de calidad.</p>";
    //envio el correo
    $mail = new correos($asunto,$correo,$responsable);
    $enviar_correo  =$mail->send_mail_plain($cuerpo);
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Acción cerrada correctamente!.";
    $resultado["fecha"] = $fecha;
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>