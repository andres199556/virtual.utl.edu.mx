<?php
include "../conexion/conexion.php";
include "../sesion/validar_sesion.php";
$id_tipo_documento = $_POST["id_tipo_documento"];
$id_direccion = $_POST["id_direccion"];
$departamentos = $conexion->query("SELECT
DE.id_departamento,
DE.departamento,
(
    SELECT
        count(DOC.id_documento)
    FROM
        documentos AS DOC
    WHERE
        DOC.id_departamento = DE.id_departamento
    AND DOC.id_tipo_documento = $id_tipo_documento AND DOC.activo = 1 AND DOC.id_direccion = $id_direccion
) AS cantidad_documentos,
TD.tipo_documento
FROM
documentos AS D
INNER JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion
INNER JOIN departamentos as DE ON D.id_departamento = DE.id_departamento
INNER JOIN tipo_documentos as TD ON D.id_tipo_documento = TD.id_tipo_documento
WHERE
D.id_tipo_documento = $id_tipo_documento AND D.id_direccion = $id_direccion
HAVING
cantidad_documentos > 0");
$existe = $departamentos->rowCount();
$resultado = array();
$resultado["data"] = array();
if($existe == 0){
    $resultado["resultado"] = "no_existen";
    $row = $departamentos->fetch(PDO::FETCH_NUM);
    $resultado["mensaje"] = "No existen documentos activos en la categoría de ".$categoria.".";
}
else{
    while($row = $departamentos->fetch(PDO::FETCH_NUM)){
        $resultado["data"][] = $row;
    }
}
echo json_encode($resultado);
?>