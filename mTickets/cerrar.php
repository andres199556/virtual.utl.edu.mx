<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/correos.php";
$url = "http://localhost:50/sicoin.utl.edu.mx/";
$ticket = $_POST["ticket"];
$respuesta_cierre = $_POST["respuesta_cierre"];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$activo = 1;
$id_usuario = $_SESSION["id_usuario"];
$verificar_cierre = (isset($_POST["verificar_cierre"])? 1:0);
$notificar_cierre = (isset($_POST["notificar_cierre"])? 1:0);
echo "<pre>";
$evidencias = $_FILES["evidencias"];
//primero agrego la respuesta de cierre
try{
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
		'$respuesta_cierre',
        '$ticket',
		$id_usuario,
		'$fecha',
		'$hora',
		$activo
	)");
    $add_respuesta->execute();
    $id_respuesta = $conexion->lastInsertId();
    //actualizo el estado
    if($verificar_cierre == 1){
        //voy a esperar verificación
        $id_estado_servicio = 6;
    }
    else{
        $id_estado_servicio = 8;
    }
    $ticket_update = $conexion->prepare("UPDATE servicios 
    SET id_estado_servicio = $id_estado_servicio,fecha_liberacion = '$fecha',hora_liberacion = '$hora',
    id_usuario_liberacion = $id_usuario
    WHERE codigo_servicio = '$ticket'");
    $ticket_update->execute();
    //verifico que se subieron
    if($evidencias["tmp_name"][0] == "" || $evidencias["tmp_name"][0] == null){
        //no existen evidencias
        if($notificar_cierre == 1){
            goto notificar;
        }
        else{
            header("Location:index.php?resultado=exito_liberar");
        }
        
    }
    else{
        //si se subio evidencia
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
		'$id_respuesta',
		'$ruta_final',
		'$nombre_archivo',
		'$extension',
		'$fecha',
		'$hora',
		1
	)");
                $add_evidencia->execute();
            }
        }
        if($notificar_cierre == 1){
            goto notificar;
        }
        else{
            header("Location:index.php?resultado=exito_liberar");
        }
        
        notificar:
            //busco los datos del solicitante
            $datos_solicitante = $conexion->prepare("SELECT
	S.id_servicio,
	S.codigo_servicio,
	CONCAT(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS solicitante,
	T.correo
FROM
	servicios AS S
INNER JOIN usuarios AS U ON S.id_usuario_solicitante = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN trabajadores AS T ON P.id_persona = T.id_persona
WHERE
	S.codigo_servicio = '$ticket'");
        $datos_solicitante->execute();
        $row_datos = $datos_solicitante->fetch(PDO::FETCH_NUM);
        $id_servicio = $row_datos[0];
        $solicitante = $row_datos[2];
        $correo_solicitante = $row_datos[3];
        //envio correo
        $asunto = "[#$ticket] El ticket ha sido liberado";
        if($verificar_cierre == 1){
            $titulo = "El ticket #$ticket Ha sido liberado por el responsable";
            $texto = "Sin embargo, requiere tu verificación parar cerrar el servicio correctmante, si estas conforme con el servicio, realiza la verificación del mismo.";
        }
        else{
                $titulo = "El ticket #$ticket ha sido liberado por el responsable.";
                $texto = "El responsable del servicio ha liberado el ticket correctamente, haz clic en el enlace para ver las acciones realizadas.";
        }
        $message = file_get_contents('../includes/template-mail-cerrar.php'); 
        $message = str_replace('%testTituloCorreo%', $titulo, $message); 
        $message = str_replace('%testTextoUnderTitulo%', $texto, $message); 
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
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado = enviar_correo($message,$correo_solicitante,$solicitante,$asunto);
        if($resultado == true){
            //se envio
            header("Location:index.php?resultado=exito_cerrar");
        }
        else{
            //no se envio
            header("Location:index.php?resultado=exito_cerrar2");
        }
        
    }
    
}
catch(Exception $error){
    echo $error->getMessage();
}
?>