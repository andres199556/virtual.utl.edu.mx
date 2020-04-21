<?php
include "../conexion/conexion.php";
//busco los datos
$modulos = $conexion->prepare("SELECT
	D.id_activo_fijo,
	CAF.consecutivo_activo_fijo,
	M.nombre_marca,
	D.modelo,
	D.no_serie,
	D.activo,
    D.no_activo_fijo,
    D.direccion_mac,
    CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable
FROM
	activos_fijos AS D
INNER JOIN consecutivos_activos_fijos as CAF ON D.id_consecutivo_activo_fijo = CAF.id_consecutivo_activo_fijo
INNER JOIN marcas_equipos AS M ON M.id_marca = D.id_marca
LEFT JOIN asignacion_activos_fijos as AAF ON D.id_activo_fijo = AAF.id_activo_fijo
LEFT JOIN usuarios as U ON AAF.id_usuario = U.id_usuario
LEFT JOIN personas as P ON P.id_persona = U.id_persona
");
$modulos->execute();
$n = 0;
while($row = $modulos->fetch(PDO::FETCH_NUM)){
    $responsable = $row[8];
    //activo
    if($row[5] == 1){
        $estado = "<label class='badge badge-success m-r-10'>Activo</label>";
        $texto_cambiar = "Desactivar";
        $color_boton = "danger";
        $icono_e = "times";
        $ver = '<a href="#" title="Ver información del equipo" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
        $editar = '<a href="editar.php?id=<?php echo $row[0];?>" class="btn btn-primary btn-sm" title="Editar información" data-toggle="tooltip"><i class="fas fa-edit"></i></a>';
        $acciones = '<a href="#" class="btn btn-sm btn-danger" title="Eliminar" data-toggle="tooltip"><i class="fas fa-minus"></i></a>';
    }
    else{
        $estado = "<label class='badge badge-danger m-r-10'>Inactivo</label>";
        $texto_cambiar = "Activar";
        $color_boton = "success";
        $icono_e = "plus";
        $ver = '<button title="El registro debe estar activo" data-toggle="tooltip" class="btn btn-sm btn-disabled"><i class="fas fa-eye"></i></button>';
        $editar = '<button  class="btn btn-disabled btn-sm" title="El registro debe estar activo" data-toggle="tooltip"><i class="fas fa-edit"></i></button>';
        $acciones = '<button class="btn btn-sm btn-disabled" title="El registro debe estar activo" data-toggle="tooltip"><i class="fas fa-minus"></i></button>';
    }
    ++$n;
    ?>
    <tr>
        <td class="text-center"><?php echo $n;?></td>
        <td class="text-center"><?php echo $row[1];?></td>
        <td class="text-center"><?php echo $row[6];?></td>
        <td class="text-center"><?php echo $row[2];?></td>
        <td class="text-center"><?php echo $row[3];?></td>
        <td class="text-center"><?php echo $responsable;?></td>
        <td class="text-center"><?php echo $estado;?></td>
        <td class="text-center">
            <?php echo $ver;?>
        </td>
        <td class="text-center">
        <?php echo $editar;?>
        </td>
        <td class="text-center"><a class="btn btn-<?php echo $color_boton;?> btn-sm" title="<?php echo $texto_cambiar;?>" data-toggle="tooltip" href="estado.php?id=<?php echo $row[0];?>&estado=<?php echo $row[5];?>"><i class="fas fa-<?php echo $icono_e;?>"></i></a></td>
        <td class="text-center">
        <?php echo $acciones;?>
        </td>
    </tr>
    <?php
}
?>