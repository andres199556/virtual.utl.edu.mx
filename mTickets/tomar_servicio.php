<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$ref = getenv('HTTP_REFERER');
$array_resultado = array();
if($menu == "mSolicitudServicio"){
    $id_servicio = $_POST["id_servicio"];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    //si puedo acceder
    //verifico que el servicio no este asignado por el momento y que exista
    try{
        $buscar_servicio = $conexion->prepare("SELECT id_servicio FROM servicios WHERE id_servicio = $id_servicio AND estado_servicio = 0");
        $buscar_servicio->execute();
        //extraigo la cantidad de filas
        $existe_servicio = $buscar_servicio->rowCount();
        if($existe_servicio != 1){
            //no existe el servicio, por lo tanto regreso
            $array_resultado["resultado"] = "no_existe";
            $array_resultado["mensaje"] = "El servicio solicitado no existe";
        }
        else{
            //si existe, por lo tanto actualizo el responsable
            $actualizar = $conexion->prepare("UPDATE servicios SET id_usuario_responsable = $id_usuario_logueado,estado_servicio = 1,fecha = '$fecha',hora = '$hora', estado_servicio = 1 WHERE id_servicio = $id_servicio");
            $actualizar->execute();
            if($actualizar == 1){
                //agrego el log
                //inserto el log del servicio
                $texto_log = "El usuario ".$_SESSION["nombre_persona"]." ha tomado la responsabilidad de realizar el servicio";
                $insertar_log = $conexion->prepare("INSERT INTO log_servicios(id_servicio,texto_log,fecha,hora)VALUES($id_servicio,'$texto_log',NOW(),NOW())");
                $insertar_log->execute();
                $array_resultado["resultado"] = "exito";
                $array_resultado["mensaje"] = "El servicio se ha tomado correctamente";
            }
        }
    }
    catch(PDOException $error){
        $array_resultado["resultado"] = "error";
        $array_resultado["mensaje"] = "Ha ocurrido el siguiente error:".$error;
    }
    header('Content-type: application/json');
    echo json_encode($array_resultado);
}
else{
    if($ref == null || $ref == ""){
        header("Location:index.php");
    }
    
}
?>
