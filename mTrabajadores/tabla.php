<?php
include "../conexion/conexion.php";
//busco los datos
$registros = $conexion->prepare("SELECT
	T.id_trabajador,
	concat(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS trabajador,
	D.departamento,
	DI.direccion,
	T.no_empleado,
	T.correo,
	T.activo,
    U.usuario_red
FROM
	trabajadores AS T
INNER JOIN personas AS P ON T.id_persona = P.id_persona
INNER JOIN departamentos AS D ON T.id_departamento = D.id_departamento
INNER JOIN usuarios as U ON P.id_persona = U.id_persona
INNER JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion");
$registros->execute();
$n = 0;
while($row = $registros->fetch(PDO::FETCH_NUM)){
    $usuario_red = $row[7];
    $icon = ($usuario_red == 0) ? "":"<img src='../images/icons/zentyal.png' title='Cuenta con usuario de red' data-toggle='tooltip'>";
    if($row[6] == 1){
        $estado = "<label class='badge badge-success m-r-10'>Activo</label>";
        $texto_cambiar = "Desactivar";
        $color_boton = "danger";
        $icono_e = "times";
        $editar = '<a href="editar.php?id='.$row[0].'" class="btn btn-primary btn-sm" title="Editar trabajador" data-toggle="tooltip"><i class="fas fa-edit"></i></a>';
        $permisos = '<a href="permisos.php?id='.$row[0].'" class="btn btn-info btn-sm" title="Asignar permisos" data-toggle="tooltip"><i class="fas fa-wrench"> </i></a>';
    }
    else{
        $estado = "<label class='badge badge-danger m-r-10'>Inactivo</label>";
        $texto_cambiar = "Activar";
        $color_boton = "success";
        $icono_e = "plus";
        $editar = '<button class="btn btn-disabled disabled btn-sm" title="El registro debe estar activo" data-toggle="tooltip"><i class="fas fa-edit"></i></button>';
        $permisos = '<button class="btn btn-disabled btn-sm"  title="El registro está inactivo" data-toggle="tooltip"><i class="fas fa-wrench"> </i></button>';
    }
    ++$n;
    ?>
<tr>
    <td class="text-center"><?php echo $n;?></td>
    <td class="text-center"><?php echo $icon;?> <?php echo $row[1];?></td>
    <td class="text-center"><?php echo $row[2];?></td>
    <td class="text-center"><?php echo $row[3];?></td>
    <td class="text-center"><?php echo $row[4];?></td>
    <td class="text-center"><?php echo $row[5];?></td>
    <td class="text-center"><?php echo $estado;?></td>
    
    <td class="text-center"><?php echo $editar;?></td>
    <td class="text-center"><a class="btn btn-<?php echo $color_boton;?> btn-sm" title="<?php echo $texto_cambiar;?>"
            data-toggle="tooltip" href="estado.php?id=<?php echo $row[0];?>&estado=<?php echo $row[6];?>"><i
                class="fas fa-<?php echo $icono_e;?>"></i></a></td>
    <td class="text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm dropdown-toggle btn-opciones-<?php echo $row[0];?>"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i> Opciones
            </button>
            <div class="dropdown-menu">
                <span style="cursor:pointer;" href="#" class="dropdown-item link-informacion"
                    data-id="<?php echo $row[0];?>"><i class="fa fa-edit text-success"></i> Llenar información</span>
                <span style="cursor:pointer;" href="#" class="dropdown-item link-password"
                    data-id="<?php echo $row[0];?>"><i class="fa fa-lock text-danger"></i> Restablecer contraseña</span>
                    <span style="cursor:pointer;" href="#" class="dropdown-item link-permisos"
                    data-id="<?php echo $row[0];?>"><i class="fa fa-wrench text-info"></i> Asignar permisos</span>
                <!-- <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a> -->
            </div>
        </div>
    </td>
</tr>
<?php
}
?>
<script>
$('.js-switch').each(function() {
    new Switchery($(this)[0], $(this).data());
});
</script>