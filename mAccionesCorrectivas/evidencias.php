<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
try{
    $detalle = $conexion->query("SELECT AC.id_actividad, AC.comentarios_cierre,DA.id_verificador,AC.activo,AC.fecha_verificacion,comentarios_verificador
    FROM actividades as AC
    INNER JOIN detalle_acciones as DA ON AC.id_accion = DA.id_accion
    WHERE AC.id_actividad = $id");
    $row_detalle = $detalle->fetch(PDO::FETCH_ASSOC);
    $comentarios = $row_detalle["comentarios_cierre"];
    $id_actividad = $row_detalle["id_actividad"];
    $id_verificador = $row_detalle["id_verificador"];
    $estado = $row_detalle["activo"];
    $comentarios_verificador = $row_detalle["comentarios_verificador"];
    $fecha_verificacion = $row_detalle["fecha_verificacion"];
    ?>
<div class="modal-header">
    <h4 class="modal-title">Evidencias de cierre</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="comentarios" class="control-label"><b><strong>Comentarios del cierre: </strong></b></label>
            <textarea name="" id="comentarios" cols="30" rows="5" class="form-control"
                readonly="readonly"><?php echo $comentarios;?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered color-table success-table">
                    <thead>
                        <tr>
                            <th class="text-center" colspan=3>Evidencias</th>
                        </tr>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Evidencia</th>
                            <th class="text-center">Descargar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                $n = 0;
                
                $evidencias = $conexion->query("SELECT id_evidencia,name,file_string
                FROM evidencias_actividades
                WHERE id_actividad = $id_actividad");
                while($row = $evidencias->fetch(PDO::FETCH_ASSOC)){
                    $n++;
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $n;?></td>
                            <td class="text-center"><?php echo $row["name"];?></td>
                            <td class="text-center"><a href="download.php?file=<?php echo $row['file_string'];?>"
                                    title="Descargar" data-toggle="tooltip" class="btn btn-success btn-sm"><i
                                        class="fa fa-download"></i></a></td>
                        </tr>
                        <?php
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    if($estado == 0){
        //ya esta cerrada
        ?>
        <div class="row">
        <div class="col-md-12 form-group">
        <label for="" class="control-label"><b><strong>Fecha de verificación: </strong></b> <?php echo $fecha_verificacion;?></label>
        <label for="comentarios" class="control-label">Comentarios del verificador: </label>
        <textarea name="" readonly id="comentarios" cols="30" rows="3" class="form-control"><?php echo $comentarios_verificador;?></textarea>
        </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="modal-footer">
    <?php
if($id_verificador == $id_usuario_logueado){
    if($estado != 0){
        //se encuentra abierta
        //voy a verificar
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" id="btnRechazar_<?php echo $id_actividad;?>" onclick="rechazar(<?php echo $id_actividad;?>);"
        class="btn btn-danger"><i class="fa fa-times"></i> Rechazar</button>
    <button type="button" class="btn btn-success btnValidarActividad" onclick="liberar(<?php echo $id_actividad;?>);"><i class="fa fa-check"></i> Validar</button>
    <?php
    }
    else{
        //ya esta cerrada
        //voy a verificar
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <?php
    }
}
else{
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <?php
}
?>

</div>

<?php
}
catch(PDOException $error){
    echo $error->getMessage();
}
?>