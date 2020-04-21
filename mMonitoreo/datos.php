<?php
include "../conexion/conexion.php";
$id_activo = $_POST["id_activo"];
$datos = $conexion->query("SELECT ME.nombre_marca,AF.modelo,AF.no_serie,AF.direccion_mac,AF.direccion_ip,U.ubicacion,US.ubicacion_secundaria,
CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable
FROM activos_fijos as AF
INNER JOIN marcas_equipos as ME ON AF.id_marca = ME.id_marca
INNER JOIN ubicaciones as U ON AF.id_ubicacion = U.id_ubicacion
INNER JOIN ubicaciones_secundarias as US ON AF.id_ubicacion_secundaria = US.id_ubicacion_secundaria
INNER JOIN asignacion_activos_fijos as AA ON AF.id_activo_fijo = AA.id_activo_fijo
INNER JOIN usuarios as USU ON AA.id_usuario = USU.id_usuario
INNER JOIN personas as P ON USU.id_persona = P.id_persona
WHERE AF.id_activo_fijo = $id_activo");
$row_datos = $datos->fetch(PDO::FETCH_ASSOC);
$resultado = array();
$resultado["marca"] = $row_datos["nombre_marca"];
$resultado["modelo"] = $row_datos["modelo"];
$serie = ($row_datos["no_serie"] == "") ? "Sin especificar":$row_datos["no_serie"];
$ip = ($row_datos["direccion_ip"] == "") ? "Sin especificar":$row_datos["direccion_ip"];
$resultado["no_serie"] = $serie;
$resultado["direccion_mac"] = $row_datos["direccion_mac"];
$resultado["direccion_ip"] = $ip;
$resultado["ubicacion"] = $row_datos["ubicacion"];
$resultado["secundaria"] = $row_datos["ubicacion_secundaria"];
$resultado["responsable"] = $row_datos["responsable"];
echo json_encode($resultado);
?>