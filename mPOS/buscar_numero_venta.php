<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
$resultado = array();
$buscar = $conexion->query("SELECT MAX(id_venta)
FROM ventas");
$datos = $buscar->fetch(PDO::FETCH_NUM);
$id_venta_siguiente = $datos[0] + 1;
$resultado["id_venta"] = $id_venta_siguiente;
echo json_encode($resultado);
?>