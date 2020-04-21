<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$year = $_POST["year1"];
$month = $_POST["month1"];
if($month == 13){
    //son el total
    $qry = "SELECT
    A.id_accion,
    TA.nombre AS origen,
    DI.direccion,
    A.numero AS numero,
    A.descripcion,
    A.fecha_alta,
    DA.fecha_vencimiento,
    A.activo,
    EA.estado_accion
    FROM
    acciones AS A
    LEFT JOIN direcciones AS DI ON A.id_direccion = DI.id_direccion
    LEFT JOIN tipo_acciones AS TA ON A.id_tipo_accion = TA.id_tipo_accion
    LEFT JOIN detalle_acciones AS DA ON A.id_accion = DA.id_accion
    INNER JOIN estado_acciones as EA ON A.id_estado = EA.id_estado
    WHERE
    YEAR (A.fecha_alta) = $year";
}
else{
    $qry = "SELECT
    A.id_accion,
    TA.nombre AS origen,
    DI.direccion,
    A.numero AS numero,
    A.descripcion,
    A.fecha_alta,
    DA.fecha_vencimiento,
    A.activo,
    EA.estado_accion
    FROM
    acciones AS A
    LEFT JOIN direcciones AS DI ON A.id_direccion = DI.id_direccion
    LEFT JOIN tipo_acciones AS TA ON A.id_tipo_accion = TA.id_tipo_accion
    LEFT JOIN detalle_acciones AS DA ON A.id_accion = DA.id_accion
    INNER JOIN estado_acciones as EA ON A.id_estado = EA.id_estado
    WHERE
    YEAR (A.fecha_alta) = $year
    AND MONTH (A.fecha_alta) = $month";
}
//busco las acciones
$acciones = $conexion->query($qry);
$n = 0;
while($row = $acciones->fetch(PDO::FETCH_ASSOC)){
    $n++;
    $dias = 0;
    $activo = 1;
    ?>
    <tr>
        <td class="text-center"><?php echo $n;?></td>
        <td class="text-center"><?php echo $row["origen"];?></td>
        <td class="text-center"><?php echo $row["numero"];?></td>
        <td class="text-center"><?php echo $row["direccion"];?></td>
        <td class="text-center"><?php echo $row["descripcion"];?></td>
        <td class="text-center"><?php echo $row["fecha_alta"];?></td>
        <td class="text-center"><?php echo $dias;?></td>
        <td class="text-center"><?php echo $row["estado_accion"];?></td>
        <td class="text-center">
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm dropdown-toggle btn-opciones-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cog"></i> Opciones
            </button>
            <div class="dropdown-menu">
                <a style="cursor:pointer;" href="accion.php?id=<?php echo $row['id_accion'];?>" class="dropdown-item link-informacion" data-id="1"><i class="fa fa-eye text-success"></i> Ver acción</a>
                <a style="cursor:pointer;" href="historial.php?id=<?php echo $row['id_accion'];?>" class="dropdown-item link-password" data-id="1"><i class="fa fa-history text-info"></i> Ver historial de acción</a>
            </div>
        </div>
        </td>
    </tr>
    <?php
}
?>