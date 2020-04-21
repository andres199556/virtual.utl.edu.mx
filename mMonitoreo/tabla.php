<?php
include "../conexion/conexion.php";
//busco los datos
$registros = $conexion->query("SELECT
M.`id_ monitoreo`,
AF.no_activo_fijo,
US.ubicacion_secundaria,
M.estado_monitoreo,
AF.direccion_ip,
AF.direccion_mac,

IF (
AF.id_marca = 2,
'Genérica',
CONCAT(
    ME.nombre_marca,
    ' ',
    AF.modelo
)
) AS equipo,
AF.comentarios
FROM
monitoreos AS M
INNER JOIN activos_fijos AS AF ON M.id_activo = AF.id_activo_fijo
INNER JOIN marcas_equipos AS ME ON AF.id_marca = ME.id_marca
INNER JOIN ubicaciones_secundarias AS US ON AF.id_ubicacion_secundaria = US.id_ubicacion_secundaria");
$registros->execute();
$n = 0;
while($row = $registros->fetch(PDO::FETCH_ASSOC)){
    if($row["estado_monitoreo"] == 1){
        $estado = "<label class='badge badge-success m-r-10'>Monitoreo Activo</label>";
        $texto_cambiar = "Desactivar";
        $color_boton = "danger";
        $icono_e = "times";
        $estado_equipo = '<i class="fa fa-desktop text-success icon-'.$row["no_activo_fijo"].'"></i> <br><span class="label label-success texto-estado-'.$row["no_activo_fijo"].'">Encendido</span>';
        $editar = '<a href="editar.php?id='.$row[0].'" class="btn btn-primary btn-sm" title="Editar trabajador" data-toggle="tooltip"><i class="fas fa-edit"></i></a>';
        $permisos = '<a href="permisos.php?id='.$row[0].'" class="btn btn-info btn-sm" title="Ver historial de accesos" data-toggle="tooltip"><i class="fas fa-eye"> </i></a>';
    }
    else{
        $estado = "<label class='badge badge-danger m-r-10'>Sin monitorear</label>";
        $texto_cambiar = "Activar";
        $color_boton = "success";
        $icono_e = "plus";
        $estado_equipo = '<i class="fa fa-desktop text-danger"></i> <br><span class="label label-danger">Apagado</span></span>';
        $editar = '<button class="btn btn-disabled disabled btn-sm" title="El registro debe estar activo" data-toggle="tooltip"><i class="fas fa-edit"></i></button>';
        $permisos = '<button class="btn btn-disabled btn-sm"  title="El registro está inactivo" data-toggle="tooltip"><i class="fas fa-eye"> </i></button>';
    }
    $estado_equipo = '<span class="estado-equipo-'.$row["no_activo_fijo"].'"><i class="fa fa-desktop icon-'.$row["no_activo_fijo"].'"></i> <br><span class="label label-default texto-estado-'.$row["no_activo_fijo"].'"><i class="fa fa-spin fa-spinner"></i> Buscando . . .</span></span>';
    ++$n;
    ?>
    <tr data-id="<?php echo $row['no_activo_fijo'];?>">
        <td class="text-center"><?php echo $n;?></td>
        <td class="text-center"><?php echo $row["no_activo_fijo"];?></td>
        <td class="text-center"><?php echo $row["equipo"];?></td>
        <td class="text-center"><?php echo $row["direccion_mac"];?></td>
        <td class="text-center"><span class="direccion-ip" data-activo="<?php echo $row['no_activo_fijo'];?>"><?php echo $row["direccion_ip"];?></span></td>
        <td class="text-center"><?php echo $row["ubicacion_secundaria"];?></td>
        <td class="text-center"><?php echo $row["comentarios"];?></td>
        <td class="text-center"><?php echo $estado;?></td>
        <td class="text-center"><?php echo $estado_equipo;?></td>
        
        <td class="text-center">
        <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i> Acciones
                                    </button>
                                    <div class="dropdown-menu flipInX" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="javascript:wake('<?php echo $row['no_activo_fijo'];?>');" class="shut-<?php echo $row['no_activo_fijo'];?>"><i class="fa fa-power-off text-success"></i> Encender equipo</a>
                                        <a class="dropdown-item" href="ver.php?id=<?php echo $row['no_activo_fijo'];?>"><i class=" fa fa-eye text-primary"></i> Ver accesos</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-desktop text-info"></i> Ver equipo en tiempo real</a>
                                    </div>
                                </div>
        </td>
    </tr>
    <?php
}
?>