<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_plan = $_POST["id_plan"];
$resultado = array();
$planes = $conexion->prepare("SELECT
	PI.id_plan_individual,
	CONCAT(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS usuario,
	IF(D.departamento is null,'Sin especificar',D.departamento),
	IF(DI.direccion is null,'Sin especificar',DI.direccion),
	PI.fecha_inicio_mantenimiento,
	IF(PI.fecha_cierre_mantenimiento is null,'Sin especificar',PI.fecha_cierre_mantenimiento),
	PI.comentarios,
    PI.activo
FROM
	planes_individuales_mantenimientos AS PI
INNER JOIN usuarios AS U ON PI.id_usuario_mantenimiento = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN trabajadores AS T ON P.id_persona = T.id_persona
LEFT JOIN departamentos AS D ON T.id_departamento = D.id_departamento
LEFT JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion
WHERE PI.id_plan_mantenimiento = $id_plan");
$planes->execute();
$rows = $planes->rowCount();
if($rows == 0){
    //no tiene
}
else{
    $resultado = $planes->fetchAll();
}
echo json_encode($resultado);
?>