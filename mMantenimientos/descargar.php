<?php

include "../conexion/conexion.php";
include "../sesion/variables_sesion.php";
if(!isset($_GET["e"])){
    header("Location:index.php");
}
else{
    $file = $_GET["e"];
    if($file == "" || $file == null){
        
    }
    else{
        $evidencia = $conexion->query("SELECT name,
        type,
        size,
        ruta
        FROM evidencia_mantenimientos
        WHERE name_random = '$file'");
        $existe = $evidencia->rowCount();
        if($existe == 0){

        }
        else{
            $row_evidencia = $evidencia->fetch(PDO::FETCH_ASSOC);
            $tipo = $row_evidencia["type"];
            $fecha_hora  =date("Y-m-d H:i:s");
            header ("Content-Disposition: attachment; filename=".$row_evidencia["name"]." ");
            header ("Content-Type: $tipo");
            header ("Content-Length: ".$row_evidencia["size"]);
            header('Content-Description: Descarga de archivo');
            readfile($row_evidencia["ruta"]);
        }
        
    }
}
?>