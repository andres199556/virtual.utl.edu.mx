<?php
$servidor = "localhost:50/erp";
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/correos.php";
$id_plan_individual = $_POST["id_plan_individual"];
$nota = $_POST["nota"];
$fecha_hora = date("Y-m-d H:i:s");
$id_usuario = $_SESSION["id_usuario"];
$enviar_correo = (isset($_POST["enviar_correo_a"]) ? 1:0);
$resultado = array();
$activo = 1;
try{
    //inserto la nota
    $agregar = $conexion->query("INSERT INTO notas_mantenimientos(
        id_plan_individual,
        nota,
        fecha_hora,
        activo,
        id_usuario
    )VALUES(
        $id_plan_individual,
        '$nota',
        '$fecha_hora',
        $activo,
        $id_usuario
    )");
    $resultado["resultado"] = "exito_nota";
    $resultado["header"] = "Exito!";
    $resultado["mensaje"] = "La nota se a creado correctamente!.";
    //extraigo el id del usuario
    $buscar = $conexion->query("SELECT id_usuario_mantenimiento FROM planes_individuales_mantenimientos WHERE id_plan_individual = $id_plan_individual");
    $row_buscar = $buscar->fetch(PDO::FETCH_NUM);
    $id_usuario_mantenimiento = $row_buscar[0];
    if($enviar_correo == 1){
        //busco los datos del usuario
        $persona = $conexion->query("SELECT
        CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
        FROM personas as P
        INNER JOIN usuarios as U ON P.id_persona = U.id_persona
        WHERE U.id_usuario = ".$_SESSION["id_usuario"]);
        $row_persona = $persona->fetch(PDO::FETCH_NUM);
        $nombre_usuario = $row_persona[0];
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
        $asunto = "Se ha agregado una nota en el mantenimiento";
		$message = file_get_contents('../includes/template-email-nota-mantenimiento.php'); 
		$message = str_replace('%testTituloCorreo%', "Se a agregado una nota al mantenimiento", $message); 
		$message = str_replace('%testTextoUnderTitulo%', "El siguiente correo es para notificar la creación de una nota dentro del mantenimiento que tienes programado: ", $message); 
        $message = str_replace('%texto_archivos%', '', $message); 
        $message = str_replace('%mensaje%', $nota, $message); 
        $message = str_replace('%nombre_usuario%', $nombre_usuario, $message); 
        $message = str_replace('%fecha_respuesta%', $fecha_respuesta, $message); 
        $message = str_replace('%comentarios_mantenimiento%', $comentarios, $message); 
        $message = str_replace('%testEnlaceTicket%', "http://$servidor/mMantenimientos/mantenimiento.php?id=$id_plan_individual", $message); 
        $message = str_replace('%testTextoCursiva%', "Te sugerimos no hacer caso omiso a este mensaje, en caso de que creas que este mensaje es un error, contacta al área de soporte técnico.", $message); 
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado_correo = enviar_correo($message,$correo_email,$nombre_usuario_correo,$asunto);
        if($resultado_correo == true){
            $resultado["resultado"] = "exito_completo";
            $resultado["header"] = "Exito!";
            $resultado["mensaje"] = "La nota se a creado correctamente!.";
        }
        else{
            $resultado["resultado"] = "exito_parcial";
            $resultado["mensaje"] = "La nota se a creado correctamente, sin embargo el correo no pudo enviarse.";
        }
    }
    else{

    }

}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error->getMessage().".";
}
/* header('Content-type: application/json');
print_r($resultado);
echo "asdasd"; */
echo json_encode($resultado);
?>