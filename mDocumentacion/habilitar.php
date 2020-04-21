<?php
include "../conexion/conexion.php";
include "../funciones/strings.php";
include "../sesion/validar_sesion.php";
$id_documento = $_GET["id"];
//busco primero el actual
$buscar = $conexion->query("SELECT id_tipo_documento_real FROM documentos WHERE id_documento = $id_documento");
$row_buscar = $buscar->fetch(PDO::FETCH_NUM);
$id_tipo_documento_real = $row_buscar[0];
$fecha_hora = date("Y-m-d H:i:s");
try{
    $act = $conexion->query("UPDATE documentos SET id_tipo_documento = $id_tipo_documento_real,
    fecha_hora = '$fecha_hora',
    id_usuario = $id_usuario_logueado
    WHERE id_documento = $id_documento");
    header("Location:index.php?resultado=exito_habilitar");
}
catch(PDOException $error){
    echo $error->getMessage();
}
?>