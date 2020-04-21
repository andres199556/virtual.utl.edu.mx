<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$criterio = $_POST["search"];
$pagina = $_POST["page"];
$resultado = array();
$resultado["data"] =  array();
$num_reg_paginas = 10;
if($pagina == 1){
    $inicio = 0;
}
else{
    $inicio = ($pagina - 1) * $num_reg_paginas;
}
if($criterio == ""){
    //son todos los registros
    $qry = "SELECT
	A.id_alumno,
	CONCAT( P.nombre, ' ', P.ap_paterno, ' ', P.ap_materno ) AS alumno,
	P.telefono,
	C.carrera,
	A.matricula,
IF
	(
		A.id_grupo_actual = 0,
		'Sin asignar',(
		SELECT
			G.grupo 
		FROM
			grupos AS G 
		WHERE
			G.id_grupo = A.id_grupo_actual 
		)) AS grupo,
	A.activo 
FROM
	alumnos AS A
	INNER JOIN personas AS P ON A.id_persona = P.id_persona
	INNER JOIN carreras AS C ON A.id_carrera = C.id_carrera 
ORDER BY
    P.ap_paterno ASC 
    LIMIT $inicio,$num_reg_paginas";
    $qry_todos = "SELECT id_alumno FROM alumnos";
}
else{
    $qry = "SELECT
	A.id_alumno,
	CONCAT( P.nombre, ' ', P.ap_paterno, ' ', P.ap_materno ) AS alumno,
	P.telefono,
	C.carrera,
	A.matricula,
IF
	(
		A.id_grupo_actual = 0,
		'Sin asignar',(
		SELECT
			G.grupo 
		FROM
			grupos AS G 
		WHERE
			G.id_grupo = A.id_grupo_actual 
		)) AS grupo,
	A.activo 
FROM
	alumnos AS A
	INNER JOIN personas AS P ON A.id_persona = P.id_persona
	INNER JOIN carreras AS C ON A.id_carrera = C.id_carrera  
    WHERE periodo LIKE '%$criterio%' OR descripcion LIKE '%$criterio%'
    ORDER BY
	P.ap_paterno ASC
     LIMIT $inicio,$num_reg_paginas";
    $qry_todos = "SELECT id_alumno 
    FROM alumnos";
}
$periodos = $conexion->query($qry);
$actuales = $periodos->rowCount();
while($row = $periodos->fetch(PDO::FETCH_ASSOC)){
    array_push($resultado["data"],$row);
}
$c_todos = $conexion->query($qry_todos);
$cantidad_registros = $c_todos->rowCount();
if($cantidad_registros < $num_reg_paginas){
    $paginas = 1;
}
else{
    $paginas = ceil($cantidad_registros / $num_reg_paginas);
}
$resultado["count"] = $actuales;
$resultado["num_paginas"] = $paginas;

echo json_encode($resultado);
?>