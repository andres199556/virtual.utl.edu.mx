<?php
$servidor_web = "http://128.100.0.3:50/erp";
include "../conexion/conexion.php";
include "../sesion/variables_sesion.php";
include "../funciones/strings.php";
include "../funciones/correos.php";
$fecha_cierre = $_POST["fecha_cierre"];
$id_plan  =$_POST["id_plan"];
$comentarios = $_POST["comentarios_cierre"];
$evidencias = $_FILES["evidencias"];
$fecha_hora  =date("Y-m-d H:i:s");
$activo = 1;
$resultado  =array();
$id_usuario = 1;
$token = generar_string(60);
//actualizo la fecha de cierre
try{
    $actualizar = $conexion->query("UPDATE planes_individuales_mantenimientos
    SET fecha_cierre_mantenimiento = '$fecha_cierre',
    fecha_hora = '$fecha_hora',
    comentarios_cierre = '$comentarios',
    activo = 2
    WHERE id_plan_individual = $id_plan
    ");
    //recorro las evidencias
    $cantidad = count($evidencias);
    for($i = 0;$i<$cantidad;$i++){
        $name = $evidencias["name"][$i];
        $tmp = $evidencias["tmp_name"][$i];
        $type = $evidencias["type"][$i];
        $size = $evidencias["size"][$i];
        
        $file_name_random = generar_random(25);
        $ruta_final = "evidencias_mantenimientos/$file_name_random";
        $mover = move_uploaded_file($tmp,$ruta_final);
        if($mover == true){
            
            //inserto el registro
            $insert_evidencia = $conexion->query("INSERT INTO evidencia_mantenimientos(
                id_plan_individual,
                name,
                type,
                size,
                ruta,
                fecha_hora,
                activo,
                id_usuario,
                name_random)VALUES(
                $id_plan,
                '$name',
                '$type',
                $size,
                '$ruta_final',
                '$fecha_hora',
                $activo,
                $id_usuario,
                '$file_name_random')
                ");
        }

    }
    //envio el correo para notificar al usua1rio
    //busco el correo y el nombre del usuario
    $datos = $conexion->query("SELECT U.id_usuario,T.correo,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as usuario
    FROM planes_individuales_mantenimientos as PIM
    INNER JOIN usuarios as U ON PIM.id_usuario_mantenimiento = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    WHERE PIM.id_plan_individual = $id_plan");
    $row_datos = $datos->fetch(PDO::FETCH_ASSOC);
    $id_usuario_correo = $row_datos["id_usuario"];
    $correo = $row_datos["correo"];
    $nombre_usuario = $row_datos["usuario"];
    $resultado["resultado"] = "exito";
    $asunto = "El plan de mantenimiento para tus equipos ha finalizado";
    $message = "Estimado $nombre_usuario. <br>
    El plan de mantenimiento asignado para tu equipo de cómputo ha finalizado, para liberarlo correctamente, te solicitamos llenar el siguiente
    formulario de retroalimentación, el cual podrás encontrar en el siguiente enlace: 
        <br><a target='_blank' href='$servidor_web/mMantenimientos/liberar.php?t=$token'>Haz clic aquí para acceder al formulario</a>";
        //enviar_correo_respuesta($id_usuario_correo,$nombre_usuario_correo,$correo_email);
        $resultado_correo = enviar_correo($message,$correo,$nombre_usuario,$asunto);
        $resultado["mensaje"] = "El mantenimiento se ha cerrado correctamente, quedando a espera de que el usuario libere el servicio.";
        
}
catch(Exception $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
    //echo $error->getMessage();
}
echo json_encode($resultado);
?>