<?php
$servidor = "localhost:50/erp";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/correos.php";
$id_plan_individual = $_POST["id_plan_individual"];
$id_responsable  =$_POST["id_responsable"];
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = $_SESSION["id_usuario"];
$enviar_correo = (isset($_POST["correo_administrativo"]) ? 1:0);
$correo_responsable = (isset($_POST["correo_responsable"]) ? 1:0);
$resultado = array();
try{
    //extraigo el nombre del usuario responsable
    $buscar_datos = $conexion->query("SELECT
    CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as nombre_persona,T.correo
    FROM usuarios as U
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    WHERE U.id_usuario = $id_responsable");
    $row_buscar_datos = $buscar_datos->fetch(PDO::FETCH_NUM);
    $nombre_responsable = $row_buscar_datos[0];

    $actualizar = $conexion->query("UPDATE planes_individuales_mantenimientos
    SET id_responsable_mantenimiento = $id_responsable,
    fecha_hora = '$fecha_hora',
    id_usuario = $id_usuario
    WHERE id_plan_individual = $id_plan_individual
    ");
    $resultado["resultado"] = "exito";
    $resultado["nombre_responsable"] = $nombre_responsable;
    $resultado["mensaje"] = "Responsable asignado correctamente!.";
    if($correo_responsable == 1){
        $correo_responsable = $row_buscar_datos[1];
        $asunto = "Asignación de responsable de mantenimiento";
    }
    //se va a enviar correo
    /* if($enviar_correo == 1){
		//extraigo los datos
		$datos = $conexion->query("SELECT
		T.correo,
		CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as usuario
		FROM usuarios as U
		INNER JOIN personas as P ON U.id_persona = P.id_persona
		INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
		WHERE U.id_usuario = $id_usuario_mantenimiento");
		$row_datos = $datos->fetch(PDO::FETCH_NUM);
		$correo_email = $row_datos[0];
		$nombre_usuario_correo = $row_datos[1];
		$fecha_respuesta = "(".date("Y-m-d")." ".date("H:i:s").")";
        //envio correo
        $asunto = "Cambios en fechas de realización del mantenimiento";
		$message = file_get_contents('../includes/template-email-mantenimiento.php'); 
		$message = str_replace('%testTituloCorreo%', "Cambios en fechas asignadas para el mantenimiento", $message); 
		$message = str_replace('%testTextoUnderTitulo%', "El siguiente correo es para notificar la actualización en las fechas asignadas al plan de mantenimiento creado para tí, los cambios son los siguientes: ", $message); 
        $message = str_replace('%fecha_mantenimiento%', $nueva_fecha, $message); 
        $message = str_replace('%comentarios_mantenimiento%', $comentarios, $message); 
        $message = str_replace('%testEnlaceTicket%', "http://$servidor/mMantenimientos/mantenimiento.php?id=$id_plan_individual", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico.", $message); 
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado_correo = enviar_correo($message,$correo_email,$nombre_usuario_correo,$asunto);
        if($resultado_correo == true){
            $resultado["resultado"] = "exito_completo";
            $resultado["mensaje"] = "Cambios guardados correctamente!.";
        }
        else{
        }
    } */
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error->getMessage().".";
}
header('Content-type: application/json');
echo json_encode( $resultado );
?>