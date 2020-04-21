<?php
session_name("session_activa_sixara");
session_start();
$id_usuario_logueado = $_SESSION["id_usuario"];
$id_persona_logueada = $_SESSION["id_persona"];
$nombre_completo_logueado = $_SESSION["nombre_persona"];
$usuario_logueado = $_SESSION["usuario"];
$nombre_corto_logueado = $_SESSION["nombre_corto"];
$id_trabajador_logueado = $_SESSION["id_trabajador"];
?>