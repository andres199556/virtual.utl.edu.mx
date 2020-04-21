<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if(!isset($_GET["file"])){
    header("Location:index.php");
}
else{
    $file = $_GET["file"];
    if($file == "" || $file == null){
        
    }
    else{
        $archivo = $conexion->query("SELECT
        MF.filestring,
        MF.filepath,
        MF.filetype,
        MF.filesize,
        MF.extension,
        MF.name
    FROM
        messages_files AS MF
    INNER JOIN mensajes AS M ON MF.id_mensaje = M.id_mensaje
    WHERE
        MF.filestring = '$file'
    AND (
        M.acceso_mensaje LIKE '$id_usuario_logueado,%'
        OR M.acceso_mensaje LIKE '%,$id_usuario_logueado'
        OR M.acceso_mensaje LIKE '%,$id_usuario_logueado,%'
    )");
        $existe = $archivo->rowCount();
        if($existe == 0){

        }
        else{
            $row = $archivo->fetch(PDO::FETCH_NUM);
            $tipo = $row[2];
            $extension = $row[4];
            $name = $row[5];
            $file_path = "../files/messages/$file";
            $fecha_hora  =date("Y-m-d H:i:s");
            $name_salida = $name.".".$extension;
        }
            if(file_exists($file_path)) {
               /*  //agrego la descarga
                $guardar_descarga = $conexion->query("INSERT INTO historial_descargas_documentos(
                    id_documento,
                    id_usuario,
                    fecha_hora
                )VALUES(
                    $id_documento,
                    $id_usuario_logueado,
                    '$fecha_hora'
                )"); */
                header ("Content-Disposition: attachment; filename=".basename($name_salida));
                header ("Content-Type: $tipo");
                header ("Content-Length: ".filesize($file_path));
                header('Content-Description: Descarga de archivo');
                readfile($file_path);
        }
        }
    }
?>