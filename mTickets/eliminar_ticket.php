<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
include "../funciones/directory.php";
$resultado = array();
$ticket = $_POST["ticket"];
//primero busco que exista
$buscar = $conexion->prepare("SELECT id_servicio FROM servicios WHERE codigo_servicio = '$ticket'");
$buscar->execute();
$existe = $buscar->rowCount();
if($existe == 0){
    //no existe el mensaje
    $resultado["resultado"] = "no_existe";
        $resultado["titulo"] = "El ticket no existe!";
        $resultado["mensaje"] = "El ticket o servicio no se puede eliminar.";
        $resultado["icon"] = "warning";
}
else{
    //busco si cuenta con mensajes, en caso de que si, automaticamente se borran las evidencias en la BD
    $mensajes = $conexion->prepare("SELECT id_mensaje FROM mensajes_tickets WHERE  ticket = '$ticket'");
    $mensajes->execute();
    $existen = $mensajes->rowCount();
    if($existen == 0){
        //no cuenta con mensajes, por lo tanto solo lo elimino
        goto eliminar;
    }
    else{
        //cuenta con mensajes, por lo tanto los elimino
        $delete_msj = $conexion->prepare("DELETE FROM mensajes_tickets WHERE ticket = '$ticket'");
        $delete_msj->execute();
        //elimino las evidencias, y la carpeta del mensaje
        //delete_dir("evidencias/$ticket/$id_mensaje/");
        goto eliminar;
    }
    
    eliminar:
    try{
        $delete = $conexion->prepare("DELETE FROM servicios WHERE codigo_servicio = '$ticket'");
        $delete->execute();
        delete_dir("evidencias/$ticket/");
        $resultado["resultado"] = "exito";
        $resultado["titulo"] = "Exito!";
        $resultado["mensaje"] = "El ticket ha sido eliminado correctamente!";
        $resultado["icon"] = "success";
    }
    catch(PDOException $error){
        $resultado["resultado"] = "error";
        $resultado["titulo"] = "Error!";
        $resultado["mensaje"] = "Ha ocurrido un error, vuelve a intentarlo mas tarde!";
        $resultado["icon"] = "danger";
    }      
}
header("Content-type:application/json");
echo json_encode($resultado);
?>