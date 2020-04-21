<?php
include "../conexion/conexion.php";
if(isset($_POST["criterio"])){
    $criterio  =$_POST["criterio"];
    $condicion = "WHERE descripcion LIKE '%$criterio%'";
}
else{
    $criterio = "animales";
    $condicion = "";
}
$datos = $conexion->query("SELECT DISTINCT(id_clave_cfdi),clave_cfdi,descripcion
FROM claves_cfdi
$condicion");
$array_final = array();
while($row_datos = $datos->fetch(PDO::FETCH_ASSOC)){
    $array_final[] = array(
        "clave_cfdi" => $row_datos["clave_cfdi"],
        "descripcion" => $row_datos["descripcion"]
    );
}
echo json_encode($array_final);
exit;
?>