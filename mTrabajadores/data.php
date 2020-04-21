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
    $qry = "SELECT id_periodo,periodo,fecha_inicio,fecha_cierre,descripcion,activo FROM periodos LIMIT $inicio,$num_reg_paginas";
    $qry_todos = "SELECT id_periodo FROM periodos";
}
else{
    $qry = "SELECT id_periodo,periodo,fecha_inicio,fecha_cierre,descripcion,activo FROM periodos WHERE periodo LIKE '%$criterio%' OR descripcion LIKE '%$criterio%' LIMIT $inicio,$num_reg_paginas";
    $qry_todos = "SELECT id_periodo,periodo,fecha_inicio,fecha_cierre,descripcion,activo FROM periodos WHERE periodo LIKE '%$criterio%' OR descripcion LIKE '%$criterio%'";
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