<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$resultado =array();
$id_usuario = $_POST["id_usuario"];
//busco los activos
$activos = $conexion->prepare("SELECT
AF.id_activo_fijo,
AF.no_activo_fijo,
M.nombre_marca,
AF.modelo,
AF.no_serie,
CA.consecutivo_activo_fijo 
FROM
activos_fijos AS AF
INNER JOIN marcas_equipos AS M ON AF.id_marca = M.id_marca
LEFT JOIN consecutivos_activos_fijos AS CA ON AF.id_consecutivo_activo_fijo = CA.id_consecutivo_activo_fijo 
WHERE
( SELECT AAF.id_usuario FROM asignacion_activos_fijos AS AAF WHERE AAF.id_activo_fijo = AF.id_activo_fijo ORDER BY fecha_asignacion DESC LIMIT 1 ) = $id_usuario
AND AF.id_ubicacion_secundaria = 4");
$activos->execute();
$has_row = $activos->rowCount();
if($has_row == 0){
    //No tiene activos ligados
}
else{
	
    $resultado = $activos->fetchAll();
}
echo json_encode($resultado);
?>