<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_organigrama = $_POST["id_organigrama"];
$nodo_sup = $_POST["id_node_sup"];
$id_trabajador = $_POST["id_trabajador"];
$puesto = $_POST["puesto"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    $add = $conexion->query("INSERT INTO nodos_organigramas(id_organigrama,id_puesto,id_trabajador,fecha_hora,activo,posicion)VALUES(
        $id_organigrama,
        $puesto,
        $id_trabajador,
        '$fecha',
        $activo,
        $nodo_sup
    )");
    $id_nodo = $conexion->lastInsertId();
    $resultado["resultado"] = "Exito";
    $resultado["node"] = $id_nodo;
    //busco los datos
    $buscar = $conexion->query("SELECT
	id_nodo,
	posicion,
	concat(SUBSTRING_INDEX(P.nombre,' ',1),' ',P.ap_paterno) as trabajador,
	PU.puesto AS puesto,
	CONCAT( '../', P.fotografia ) AS fotografia 
FROM
	nodos_organigramas AS NOR
	INNER JOIN trabajadores AS T ON NOR.id_trabajador = T.id_trabajador
	INNER JOIN personas AS P ON T.id_persona = P.id_persona
	INNER JOIN puestos AS PU ON NOR.id_puesto = PU.id_puesto 
WHERE
    id_nodo = $id_nodo");
    $row_datos = $buscar->fetch(PDO::FETCH_ASSOC);
    $resultado["trabajador"] = $row_datos["trabajador"];
    $resultado["puesto"] = $row_datos["puesto"];
    $resultado["fotografia"] = $row_datos["fotografia"];
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>