<?php
$servidor = "128.100.0.1:50/erp";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/correos.php";
$id_plan_individual = $_POST["id_plan"];
$resultado = array();
try{
    //extraigo el id del usuario
    $buscar = $conexion->query("SELECT id_usuario_mantenimiento,fecha_inicio_mantenimiento,comentarios 
    FROM planes_individuales_mantenimientos 
    WHERE id_plan_individual = $id_plan_individual");
    $row_buscar = $buscar->fetch(PDO::FETCH_NUM);
    $id_usuario_mantenimiento = $row_buscar[0];
    $nueva_fecha = $row_buscar[1];
    $comentarios = $row_buscar[2];
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
        $asunto = "Nuevo plan de mantenimiento por parte del área de Soporte Técnico";
		$message = file_get_contents('../includes/template-email-mantenimiento.php'); 
		$message = str_replace('%testTituloCorreo%', "Se ha cargado un nuevo plan de mantenimiento", $message); 
		$message = str_replace('%testTextoUnderTitulo%', "El siguiente correo es para notificar la creación de un plan de mantenimiento para los equipos asignados a usted.", $message); 
        $message = str_replace('%fecha_mantenimiento%', $nueva_fecha, $message); 
        $message = str_replace('%comentarios_mantenimiento%', $comentarios, $message); 
        $message = str_replace('%testEnlaceTicket%', "http://$servidor/mMantenimientos/mantenimiento.php?id=$id_plan_individual", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico.", $message); 
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado_correo = enviar_correo($message,$correo_email,$nombre_usuario_correo,$asunto);
        if($resultado_correo == true){
            $resultado["resultado"] = "exito";
            $resultado["mensaje"] = "Cambios guardados correctamente!.";
        }
        else{
            $resultado["resultado"] = "exito_alta";
            $resultado["mensaje"] = "Las fechas se actualizaron correctamente sin embargo no se pudo enviar la notificación.";
        }
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
            $resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error->getMessage().".";
}
header('Content-type: application/json');
echo json_encode( $resultado );
?>