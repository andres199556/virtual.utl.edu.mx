<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_documento = $_POST["id"];
$id_direccion = $_POST["id_direccion"];
$id_departamento  =$_POST["id_departamento"];
$id_proceso = $_POST["id_proceso"];
$id_tipo_documento = $_POST["id_tipo_documento"];
$codigo = $_POST["codigo"];
$reutilizable = (isset($_POST["reutilizable"]) ? 1:0);

$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
try{
    if($reutilizable == 0){
        //el codigo no se puede repetir, lo busco
        $buscar_codigo = $conexion->query("SELECT id_documento FROM documentos WHERE codigo = '$codigo' AND id_documento != $id_documento");
        $existe = $buscar_codigo->rowCount();
        if($existe != 0){
            header("Location:editar.php?id=$id_documento&resultado=codigo_repetido");
        }
        else{
            goto actualizar;
        }
        
    }
    else{
        goto actualizar;
    }
    actualizar:
    $actualizar = $conexion->query("UPDATE documentos SET id_direccion = $id_direccion,
    id_departamento = $id_departamento,
    id_proceso = $id_proceso,
    id_tipo_documento = $id_tipo_documento,
    id_tipo_documento_real = $id_tipo_documento,
    codigo = '$codigo',
    fecha_hora = '$fecha_hora',
    activo = $activo,
    id_usuario = $id_usuario_logueado,
    codigo_reutilizable = $reutilizable
    WHERE id_documento = $id_documento
    ");
    header("Location:index.php?resultado=exito_actualizar");
}
catch(PDOException $error){
    echo $error->getMessage();
}
?>