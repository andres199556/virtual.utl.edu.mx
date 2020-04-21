<?php
include "../conexion/conexion.php";
$cliente = $_POST["cliente"];
$buscar = $conexion->query("SELECT DISTINCT
(C.id_cliente),
concat(
    P.nombre,
    ' ',
    P.ap_paterno,
    ' ',
    P.ap_materno
) AS cliente
FROM
clientes AS C
INNER JOIN personas AS P ON C.id_persona = P.id_persona
WHERE
P.nombre LIKE '%$cliente%'
OR P.ap_paterno LIKE '%$cliente%'
OR P.ap_materno LIKE '%$cliente%'");
$existe = $buscar->rowCount();
$resultado = array();
if($existe == 0){
    $resultado["existe"] = 0;
}
else{
    $resultado["existe"] = $existe;
    $resultado["data"] = array();
    while($row = $buscar->fetch(PDO::FETCH_ASSOC)){
        $data = array(
            "id_cliente" =>$row["id_cliente"],
            "cliente" =>$row["cliente"]
        );
        $resultado["data"][] = $data;
    }
}
echo json_encode($resultado);
?>