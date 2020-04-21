<?php
include "../conexion/conexion.php";
$datos = array();
//busco los producos
$productos = $conexion->query("SELECT
M.id_modulo,
M.nombre_modulo,
CM.nombre_categoria,
M.descripcion,
M.icono,
M.activo
FROM
modulos AS M
INNER JOIN categoria_modulos AS CM ON M.id_categoria_modulo = CM.id_categoria_modulo
ORDER BY
M.nombre_modulo ASC");
while($row_productos = $productos->fetch(PDO::FETCH_NUM)){
    $sub_data = array();
    $sub_data[] = $row_productos[0];
    $sub_data[] = $row_productos[1];
    $sub_data[] = $row_productos[2];
    $sub_data[] = $row_productos[3];
    $sub_data[] = "<i class='".$row_productos[4]."'></i>";
    if($row_productos[5] == 0){
        $enlace = '<a disabled href="#" class="btn btn-default btn-sm" title="Para editar el producto primero debes de activarlo" data-toggle="tooltip"><i class="fa fa-edit"></i></a>';
    }
    else{
        $enlace = '<a href="editar.php?id='.$row_productos[0].'" class="btn btn-warning btn-sm" title="Editar producto" data-toggle="tooltip"><i class="fa fa-edit"></i></a>';
    }
    $sub_data[] = ($row_productos[5] == 1 ? '<a title="Haz clic para cambiar el estado" data-toggle="tooltip" href="estado.php?id='.$row_productos[0].'&estado='.$row_productos[5].'"><span class="label label-success m-r-10">Activo</span></a>':'<a title="Haz clic para cambiar el estado" data-toggle="tooltip" href="estado.php?id='.$row_productos[0].'&estado='.$row_productos[5].'"><span class="label label-danger m-r-10">Desactivado</span></a>');
    $sub_data[] = $enlace;
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