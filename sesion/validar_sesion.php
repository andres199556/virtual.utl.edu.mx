<?php
include "variables_sesion.php";
session_name("session_activa_sixara");
session_start();
if(!isset($_SESSION["sesion_activa"])){
    header("Location:../mLogin/index.php?resultado=no_sesion");
}
$id_trabajador_logueado = $_SESSION["id_trabajador"];
$id_usuario_logueado = $_SESSION["id_usuario"];
$tiempo_actual = date("Y-m-d H:i:s");
$ultimo_acceso = $_SESSION["ultimo_acceso"];
$segundos_diferencia = strtotime($tiempo_actual) - strtotime($ultimo_acceso);
$minutos_sesion = 60;
//extraigo el permiso sobre el modulo
if($segundos_diferencia <= $minutos_sesion * 60){
    //todavia sigue activo
    $_SESSION["ultimo_acceso"] = date("Y-m-d H:i:s");
}
else{
    //destruyo la sesión
    session_destroy();
    header("Location:../mLogin/index.php?resultado=sesion_caducada");
}
?>