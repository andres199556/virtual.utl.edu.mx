<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$id_plan = $_POST["id_plan"];
$puntuacion = $_POST["puntuacion"];
$comentarios = $_POST["comentarios"];
$fecha_cierre = date("Y-m-d");
$fecha = date("Y-m-d H:i:s");
$evidencias = $_FILES["evidencias"];
$cantidad= count($evidencias["name"]);
$resultado = array();
try{
    //actualizo los datos del plan
    $actualizar = $conexion->query("UPDATE planes_auditorias SET puntuacion = $puntuacion,
    comentarios_evidencia = '$comentarios',
    fecha_cierre_plan = '$fecha_cierre',
    id_usuario_cierre = $id_usuario_logueado,
    fecha_hora = '$fecha',
    activo = 0
    WHERE id_plan  =$id_plan");
    for($i = 0;$i<$cantidad;$i++){
        $name = $evidencias["name"][$i];
        $tmp = $evidencias["tmp_name"][$i];
        $size = $evidencias["size"][$i];
        $type = $evidencias["type"][$i];
        $file_string = generar_string(50);
        move_uploaded_file($tmp,"../files/auditorias/$file_string");
        $add_evidencia = $conexion->query("INSERT INTO evidencias_planes_auditorias(
            id_plan,
            name,
            size,
            type,
            file_string,
            fecha_hora,
            activo
        )VALUES(
            $id_plan,
            '$name',
            '$size',
            '$type',
            '$file_string',
            '$fecha',
            1
        )");
    }
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Plan de auditoria cerrado correctamente!.";
}
catch(PDOException $error){
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>