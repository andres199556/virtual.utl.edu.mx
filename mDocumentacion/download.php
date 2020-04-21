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
        $archivo = $conexion->query("SELECT DD.tipo_documento,DD.extension,DD.nombre_archivo,D.codigo,D.id_documento
        FROM detalle_documentos as DD
        INNER JOIN documentos as D ON DD.id_documento = D.id_documento
        WHERE file_string = '$file'");
        $existe = $archivo->rowCount();
        if($existe == 0){

        }
        else{
            $row = $archivo->fetch(PDO::FETCH_NUM);
            $tipo = $row[0];
            $extension = $row[1];
            $name = $row[2];
            $codigo = $row[3];
            $id_documento = $row[4];
            $file_path = "../files/documents/$file";
            $fecha_hora  =date("Y-m-d H:i:s");
            $name_salida = $codigo." - ".$name.".".$extension;
        }
            if(file_exists($file_path)) {
                //agrego la descarga
                $guardar_descarga = $conexion->query("INSERT INTO historial_descargas_documentos(
                    id_documento,
                    id_usuario,
                    fecha_hora
                )VALUES(
                    $id_documento,
                    $id_usuario_logueado,
                    '$fecha_hora'
                )");
                header ("Content-Disposition: attachment; filename=".basename($name_salida));
                header ("Content-Type: application/octet-stream");
                header ("Content-Length: ".filesize($file_path));
                header('Content-Description: Descarga de archivo');
                readfile($file_path);
        }
        }
    }
?>