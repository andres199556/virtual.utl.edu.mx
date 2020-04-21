<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
$id_tipo_documento = $_POST["id_tipo_documento"];
$categoria = $_POST["categoria"];
$direcciones = $conexion->query("SELECT
DI.id_direccion,
DI.direccion,
(
    SELECT
        count(DOC.id_documento)
    FROM
        documentos AS DOC
    WHERE
        DOC.id_direccion = DI.id_direccion
    AND DOC.id_tipo_documento = $id_tipo_documento AND DOC.activo = 1
) AS cantidad_documentos,
TD.tipo_documento
FROM
documentos AS D
INNER JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion
INNER JOIN tipo_documentos as TD ON D.id_tipo_documento = TD.id_tipo_documento
WHERE
D.id_tipo_documento = $id_tipo_documento
HAVING
cantidad_documentos > 0");
$existe = $direcciones->rowCount();
$resultado = array();
$resultado["data"] = array();
if($existe == 0){
    $resultado["resultado"] = "no_existen";
    $row = $direcciones->fetch(PDO::FETCH_NUM);
    $resultado["mensaje"] = "No existen documentos activos en la categoría de ".$categoria.".";
}
else{
    while($row = $direcciones->fetch(PDO::FETCH_NUM)){
        $resultado["data"][] = $row;
    }
}
echo json_encode($resultado);
?>