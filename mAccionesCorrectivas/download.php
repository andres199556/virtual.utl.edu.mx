<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
if(!isset($_GET["file"])){
    header("Location:index.php");
}
else{
    $file = $_GET["file"];
    if($file == "" || $file == null){
        
    }
    else{
        $archivo = $conexion->query("SELECT A.file_type,A.extension,A.name,A.file_size
        FROM evidencias_actividades as A
        WHERE A.file_string = '$file'");
        $existe = $archivo->rowCount();
        if($existe == 0){

        }
        else{
            $row = $archivo->fetch(PDO::FETCH_NUM);
            $tipo = $row[0];
            $extension = $row[1];
            $name = $row[2];
            $size = $row[3];
            $file_path = "../files/evidencias_actividades/$file";
            $fecha_hora  =date("Y-m-d H:i:s");
        }
            if(file_exists($file_path)) {
                /* //agrego la descarga
                $guardar_descarga = $conexion->query("INSERT INTO historial_descargas_documentos(
                    id_documento,
                    id_usuario,
                    fecha_hora
                )VALUES(
                    $id_documento,
                    $id_usuario_logueado,
                    '$fecha_hora'
                )"); */
                header ("Content-Disposition: attachment; filename=".basename($name));
                header ("Content-Type: $tipo");
                header ("Content-Length: ".filesize($file_path));
                header('Content-Description: '.$name);
                readfile($file_path);
        }
        }
    }
?>