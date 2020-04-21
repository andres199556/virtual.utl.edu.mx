<?php
include "../conexion/conexion.php";
if(isset($_POST["criterio"])){
    $criterio  =$_POST["criterio"];
}
else{
    $criterio = "";
}
$datos = $conexion->query("SELECT DISTINCT(id_unidad_cfdi),c_clave_unidad,nombre
FROM unidades_cfdi
WHERE nombre LIKE '%$criterio%'");
$array_final = array();
while($row_datos = $datos->fetch(PDO::FETCH_ASSOC)){
    $array_final[] = array(
        "unidad_cfdi" => $row_datos["c_clave_unidad"],
        "descripcion" => $row_datos["nombre"]
    );
}
echo json_encode($array_final);
exit;
?>