<?php
include "../conexion/conexion.php";
$modulos = $conexion->prepare("SELECT id_modulo FROM modulos");
$modulos->execute();
$array_m = array();
while($row_m = $modulos->fetch(PDO::FETCH_NUM)){
    array_push($array_m,$row_m[0]);
}
$modulos->closeCursor();


$buscar = $conexion->prepare("SELECT U.id_usuario FROM usuarios as U INNER JOIN personas as P ON U.id_persona = P.id_persona INNER JOIN trabajadores as T ON P.id_persona = T.id_persona WHERE U.id_usuario >=51");
$buscar->execute();
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$activo = 1;
while($row = $buscar->fetch(PDO::FETCH_NUM)){
    $id_usuario = $row[0];
    //inserto los permiso
    foreach($array_m as $id_modulo){
        $insert = $conexion->prepare("INSERT INTO permiso_modulos (
	id_modulo,
	id_usuario,
	permiso_modulo,
	fecha,
	hora,
	activo,
	id_usuario_alta
)
VALUES
	(
		$id_modulo,
		$id_usuario,
		1,
		'$fecha',
		'$hora',
		$activo,
		1
	)");
    $insert->execute();
    }
    
}
?>