<?php
include "../conexion/conexion.php";
$codigo = $_POST["codigo"];
//busco los datos del producto
$datos = $conexion->query("SELECT id_producto,nombre_producto,codigo,iva,imagen_producto
FROM productos
WHERE codigo = '$codigo'");
$existe = $datos->rowCount();
$json_data = array();
if($existe == 0){
    $json_data["existe"] = 0;
    $json_data["mensaje"] = "No existe un producto con ese codigo";
}
else{
    $row_datos = $datos->fetch(PDO::FETCH_ASSOC);
    $json_data["existe"] = 1;
    $json_data["id_producto"] = $row_datos["id_producto"];
    $json_data["nombre_producto"] = $row_datos["nombre_producto"];
    $json_data["codigo"] = $row_datos["codigo"];
    $json_data["iva"] = $row_datos["iva"];
    $json_data["imagen_producto"] = $row_datos["imagen_producto"];
    $json_data["precios"] = array();
    //busco los precios
    $id_producto = $row_datos["id_producto"];
    $precios = $conexion->query("SELECT id_precio,nombre_precio,precio
    FROM precios_productos
    WHERE id_producto = $id_producto");

    while($row_precios = $precios->fetch(PDO::FETCH_NUM)){
        $array_precios = array(
            "id_precio" => $row_precios[0],
            "nombre_precio" => $row_precios[1],
            "precio" => $row_precios[2]
        );
        $json_data["precios"][] = $array_precios;
    }
}
echo json_encode($json_data);
?>