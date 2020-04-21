<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_organigrama = $_POST["id_organigrama_edit"];
$nodo_sup = $_POST["id_node_sup_edit"];
$id_trabajador = $_POST["id_trabajador"];
$color = $_POST["color_edit"];
$comentarios = $_POST["comentarios"];
$puesto = $_POST["puesto"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{

$update = $conexion->query("UPDATE nodos_organigramas SET color = '$color',
comentarios = '$comentarios',
id_trabajador = $id_trabajador,
id_puesto = $puesto,
fecha_hora = '$fecha'
WHERE id_nodo = $nodo_sup");
$resultado["resultado"] = "exito_actualizar";
$resultado["mensaje"] = "El nodo se hactualizo correctamente!";
$buscar = $conexion->query("SELECT
	id_nodo,
	posicion,
	concat(SUBSTRING_INDEX(P.nombre,' ',1),' ',P.ap_paterno) as trabajador,
	PU.puesto AS puesto,
	CONCAT( '../', P.fotografia ) AS fotografia,
    NOR.color
FROM
	nodos_organigramas AS NOR
	INNER JOIN trabajadores AS T ON NOR.id_trabajador = T.id_trabajador
	INNER JOIN personas AS P ON T.id_persona = P.id_persona
	INNER JOIN puestos AS PU ON NOR.id_puesto = PU.id_puesto 
WHERE
    id_nodo = $nodo_sup");
    $row_datos = $buscar->fetch(PDO::FETCH_ASSOC);
    $resultado["id_nodo"] = $nodo_sup;
    $resultado["trabajador"] = $row_datos["trabajador"];
    $resultado["color"] = $row_datos["color"];
    $resultado["puesto"] = $row_datos["puesto"];
    $resultado["fotografia"] = $row_datos["fotografia"];
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>