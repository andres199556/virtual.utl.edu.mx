<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_direccion = $_POST["id_direccion"];
$id_tipo_documento = $_POST["id_tipo_documento"];
$id_departamento = $_POST["id_departamento"];
$documentos = $conexion->query("SELECT
D.id_documento,
D.codigo,
DD.titulo,
DD.version,
DD.comentarios,
DD.fecha_vigencia,
CONCAT(
    P.nombre,
    ' ',
    P.ap_paterno,
    ' ',
    P.ap_materno
) AS responsable,
DD.filepath,
DD.file_string
FROM
documentos AS D
INNER JOIN detalle_documentos AS DD ON D.id_documento = DD.id_documento
INNER JOIN usuarios AS U ON DD.id_responsable = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
WHERE
D.id_tipo_documento = $id_tipo_documento
AND D.id_direccion = $id_direccion
AND D.id_departamento = $id_departamento
AND DD.activo = 1");
$cuerpo = "";

while($row = $documentos->fetch(PDO::FETCH_NUM)){
    $download = "<a href='download.php?file=$row[8]'>$row[2]</a>";
            $ver = "<a href='ver.php?id=$row[0]' class='btn btn-sm btn-inverse' title='Ver historial de versiones' data-toggle='tooltip'><i class='fa fa-bars'></i></a>";
    switch($id_tipo_documento){
        case 8:
            //el documento esta en la parte de obsoletos, por lo tanto, cambian las opciones, 
            $nueva_version = "<button  class='btn btn-sm btn-disabled' disabled title='Cargar nueva versión' data-toggle='tooltip'><i class='fa fa-upload'></i></button>";
            $obsoleto = "<a href='javascript:habilitar($row[0]);' class='btn btn-sm btn-success' title='Volver a habilitar' data-toggle='tooltip'><i class='fa fa-check'></i></a>";
            $editar = "<button  class='btn btn-sm btn-disabled' disabled title='Editar' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";

        break;
        default:
        $nueva_version = "<a href='nueva_version.php?id=$row[0]' class='btn btn-sm btn-primary' title='Cargar nueva versión' data-toggle='tooltip'><i class='fa fa-upload'></i></a>";
        $obsoleto = "<a href='javascript:enviar_obsoletos($row[0]);' class='btn btn-sm btn-warning' title='Enviar a documentos obsoletos' data-toggle='tooltip'><i class='fa fa-times'></i></a>";
        $editar = "<a href='editar.php?id=$row[0]' class='btn btn-sm btn-info' title='Editar' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
        break;
    }
    if($permiso_acceso == 2){
        $nueva_version = "";
            $obsoleto = "";
            $editar = "";
            $renglon = "
		{
		\"id_documento\": \"$row[0]\",
        \"codigo\": \"$row[1]\",
        \"titulo\": \"$download\",
        \"version\": \"$row[3]\",
        \"comentarios\": \"$row[4]\",
        \"fecha_vigencia\": \"$row[5]\",
        \"responsable\": \"$row[6]\",
        \"ver\": \"$ver\"
		},";
    }
    else if($permiso_acceso == 1){
        $renglon = "
		{
		\"id_documento\": \"$row[0]\",
        \"codigo\": \"$row[1]\",
        \"titulo\": \"$download\",
        \"version\": \"$row[3]\",
        \"comentarios\": \"$row[4]\",
        \"fecha_vigencia\": \"$row[5]\",
        \"responsable\": \"$row[6]\",
        \"nueva_version\": \"$nueva_version\",
        \"editar\": \"$editar\",
        \"obsoleto\": \"$obsoleto\",
        \"ver\": \"$ver\"
		},";
    }
	$cuerpo = $cuerpo.$renglon;
}
$cuerpo2 = trim($cuerpo, ',');

$tabla = "
["
.$cuerpo2.
"]
";
echo $tabla;
?>