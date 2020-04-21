<?php
include "../conexion/conexion.php";
$id_plan = $_POST["id"];
$comentarios = $_POST["comentarios"];
$liberar =$_POST["liberar"];
$fecha_liberacion = date("Y-m-d H:i:S");
$activo = 0;
try{
    //actualizo el estado
    $actualizar = $conexion->query("UPDATE planes_individuales_mantenimientos SET fecha_liberacion = '$fecha_liberacion',
    comentarios_liberacion = '$comentarios',activo = 0,libero = $liberar WHERE id_plan_individual = $id_plan AND libero is null");
    ?>
    <p align="center">Gracias por contestar la encuesta, puedes cerrar esta ventana.</p>
    <?php
    
}
catch(PDOException $error){
    echo $error->getMessage();
}
?>