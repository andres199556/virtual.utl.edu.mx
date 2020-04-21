<?php
include "../conexion/conexion.php";
$datos = array();
//busco los producos
$productos = $conexion->query("SELECT
id_producto,
codigo,
sku,
nombre_producto,
(
    SELECT
        SUM(stock)
    FROM
        existencias_almacenes AS EAL
    WHERE
        EAL.id_producto = P.id_producto
) AS stock_global,
activo
FROM
productos AS P");
while($row_productos = $productos->fetch(PDO::FETCH_NUM)){
    $sub_data = array();
    $sub_data[] = $row_productos[0];
    $sub_data[] = $row_productos[1];
    $sub_data[] = $row_productos[2];
    $sub_data[] = $row_productos[3];
    $sub_data[] = $row_productos[4];
    if($row_productos[5] == 0){
        $enlace = '<a disabled href="#" class="btn btn-default btn-sm" title="Para editar el producto primero debes de activarlo" data-toggle="tooltip"><i class="fa fa-edit"></i></a>';
        $enlace_imagen = '<a disabled href="#" class="btn btn-default btn-sm" title="Para cambiar la imagen del producto, debes activarlo primero" data-toggle="tooltip"><i class="fa fa-image"></i></a>';
    }
    else{
        $enlace = '<a href="editar.php?id='.$row_productos[0].'" class="btn btn-warning btn-sm" title="Editar producto" data-toggle="tooltip"><i class="fa fa-edit"></i></a>';
        $enlace_imagen = '<a href="javascript:cambiar_imagen('.$row_productos[0].');" class="btn btn-inverse btn-sm" title="Cambiar imagen del producto" data-toggle="tooltip"><i class="fa fa-image"></i></a>';
    }
    $sub_data[] = ($row_productos[5] == 1 ? '<a title="Haz clic para cambiar el estado" data-toggle="tooltip" href="estado.php?id='.$row_productos[0].'&estado='.$row_productos[5].'"><span class="label label-success m-r-10">Activo</span></a>':'<a title="Haz clic para cambiar el estado" data-toggle="tooltip" href="estado.php?id='.$row_productos[0].'&estado='.$row_productos[5].'"><span class="label label-danger m-r-10">Desactivado</span></a>');
    $sub_data[] = '<a href="ver.php?id='.$row_productos[0].'" class="btn btn-info btn-sm" title="Ver información del producto" data-toggle="tooltip"><i class="fa fa-info"></i></a>';
    $sub_data[] = $enlace;
    $sub_data[] = $enlace_imagen;
    $datos[] = $sub_data;
    /* $datos[] = array(
        "id_producto" => $row_productos[0],
        "codigo" => $row_productos[1],
        "sku" => $row_productos[2],
        "nombre_producto" => $row_productos[3],
        "stock" => $row_productos[4],
        "activo" => $row_productos[5]
    ); */
}
$json_data = array(
    "data"=>$datos
);
echo json_encode($json_data);
?>