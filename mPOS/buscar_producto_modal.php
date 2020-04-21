<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
$criterio = $_POST["criterio"];
$resultado = array();
$id_almacen = 1;
$buscar = $conexion->query("SELECT
P.id_producto,
codigo,
nombre_producto,
(
    SELECT
        SUM(stock)
    FROM
        existencias_almacenes AS EP
    WHERE
        EP.id_producto = P.id_producto
) AS cantidad
FROM
productos AS P
WHERE P.codigo LIKE '%$criterio%' OR P.nombre_producto LIKE '%$criterio%'");
$existe = $buscar->rowCount();
if($existe == 0){
    $resultado["existe"]  =0;
}
else{
    $resultado["existe"]  =$existe;
    while($row = $buscar->fetch(PDO::FETCH_ASSOC)){
        $data = array(
            "id_producto" =>$row["id_producto"],
            "codigo" =>$row["codigo"],
            "nombre_producto" =>$row["nombre_producto"],
            "cantidad" =>$row["cantidad"]
        );
        $resultado["data"][] = $data;
    }
}
echo json_encode($resultado);

?>