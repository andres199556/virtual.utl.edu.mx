<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$array_resultado = array();
$id_servicio = $_POST["id_servicio"];
//busco la información del servicio
$informacion = $conexion->prepare("SELECT codigo_servicio,estado_servicio FROM servicios WHERE id_servicio = $id_servicio");
$informacion->execute();
$row_informacion = $informacion->fetch(PDO::FETCH_NUM);
$codigo_servicio = $row_informacion[0];
$estado_servicio = $row_informacion[1];
if($estado_servicio == 3 || $estado_servicio == 4) {
    //ya se encuentra liberado, por lo tanto cancelo la operación
    $array_resultado["resultado"] = "servicio_liberado";
    $array_resultado["mensaje"] = "Este servicio no puede liberarse porque anteriormente ya ha sido liberado";
}
else{
    $acciones = $_POST["acciones_realizadas"];
    $fecha_servidor = (!isset($_POST["fecha_servidor"]) ? 0:1);
    $bitacora = (!isset($_POST["bitacora"]) ? 0:1);
    $bitacora_publica = (!isset($_POST["bitacora_publica"]) ? 0:1);
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");
    if($fecha_servidor == 0){
        //se subieron la fecha y hora
        $fecha_cierre = $_POST["fecha_cierre"];
        $hora_cierre = $_POST["hora_cierre"];
    }
    else{
        $fecha_cierre = date("Y-m-d");
        $hora_cierre = date("H:i:s");
    }
    try{
        //subo los datos
        $liberar = $conexion->prepare("UPDATE servicios SET fecha_cierre = '$fecha_cierre',hora_cierre = '$hora_cierre',acciones_realizadas = '$acciones',fecha = '$fecha',hora = '$hora',estado_servicio = 3 WHERE id_servicio = $id_servicio");
        $liberar->execute();
            if($bitacora == 1){
                //agrego el servicio a la bitácora
                $texto_bitacora = "Se atendió por parte del área de soporte técnico la solicitud de servicio con código $codigo_servicio";
                $insertar_bitacora = $conexion->prepare("INSERT INTO bitacoras (
                id_usuario,
                fecha_bitacora,
                hora_bitacora,
                bitacora,
                bitacora_publica,
                fecha,
                hora
            )
            VALUES
                (
                    $id_usuario_logueado,
                    '$fecha_cierre',
                    '$hora_cierre',
                    '$texto_bitacora',
                    $bitacora_publica,
                    '$fecha',
                    '$hora'
                )");
                $insertar_bitacora->execute();
            }
            if($bitacora == 1){
                //se inserto la bitacora correctamente

            }
            else{

            }
            $array_resultado["resultado"] = "exito";
            $array_resultado["mensaje"] = "El servicio se ha liberado correctamente!";
    }
    catch(PDOException $error){
        echo 'Ha ourrido un error: ' . $error->getMessage();
    }
}
header('Content-type: application/json');
echo json_encode($array_resultado);
?>