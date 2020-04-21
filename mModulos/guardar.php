<?php
include "../conexion/conexion.php";
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_usuario = 1;
$db_functions = new db_functions();
try{
    $nombre = $_POST["nombre"];
    $id_categoria = $_POST["id_categoria"];
    $icono = $_POST["icono"];
    $descripcion = $_POST["descripcion"];
    $carpeta = $_POST["carpeta"];
    $color = $_POST["color_real"];
    str_replace("#","",$color);
    $tipo  =$_POST["color"];
    /* $table = "modulos";
    $columns = array("nombre_modulo","id_categoria","icono","descripcion");
    $values = array("$nombre",$id_categoria,"$icono","$descripcion");
    $db_functions->insert_row($table,$columns,$values,null); */
    try{
        $insert = $conexion->query("INSERT INTO modulos(
            nombre_modulo,
            id_categoria_modulo,
            icono,
            descripcion,
            fecha_hora,
            activo,
            id_usuario,
            carpeta_modulo,
            color,
            tipo_color
        )VALUES(
            '$nombre',
            $id_categoria,
            '$icono',
            '$descripcion',
            '$fecha_hora',
            $activo,
            $id_usuario,
            '$carpeta',
            '$color',
            '$tipo'
        )");
        mkdir("../$carpeta");
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