<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$modulo = $_POST["modulo"];
$id_categoria = $_POST["id_categoria"];
$carpeta = $_POST["carpeta"];
$icono = $_POST["icono"];
$descripcion = (isset($_POST["descripcion"])? $_POST["descripcion"]:"NA");
$id_modulo = $_POST["id_modulo"];
//primero busco que exista
$buscar = $conexion->prepare("SELECT id_modulo FROM modulos WHERE (nombre_modulo = '$modulo' OR carpeta_modulo = '$carpeta') AND id_modulo != $id_modulo");
$buscar->execute();
$existe = $buscar->rowCount();
if($existe != 0){
    //existe
    header("Location:index.php?resultado=existe");
}
else{
    //inserto el registro
    try{
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $actualizar = $conexion->prepare("UPDATE modulos
            SET id_categoria_modulo = $id_categoria,
             nombre_modulo = '$modulo',
             carpeta_modulo = '$carpeta',
             icono = '$icono',
             descripcion = '$descripcion',
             fecha = '$fecha',
             hora = '$hora',
             id_usuario = $id_usuario_logueado
            WHERE
                id_modulo = $id_modulo");
        $actualizar->execute();
        header("Location:index.php?resultado=exito_actualizar");
    }
    catch(PDOException $error){
        header("Location:index.php?resultado=$error");
    }
    
}
?>