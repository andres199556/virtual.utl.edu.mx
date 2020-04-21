<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$activo = strtoupper($_POST["activo"]);
//busco primero si existe el activo
$buscar_activo = $conexion->query("SELECT
ME.nombre_marca,
AF.modelo,
AF.no_serie,
AF.direccion_mac,
AF.memoria_ram,
AF.disco_duro,
SO.sistema_operativo,
AF.direccion_ip,
AF.comentarios,
D.direccion,
DE.departamento,
(
SELECT
    CONCAT( P.nombre, ' ', P.ap_paterno, ' ', P.ap_materno ) AS responsable 
FROM
    asignacion_activos_fijos AS AA
    INNER JOIN usuarios AS U ON AA.id_usuario = U.id_usuario
    INNER JOIN personas AS P ON U.id_persona = P.id_persona 
WHERE
    AA.numero_activo = '$activo' 
) AS responsable,
( SELECT COUNT( AME.id_activo ) FROM activos_mantenimientos AS AME WHERE AME.id_activo = AF.id_activo_fijo ) AS cantidad_mantenimientos,
TFM.tipo_frecuencia,
TFM.cantidad,
IF
(
    (
    SELECT
        MAX( PI.fecha_cierre_mantenimiento ) 
    FROM
        planes_individuales_mantenimientos AS PI
        INNER JOIN activos_mantenimientos AS AM2 ON PI.id_plan_individual = AM2.id_plan_individual_mantenimiento 
    WHERE
        AM2.no_activo = '$activo' 
    ) IS NULL,
    'Todavía sin mantenimiento',(
    SELECT
        MAX( PI.fecha_cierre_mantenimiento ) 
    FROM
        planes_individuales_mantenimientos AS PI
        INNER JOIN activos_mantenimientos AS AM2 ON PI.id_plan_individual = AM2.id_plan_individual_mantenimiento 
    WHERE
        AM2.no_activo = '$activo' 
    )) AS ultimo_mantenimiento 
FROM
activos_fijos AS AF
INNER JOIN marcas_equipos AS ME ON AF.id_marca = ME.id_marca
INNER JOIN sistemas_operativos AS SO ON AF.id_sistema_operativo = SO.id_sistema_operativo
INNER JOIN direcciones AS D ON AF.id_direccion = D.id_direccion
INNER JOIN departamentos AS DE ON AF.id_departamento = DE.id_departamento
INNER JOIN frecuencias_mantenimientos AS FM ON AF.id_consecutivo_activo_fijo = FM.id_consecutivo
INNER JOIN tipo_frecuencias_mantenimientos AS TFM ON FM.id_tipo_frecuencia = TFM.id_tipo_frecuencia 
WHERE
no_activo_fijo = '$activo'");
$existe = $buscar_activo->rowCount();
if($existe == 0){
    $resultado["resultado"] = "no_existe";
    $resultado["mensaje"] = "No existe un activo fijo con ese código.";
}
else{
    $resultado["resultado"] = "existe";
    $row_datos = $buscar_activo->fetch(PDO::FETCH_ASSOC);
    $cantidad = $row_datos["cantidad_mantenimientos"];
    $cantidad_meses = $row_datos["cantidad"];
    $fecha_ultimo = $row_datos["ultimo_mantenimiento"];
    if($fecha_ultimo != "Todavía sin mantenimiento"){
        //ya tiene fecha
        $row_datos["fecha_siguiente"] = date("Y-m-d",strtotime($fecha_ultimo."+ $cantidad_meses month")); 

    }
    else{
        $row_datos["fecha_siguiente"] = "Lo mas pronto posible.";
    }
    if($cantidad == 0){
        //ya no hay mantenimientos
        $resultado["datos"] = $row_datos;
    }
    else{
        //busco los mantenimientos
        $mantenimientos = $conexion->query("SELECT
        PIM.id_plan_individual,
        PM.titulo_plan,
        PM.descripcion,
        PIM.fecha_inicio_mantenimiento,
        PIM.fecha_cierre_mantenimiento,
        PIM.codigo_mantenimiento,
        PIM.fecha_liberacion,
        CONCAT( P.nombre, ' ', P.ap_paterno, ' ', P.ap_materno ) AS responsable 
    FROM
        planes_individuales_mantenimientos AS PIM
        INNER JOIN activos_mantenimientos AS AM ON PIM.id_plan_individual = AM.id_plan_individual_mantenimiento
        INNER JOIN planes_mantenimientos AS PM ON PIM.id_plan_mantenimiento = PM.id_plan_mantenimiento
        INNER JOIN usuarios AS U ON PIM.id_responsable_mantenimiento = U.id_usuario
        INNER JOIN personas AS P ON U.id_persona = P.id_persona 
    WHERE
        AM.no_activo = '$activo'");
        $row_mantenimientos = $mantenimientos->fetchAll(PDO::FETCH_ASSOC);
        $row_datos["mantenimientos_rows"] = $row_mantenimientos;
        $resultado["datos"] = $row_datos;
    }
    
}
echo json_encode($resultado);
?>