<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../clases/mail.php";
$id = $_POST["id"];
$motivo = $_POST["motivo"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    //busco el id de acion
    $buscar = $conexion->query("SELECT AC.id_accion,AC.actividad,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable,T.correo
    FROM actividades as AC
    INNER JOIN usuarios as U ON AC.id_responsable = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    WHERE AC.id_actividad = $id");
    $row_buscar = $buscar->fetch(PDO::FETCH_ASSOC);
    $id_accion = $row_buscar["id_accion"];
    $actividad = $row_buscar["actividad"];
    $responsable = $row_buscar["responsable"];
    $correo = $row_buscar["correo"];
    $update = $conexion->query("UPDATE actividades
    SET activo = 3,
    motivo_rechazo = '$motivo',
    fecha_rechazo = '$fecha',
    usuario_rechazo = $id_usuario_logueado
    WHERE id_actividad = $id");
    //inserto el log
    $log = "Se ha rechazado la actividad con el N° $id de la acción correctiva N° $id_accion a la fecha $fecha, realizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
        id_accion,
        log,
        fecha_hora
        )VALUES(
        $id_accion,
        '$log',
        '$fecha'
        )");

        //envio el correo
        $asunto = "La actividad ha sido rechazada";
        $cuerpo = "<p>El siguiente correo es para notificar que la actividad llamada \"$actividad\" dentro de la acción correctiva N° $id_accion ha sido rechazada, los detalles son los siguientes: </p>
    <p><b>Acción n°</b>: $id_accion</p>
    <p><b>Actividad:</b> $actividad</p>
    <p><b>Estado:</b> Rechazada</p>
    <p><b>Motivo:</b> $motivo</p>
    <p>Atentamente: gestión de calidad.</p>";
    //envio el correo
    $mail = new correos($asunto,$correo,$responsable);
    $enviar_correo  =$mail->send_mail_plain($cuerpo);
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Actividad rechazada correctamente!.";
    $resultado["fecha"] = $fecha;
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>