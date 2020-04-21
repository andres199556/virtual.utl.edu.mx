<?php
$servidor = "localhost:50/sicoin.utl.edu.mx";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
include "../funciones/correos.php";
$id_plan_individual = $_POST["id_plan_individual"];
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = $_SESSION["id_usuario"];
$enviar_correo = (isset($_POST["enviar_correo_a"]) ? 1:0);
$activos = $_POST["activos"];
$activo = 1;
$resultado = array();
$id_plan_mantenimiento = $_POST["id_plan_mantenimiento"];
try{
    foreach($activos as $id_activo_fijo){
        //inserto los activos
        //busco el no de activo
        $buscar_activo = $conexion->query("SELECT no_activo_fijo 
        FROM activos_fijos 
        WHERE id_activo_fijo = $id_activo_fijo");
        $row_buscar = $buscar_activo->fetch(PDO::FETCH_NUM);
        $no_activo = $row_buscar[0];
        $insertar = $conexion->query("INSERT INTO activos_mantenimientos(
            id_plan_individual_mantenimiento,
            id_plan_mantenimiento,
            id_activo,
            no_activo,
            fecha_hora,
            activo,
            id_usuario)VALUES(
                $id_plan_individual,
                $id_plan_mantenimiento,
                $id_activo_fijo,
                '$no_activo',
                '$fecha_hora',
                $activo,
                $id_usuario
            )");
    }
    //extraigo el id del usuario
    $buscar = $conexion->query("SELECT id_usuario_mantenimiento FROM planes_individuales_mantenimientos WHERE id_plan_individual = $id_plan_individual");
    $row_buscar = $buscar->fetch(PDO::FETCH_NUM);
    $id_usuario_mantenimiento = $row_buscar[0];
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
    $resultado["resultado"] = "exito_alta";
    $resultado["mensaje"] = "Los activos se han cargado correctamente.";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error->getMessage().".";
}
header('Content-type: application/json');
echo json_encode($resultado);
?>