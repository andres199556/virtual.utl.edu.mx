<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$id_auditoria = $_POST["id_auditoria"];
$conclusiones = $_POST["conclusiones"];
$fecha_cierre = date("Y-m-d");
$fecha = date("Y-m-d H:i:s");
$evidencias = $_FILES["evidencias"];
$cantidad= count($evidencias["name"]);
try{
    //actualizo los datos del plan
    $actualizar = $conexion->query("UPDATE auditorias SET conclusiones = '$conclusiones',
    fecha_cierre = '$fecha_cierre',
    id_usuario = $id_usuario_logueado,
    fecha_hora = '$fecha',
    activo = 0
    WHERE id_auditoria  =$id_auditoria");
    for($i = 0;$i<$cantidad;$i++){
        $name = $evidencias["name"][$i];
        $tmp = $evidencias["tmp_name"][$i];
        $size = $evidencias["size"][$i];
        $type = $evidencias["type"][$i];
        $file_string = generar_string(50);
        move_uploaded_file($tmp,"../files/auditorias/$file_string");
        $add_evidencia = $conexion->query("INSERT INTO evidencias_cierre_auditorias(
            id_auditoria,
            name,
            size,
            type,
            file_string,
            fecha_hora,
            activo
        )VALUES(
            $id_auditoria,
            '$name',
            '$size',
            '$type',
            '$file_string',
            '$fecha',
            1
        )");
    }

}
catch(PDOException $error){
    echo $error->getMessage();
}
?>