<?php
include "../conexion/conexion.php";
include "../funciones/correos.php";
$resultado_array = array();
$ticket = $_POST["ticket"];
$id_mensaje = $_POST["id_respuesta"];
//$ticket = "7PD-ZTS-71N3";
$id_usuario = $_POST["id_usuario"];
$servidor = "http://128.100.0.1:50/helpdesk";
//$id_usuario = 1;
//busco el nombre y el correo
//busco el mensaje y el id de usuario
$datos_mensaje = $conexion->prepare("SELECT
	MT.mensaje,
	MT.fecha,
	MT.hora,
	CONCAT(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS usuario,
    T.correo,
	(
		SELECT
			COUNT(ET.id_evidencia)
		FROM
			evidencias_tickets AS ET
		WHERE
			ET.id_mensaje = MT.id_mensaje
	) AS evidencias
FROM
	mensajes_tickets AS MT
INNER JOIN usuarios AS U ON MT.id_usuario = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN trabajadores AS T ON P.id_persona = T.id_persona
WHERE
	MT.id_mensaje = $id_mensaje");
$datos_mensaje->execute();
$row_datos = $datos_mensaje->fetch(PDO::FETCH_NUM);
$correo = $row_datos[4];
$nombre_usuario = $row_datos[3];
$fecha = $row_datos[1];
$hora = $row_datos[2];
$mensaje = $row_datos[0];
$evidencias = $row_datos[6];
if($evidencias == 0){
    $texto_evidencias = "";
}
else{
    $texto_evidencias = "El mensaje cuenta con archivos adjuntos.";
}
$fecha_respuesta = "(".$fecha." - ".$hora.")";
$asunto = "[#$ticket] Un usuario ha respondido el ticket.";
$message = file_get_contents('../includes/template-email-respuesta.php'); 
$message = str_replace('%testTituloCorreo%', "Recibiste una respuesta en el ticket $ticket", $message); 
$message = str_replace('%nombre_usuario%', $nombre_usuario, $message); 
$message = str_replace('%correo_usuario%', $correo, $message); 
$message = str_replace('%mensaje%', $mensaje, $message); 
$message = str_replace('%texto_archivos%', $texto_evidencias, $message); 
$message = str_replace('%fecha_respuesta%', $fecha_respuesta, $message); 
$message = str_replace('%testEnlaceTicket%', "$servidor/mSolicitudServicio/ticket.php?ticket=$ticket", $message); 
$message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico", $message); 
$message = str_replace('%testTextoUnderTitulo%', "Haz recibido una nueva respuesta en el ticket con el código $ticket", $message); 
try{
    $resultado = enviar_correo($message,$correo,$nombre_usuario,$asunto);
    $resultado_array["resultado"] = "exito";
    $resultado_array["titulo"] = "Exito!";
    $resultado_array["icon"] = "info";
    $resultado_array["mensaje"] = "Se ha enviado una notificación por correo al usuario!";
    if($resultado == true){
        
    }
    else{
        
    }
}
catch(PDOException $error){
    $resultado_array["resultado"] = "error";
    $resultado_array["titulo"] = "Error!";
    $resultado_array["icon"] = "danger";
    $resultado_array["mensaje"] = $error->getMessage();
}

header("Content-type:application/json");
echo json_encode($resultado_array);
?>