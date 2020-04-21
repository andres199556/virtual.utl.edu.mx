<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
include "../funciones/directory.php";
$resultado = array();
$ticket = $_POST["ticket"];
$id_mensaje = $_POST["id_mensaje"];
//primero busco que exista
$buscar = $conexion->prepare("SELECT id_mensaje FROM mensajes_tickets WHERE id_mensaje = $id_mensaje AND ticket = '$ticket'");
$buscar->execute();
$existe = $buscar->rowCount();
if($existe == 0){
    //no existe el mensaje
    $resultado["resultado"] = "no_existe";
        $resultado["titulo"] = "El mensaje no existe!";
        $resultado["mensaje"] = "El mensaje no se puede eliminar.";
        $resultado["icon"] = "warning";
}
else{
    //busco si cuenta con evidencias
    $evidencias = $conexion->prepare("SELECT id_evidencia FROM evidencias_tickets WHERE id_mensaje = $id_mensaje AND ticket = '$ticket'");
    $evidencias->execute();
    $existen = $evidencias->rowCount();
    if($existen == 0){
        //no cuenta con evidencias, por lo tanto solo lo elimino
        goto eliminar;
    }
    else{
        //elimino las evidencias, y la carpeta del mensaje
        delete_dir("evidencias/$ticket/mensaje-$id_mensaje/");
        goto eliminar;
    }
    
    eliminar:
    try{
        $delete = $conexion->prepare("DELETE FROM mensajes_tickets WHERE id_mensaje = $id_mensaje AND ticket = '$ticket'");
        $delete->execute();
        $resultado["resultado"] = "exito";
        $resultado["titulo"] = "Exito!";
        $resultado["mensaje"] = "La respuesta se ha eliminado correctamente!";
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