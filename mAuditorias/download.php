<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
if(!isset($_GET["f"])){
    header("Location:index.php");
}
else{
    $file = $_GET["f"];
    if($file == "" || $file == null){
        
    }
    else{
        if(isset($_GET["tipo"])){
            //es de cierre
            $consulta = "SELECT A.type,A.name,A.size
            FROM evidencias_cierre_auditorias as A
            WHERE A.file_string = '$file'";
        }
        else{
            $consulta = "SELECT A.type,A.name,A.size
            FROM evidencias_planes_auditorias as A
            WHERE A.file_string = '$file'";
        }
        $archivo = $conexion->query($consulta);
        $existe = $archivo->rowCount();
        if($existe == 0){

        }
        else{
            $row = $archivo->fetch(PDO::FETCH_NUM);
            $tipo = $row[0];
            $name = $row[1];
            $size = $row[2];
            $file_path = "../files/auditorias/$file";
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