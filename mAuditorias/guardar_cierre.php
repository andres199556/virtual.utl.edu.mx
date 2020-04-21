<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
$puntuacion  =$_POST["puntuacion"];
$evidencia = $_FILES["evidencia"];
$enviar_correo = 1;
$activo = 1;
$fecha = date("Y-m-d H:i:s");
try{
    //primero valido que se encuentre abierta
    $validar = $conexion->query("SELECT id_plan,id_auditoria FROM planes_auditorias WHERE activo = 1");
    $existe = $validar->rowCount();
    if($existe == 0){
        header("Location:index.php");
    }
    else{
        $row_datos = $validar->fetch(PDO::FETCH_ASSOC);
        $id_auditoria = $row_datos["id_auditoria"];

    }
}
catch(Exception $error){
    echo $error->getMessage();
}
?>