<?php
$servidor = "localhost:50/erp";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/correos.php";
$id_plan_mantenimiento = $_POST["id_plan_mantenimiento"];
$id_usuario_mantenimiento = $_POST["id_usuario"];
$fecha_mantenimiento = $_POST["fecha_mantenimiento"];
$activos = $_POST["activos_submit"];
$id_activos = $_POST["id_activos_submit"];
$comentarios = $_POST["comentarios"];
$enviar_correo = (isset($_POST["enviar_correo"]) ? 1:0);
$definir_despues = (isset($_POST["definir_despues"]) ? 1:0);
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_usuario = $_SESSION["id_usuario"];
//inserto el mantenimiento
echo "<pre>";
print_r($_POST);
try{
    $insertar = $conexion->prepare("INSERT INTO planes_individuales_mantenimientos (
	id_plan_mantenimiento,
	id_usuario_mantenimiento,
	fecha_inicio_mantenimiento,
	comentarios,
	fecha_hora,
	activo,
	id_usuario,
	enviar_correo_notificacion,
	definir_activos_despues
)
VALUES
	(
		$id_plan_mantenimiento,
		$id_usuario_mantenimiento,
		'$fecha_mantenimiento',
		'$comentarios',
		'$fecha_hora',
		$activo,
		$id_usuario,
		$enviar_correo,
		$definir_despues
	)");
    $insertar->execute();
    $id_plan_individual = $conexion->lastInsertId();
    //inserto los activos
	$j = 0;
	if($definir_despues == 1){

	}
	else{
		foreach($id_activos as $id_activo){
			$no_activo = $activos[$j];
			//inserto
			$insert_activo = $conexion->prepare("INSERT INTO activos_mantenimientos (
		id_plan_individual_mantenimiento,
		id_plan_mantenimiento,
		id_activo,
		no_activo,
		fecha_hora,
		activo,
		id_usuario
	)
	VALUES
		(
			$id_plan_individual,
			$id_plan_mantenimiento,
			$id_activo,
			'$no_activo',
			'$fecha_hora',
			$activo,
			$id_usuario
		)");
			$insert_activo->execute();
			++$j;
			
		}
	}
	if($enviar_correo == 1){
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
        $message = str_replace('%fecha_mantenimiento%', $fecha_mantenimiento, $message); 
        $message = str_replace('%comentarios_mantenimiento%', $comentarios, $message); 
        $message = str_replace('%testEnlaceTicket%', "http://$servidor/mMantenimientos/mantenimiento.php?id=$id_plan_individual", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico.", $message); 
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado = enviar_correo($message,$correo_email,$nombre_usuario_correo,$asunto);
	}
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
	echo $error->getMessage();
	//header("Location:index.php?resultado=error_alta");
}

?>