<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$criterio = $_POST["criterio"];
$filtros = $_POST["filtros"];
$condicion = "(";
$cantidad_filtros = count($filtros);
$n = 1;
if($cantidad_filtros == 0){

}
else{
    foreach($filtros as $filtro){
        if($n < $cantidad_filtros){
            if($filtro == "responsable"){
                $condicion.="P.nombre LIKE '%".$criterio."%' OR P.ap_materno LIKE '%".$criterio."%' OR P.ap_materno LIKE '%".$criterio."%' OR";
            }
            else{
                $condicion.=$filtro." LIKE '%".$criterio."%' OR ";
            }
            
        }
        else{
            if($filtro == "responsable"){
                $condicion.="P.nombre LIKE '%".$criterio."%' OR P.ap_materno LIKE '%".$criterio."%' OR P.ap_materno LIKE '%".$criterio."%')";
            }
            else{
                $condicion.=$filtro." LIKE '%".$criterio."%')";
            }
        }
        $n++;
    }
}
try{
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
	DD.file_string,
	DI.direccion,
	DE.departamento,
	TD.tipo_documento,

IF (
	P.nombre LIKE '%$criterio%',
	'responsable',

IF (
	P.ap_paterno LIKE '%$criterio%',
	'responsable',

IF (
	P.ap_materno LIKE '%$criterio%',
	'responsable',

IF (
	DI.direccion LIKE '%$criterio%',
	'direccion',

IF (
	DE.departamento LIKE '%$criterio%',
	'departamento',

IF (
	DD.titulo LIKE '%$criterio%',
	'título',

IF (
	D.codigo LIKE '%$criterio%',
	'código',

IF (
	DD.comentarios LIKE '%$criterio%',
	'comentarios',

IF (
	TD.tipo_documento LIKE '%$criterio%',
	'tipo de documento',
	'todas'
)
)
)
)
)
)
)
)
) AS coincidencia
FROM
	documentos AS D
INNER JOIN detalle_documentos AS DD ON D.id_documento = DD.id_documento
AND DD.activo = 1
INNER JOIN usuarios AS U ON DD.id_responsable = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion
INNER JOIN departamentos AS DE ON D.id_departamento = DE.id_departamento
INNER JOIN tipo_documentos AS TD ON D.id_tipo_documento = TD.id_tipo_documento
WHERE
$condicion AND D.activo = 1
GROUP BY
	D.id_documento");
$cantidad = $documentos->rowCount();
if($cantidad == 0){

}
else{
    $co = 0;
    while($row = $documentos->fetch(PDO::FETCH_ASSOC)){
        $download = "<a href='download.php?file=".$row["file_string"]."'>".$row["titulo"]."</a>";
            $ver = "<a href='ver.php?id=".$row["id_documento"]."' class='btn btn-sm btn-inverse' title='Ver historial de versiones' data-toggle='tooltip'><i class='fa fa-bars'></i></a>";
    switch($id_tipo_documento){
        case 8:
            //el documento esta en la parte de obsoletos, por lo tanto, cambian las opciones, 
            $nueva_version = "<button  class='btn btn-sm btn-disabled' disabled title='Cargar nueva versión' data-toggle='tooltip'><i class='fa fa-upload'></i></button>";
            $obsoleto = "<a href='javascript:habilitar(".$row["id_documento"].");' class='btn btn-sm btn-success' title='Volver a habilitar' data-toggle='tooltip'><i class='fa fa-check'></i></a>";
            $editar = "<button  class='btn btn-sm btn-disabled' disabled title='Editar' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";

        break;
        default:
        $nueva_version = "<a href='nueva_version.php?id=".$row["id_documento"]."' class='btn btn-sm btn-primary' title='Cargar nueva versión' data-toggle='tooltip'><i class='fa fa-upload'></i></a>";
        $obsoleto = "<a href='javascript:enviar_obsoletos(".$row["id_documento"].");' class='btn btn-sm btn-warning' title='Enviar a documentos obsoletos' data-toggle='tooltip'><i class='fa fa-times'></i></a>";
        $editar = "<a href='editar.php?id=".$row["id_documento"]."' class='btn btn-sm btn-info' title='Editar' data-toggle='tooltip'><i class='fa fa-edit'></i></a>";
        break;
    }
        $co++;
        ?>
        <tr>
            <td class="text-center"><?php echo $co;?></td>
            <td class="text-center"><?php echo $row["direccion"];?></td>
            <td class="text-center"><?php echo $row["departamento"];?></td>
            <td class="text-center"><?php echo $row["tipo_documento"];?></td>
            <td class="text-center"><strong><b><?php echo ucwords($row["coincidencia"]);?></b></strong></td>
            <td class="text-center"><?php echo $row["codigo"];?></td>
            <td class="text-center"><?php echo $download;?></td>
            <td class="text-center"><?php echo $row["version"];?></td>
            <td class="text-center"><?php echo $row["comentarios"];?></td>
            <td class="text-center"><?php echo $row["fecha_vigencia"];?></td>
            <td class="text-center"><?php echo $row["responsable"];?></td>
            <?php
            if($permiso_acceso == 1){
                ?>
                <td class="text-center"><?php echo $nueva_version;?></td>
                <td class="text-center"><?php echo $editar;?></td>
                <td class="text-center"><?php echo $obsoleto;?></td>
                <?php
            }
            ?>
            <td class="text-center"><?php echo $ver;?></td>
        </tr>
        <?php
    }
}
}
catch(PDOException $error){
    echo $error->getMessage();
}

?>