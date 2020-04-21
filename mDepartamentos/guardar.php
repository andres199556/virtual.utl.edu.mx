<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_usuario = 1;
$db_functions = new db_functions();
try{
    $departamento  =$_POST["departamento"];
    $direccion  =$_POST["direccion"];
    $descripcion  =$_POST["descripcion"];
    $siglas = $_POST["siglas"];
    /* $table = "modulos";
    $columns = array("nombre_modulo","id_categoria","icono","descripcion");
    $values = array("$nombre",$id_categoria,"$icono","$descripcion");
    $db_functions->insert_row($table,$columns,$values,null); */
    try{
        $insert = $conexion->query("INSERT INTO departamentos(
            departamento,
            id_direccion,
            descripcion,
            fecha_hora,
            activo,
            id_usuario,
            siglas
        )VALUES(
            '$departamento',
            $direccion,
            '$descripcion',
            '$fecha_hora',
            $activo,
            $id_usuario_logueado,
            '$siglas'
        )");
        header("Location:index.php?resultado=exito_alta");
    }
    catch(PDOException $error){
        echo $error->getMessage();
        //header("Location:index.php?resultado=error_alta");
    }
}
catch(Exception $error){
    
}
?>