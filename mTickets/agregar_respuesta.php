<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/correos.php";
$array_resultado = array();
$no_evidencias = 0;
$ticket = $_POST["ticket"];
$respuesta = $_POST["respuesta"];
$evidencias = $_FILES["evidencias"];
$id_usuario_mensaje = $_SESSION["id_usuario"];
$notificar_respuesta = (isset($_POST["notificar_respuesta"]) ? 1:0);
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$activo = 1;
//agrego la respuesta
try{
    //busco que es el usuario que respondio, para saber a quien se lo contesto
    $buscar_datos = $conexion->prepare("SELECT

IF (
	S.id_usuario_responsable = 1,
	id_usuario_solicitante,
	id_usuario_solicitante
) AS id_usuario_respuesta,
 CONCAT(
	P.nombre,
	' ',
	P.ap_paterno,
	' ',
	P.ap_materno
) AS trabajador,
 T.correo
FROM
	servicios AS S
INNER JOIN usuarios AS U ON
IF (
	S.id_usuario_responsable = 1,
	id_usuario_solicitante,
	id_usuario_solicitante
) = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN trabajadores AS T ON P.id_persona = T.id_persona
WHERE
	S.codigo_servicio = '$ticket'");
    $buscar_datos->execute();
    $row_datos = $buscar_datos->fetch(PDO::FETCH_NUM);
    $id_usuario_correo = $row_datos[0];
    $nombre_usuario_correo = $row_datos[1];
    $correo_email = $row_datos[2];

    $add_respuesta = $conexion->prepare("INSERT INTO mensajes_tickets (
	mensaje,
    ticket,
	id_usuario,
	fecha,
	hora,
	activo
)
VALUES
	(
		'$respuesta',
        '$ticket',
		$id_usuario_mensaje,
		'$fecha',
		'$hora',
		$activo
	)");
    $add_respuesta->execute();
    $id_mensaje = $conexion->lastInsertId();
    //actualizo el estado
    $ticket_update = $conexion->prepare("UPDATE servicios SET id_estado_servicio = 5,fecha = '$fecha',hora = '$hora' WHERE codigo_servicio = '$ticket'");
    $ticket_update->execute();
    //verifico que se subieron
    if($evidencias["tmp_name"][0] == "" || $evidencias["tmp_name"][0] == null){
        //no existen evidencias
        $no_evidencias = 0;
    }
    else{
        //si existen
        //creo la carpeta
        if(!file_exists("evidencias/$ticket")){
            mkdir("evidencias/$ticket/");
            if(!file_exists("evidencias/$ticket/mensaje-$id_mensaje/")){
                //creo la carpeta
            }
            mkdir(("evidencias/$ticket/mensaje-$id_mensaje/"));
        }
        else{
            mkdir(("evidencias/$ticket/mensaje-$id_mensaje/"));
        }
        $cantidad = count($evidencias["name"]);
        for($i = 0;$i<$cantidad;$i++){
            $nombre_archivo = $evidencias["name"][$i];
            $ruta_temporal = $evidencias["tmp_name"][$i];
            $extension = end(explode(".",$nombre_archivo));
            $ruta_final = "evidencias/$ticket/mensaje-$id_mensaje/$nombre_archivo";
            $mover = move_uploaded_file($ruta_temporal,$ruta_final);
            if($mover == true){
                //agrego la evidnecias
                $add_evidencia = $conexion->prepare("INSERT INTO evidencias_tickets (
	ticket,
	id_mensaje,
	ruta_evidencia,
	nombre_evidencia,
	extension,
	fecha,
	hora,
	activo
)
VALUES
	(
		'$ticket',
		'$id_mensaje',
		'$ruta_final',
		'$nombre_archivo',
		'$extension',
		'$fecha_apertura',
		'$hora_apertura',
		1
	)");
                $add_evidencia->execute();
            }
        }
    }
    //busco evidencias
    if($notificar_respuesta == 1){
        $fecha_respuesta = "(".date("Y-m-d")." ".date("H:i:s").")";
        //envio correo
        $asunto = "[#$ticket] Haz recibido una nueva respuesta";
        $message = file_get_contents('../includes/template-email-respuesta.php'); 
        $message = str_replace('%testTituloCorreo%', "Recibiste una respuesta en el ticket $ticket", $message); 
        $message = str_replace('%nombre_usuario%', $nombre_usuario_correo, $message); 
        $message = str_replace('%fecha_respuesta%', $fecha_respuesta, $message); 
        $message = str_replace('%mensaje%', $respuesta, $message); 
        if($no_evidencias == 0){
            //se cargaron evidencias, muestro el texto
            $message = str_replace('%texto_archivos%'," ",$message);
        }
        else{
            $message = str_replace('%texto_archivos%',"La respuesta cuenta con archivos adjuntos, inicia sesión para ver el ticket completo.",$message);
        }
        $message = str_replace('%testEnlaceTicket%', "http://localhost:50/sicoin.utl.edu.mx/mSolicitudServicio/ticket.php?ticket=$ticket", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico.", $message); 
        $message = str_replace('%testTextoUnderTitulo%', "Haz recibido una nueva respuesta en el ticket con el código $ticket", $message); 
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado = enviar_correo($message,$correo_email,$nombre_usuario_correo,$asunto);
    }
    else{
        //no envio nada
    }
    $array_resultado["titulo"] = "Exito!";
    $array_resultado["resultado"] = "exito";
    $array_resultado["mensaje"] = "Respuesta agregada correctamente";
    $array_resultado["tipo"] = "success";
    $array_resultado["color"] = "#1E8449";
    $array_resultado["id"] = $id_mensaje;

}
catch(PDOException $error){
    $array_resultado["titulo"] = "Error";
    $array_resultado["resultado"] = "error";
    $array_resultado["mensaje"] = "Error, vuelve a intentarlo mas tarde";
    $array_resultado["tipo"] = "danger";
    $array_resultado["color"] = "#A93226";
}
header("Content-type:application/json");
echo json_encode($array_resultado);
?>