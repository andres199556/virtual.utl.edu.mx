<?php
include "../conexion/conexion.php";
$equipos = $conexion->prepare("SELECT
D.id_dispositivo,
	CONCAT(
		'UTL-',
		UPPER(TD.tipo_equipo),
		'-',
		LPAD(D.id_dispositivo, 2, '0')
	) AS activo_fijo
FROM
	dispositivos AS D
INNER JOIN tipo_dispositivos AS TD ON D.id_tipo_dispositivo = TD.id_tipo_equipo");
$equipos->execute();
while($row = $equipos->fetch(PDO::FETCH_NUM)){
    $id = $row[0];
    $activo = $row[1];
    //actualizo
    $update = $conexion->prepare("UPDATE dispositivos SET no_activo_fijo = '$activo' WHERE id_dispositivo = $id");
    $update->execute();
}
?>