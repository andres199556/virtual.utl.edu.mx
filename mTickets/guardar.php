<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
include "../funciones/correos.php";
$url = "http://localhost:50/sicoin.utl.edu.mx/";
$correo_soporte = "soporte@utl.edu.mx";
#id_usuario_solicitante = el usuario logueado
if($permiso_acceso == 1){
    $id_usuario_mensaje = $_POST["id_usuario_solicitante"];
    $id_usuario_solicitante = $_POST["id_usuario_solicitante"];
}
else{
    $id_usuario_mensaje = $_SESSION["id_usuario"];
    $id_usuario_solicitante = $_SESSION["id_usuario"];
}
#el tipo de servicio se asigna despues por el administrador

$titulo =$_POST["titulo"];
$fecha_apertura = date("Y-m-d");
$hora_apertura = date("H:i:s");
$mensaje = $_POST["descripcion"];
$id_responsable = 0;
$enviar_correo = (isset($_POST["enviar_correo"]) ? 1:0);
$mostrar_ticket = (isset($_POST["mostrar_ticket"]) ? 1:0);
$numero_ticket = generar_ticket();
$prioridad = $_POST["prioridad"];
$estado = 1;
$resultado_envio_correo = 0; //0 = no enviar,1 = enviado, 2= no enviado
//agrego el servicio
$agregar = $conexion->prepare("INSERT INTO servicios (
	id_usuario_solicitante,
	fecha_apertura,
	hora_apertura,
	titulo_servicio,
	id_estado_servicio,
	codigo_servicio,
	prioridad,
    fecha,
    hora
)
VALUES
	(
		$id_usuario_solicitante,
		'$fecha_apertura',
		'$hora_apertura',
		'$titulo',
		$estado,
		'$numero_ticket',
		'$prioridad',
        '$fecha_apertura',
        '$hora_apertura'
	)");
try{
    $resultado = $agregar->execute();
    //subo el mensaje
    if($mensaje == ""){
        $mensaje = "NA";
    }
    else{
    }
    //agrego el mensaje
    $add_mensaje = $conexion->prepare("INSERT INTO mensajes_tickets (
	ticket,
	mensaje,
	fecha,
	hora,
	activo,
    id_usuario
)
VALUES
	(
		'$numero_ticket',
		'$mensaje',
		'$fecha_apertura',
		'$hora_apertura',
		1,
        $id_usuario_mensaje
	)");
    $add_mensaje->execute();
    $id_mensaje = $conexion->lastInsertId();
    //busco las evidencias
    $evidencias = $_FILES["evidencias"];
    //verifico que se subieron
    if($evidencias["tmp_name"] == "" || $evidencias["tmp_name"] == null){
        //no existen evidencias
    }
    else{
        //si existen
        //creo la carpeta
        if(!file_exists("evidencias/$numero_ticket")){
            mkdir("evidencias/$numero_ticket/");
            mkdir(("evidencias/$numero_ticket/mensaje-$id_mensaje/"));
        }
        else{
            mkdir(("evidencias/$numero_ticket/mensaje-$id_mensaje/"));
        }
        $cantidad = count($evidencias["name"]);
        for($i = 0;$i<$cantidad;$i++){
            $nombre_archivo = $evidencias["name"][$i];
            $ruta_temporal = $evidencias["tmp_name"][$i];
            $extension = end(explode(".",$nombre_archivo));
            $ruta_final = "evidencias/$numero_ticket/mensaje-$id_mensaje/$nombre_archivo";
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
		'$numero_ticket',
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
    //envio el correo a el responsable de soporte
    $datos = $conexion->prepare("SELECT T.correo,concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as nombre_usuario,U.usuario FROM usuarios as U INNER JOIN personas as P ON U.id_persona = P.id_persona INNER JOIN trabajadores as T ON T.id_persona = P.id_persona WHERE U.id_usuario = $id_usuario_mensaje");
        $datos->execute();
        $row_datos = $datos->fetch((PDO::FETCH_NUM));
        $correo = $row_datos[0];
        $nombre_usuario = $row_datos[1];
        $usuario_sistema = $row_datos[2];
        $asunto = "[#$numero_ticket] Se ha creado un nuevo ticket: $titulo";
        $message = file_get_contents('../includes/template-mail.php'); 
        $message = str_replace('%testTituloCorreo%', "[#$numero_ticket] Ticket creado: $titulo", $message); 
        
        $message = str_replace('%nombre_usuario%', "$nombre_usuario", $message); 
        
        $message = str_replace('%usuario_sistema%', "$usuario_sistema", $message); 
        
        $message = str_replace('%correo_usuario%', "$correo", $message); 
        
        $message = str_replace('%fecha_ticket%', "$fecha_apertura - $hora_apertura", $message); 
        
        $message = str_replace('%testEnlaceTicket%', "$url/mSolicitudServicio/ticket.php?ticket=$numero_ticket", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico", $message); 
        $message = str_replace('%testTextoUnderTitulo%', "Se ha creado un nuevo ticket con el código de seguimiento #$numero_ticket", $message); 
        $resultado = enviar_correo($message,$correo_soporte,$nombre_usuario,$asunto);
    if($enviar_correo == 1){
        //envio un correo con la información del ticket, para mostrarlo posteriormente
        $resultado_array = array();
        //$id_usuario = 1;
        //busco el nombre y el correo
        $datos = $conexion->prepare("SELECT T.correo,concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as nombre_usuario,U.usuario FROM usuarios as U INNER JOIN personas as P ON U.id_persona = P.id_persona INNER JOIN trabajadores as T ON T.id_persona = P.id_persona WHERE U.id_usuario = $id_usuario_mensaje");
        $datos->execute();
        $row_datos = $datos->fetch((PDO::FETCH_NUM));
        $correo = $row_datos[0];
        $nombre_usuario = $row_datos[1];
        $usuario_sistema = $row_datos[2];
        $asunto = "[#$numero_ticket] Ticket creado: $titulo";
        $message = file_get_contents('../includes/template-mail.php'); 
        $message = str_replace('%testTituloCorreo%', "[#$numero_ticket] Ticket creado: $titulo", $message); 
        
        $message = str_replace('%nombre_usuario%', "$nombre_usuario", $message); 
        
        $message = str_replace('%usuario_sistema%', "$usuario_sistema", $message); 
        
        $message = str_replace('%correo_usuario%', "$correo", $message); 
        
        $message = str_replace('%fecha_ticket%', "$fecha_apertura - $hora_apertura", $message); 
        
        $message = str_replace('%testEnlaceTicket%', "$url/mSolicitudServicio/ticket.php?ticket=$numero_ticket", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico", $message); 
        $message = str_replace('%testTextoUnderTitulo%', "Haz creado un nuevo ticket con el código de seguimiento #$numero_ticket", $message); 
        $resultado = enviar_correo($message,$correo,$nombre_usuario,$asunto);
        if($resultado == true){
            //si se pudo enviar
            $resultado_envio_correo = 1;
            
        }
        else{
            //no se pudo enviar
            $resultado_envio_correo = 2;
        }

    }
    else{
        //el correo no se va a enviar
    }
    if($mostrar_ticket == 1){
        if($resultado_envio_correo == 1 || $resultado_envio_correo == 0){
            //si se envio el correo
            header("Location:ticket.php?ticket=$numero_ticket&resultado=exito_alta");
        }
        else if($resultado_envio_correo == 2){
            //no se envio el correo
            header("Location:ticket.php?ticket=$numero_ticket&resultado=exito_creacion");
        }
        
    }
    else{
        header("Location:index.php?resultado=exito_alta");
    }
}
catch(Exception $error){
    header("Location:index.php?resultado=error_alta_ticket");
}
?>