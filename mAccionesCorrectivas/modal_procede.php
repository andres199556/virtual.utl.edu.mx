<?php
include "../conexion/conexion.php";
$id = $_GET["id"];
?>
<form action="procede.php" method="post" class="frmProcede">
    <div class="modal-dialog modal-lg">
<input type="hidden" name="id_accion" value="<?php echo $id;?>">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Proceder acción</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="responsable" class="control-label"><b><strong>Responsable:</strong></b> </label>
                        <select name="id_responsable" id="id_responsable" class="form-control">
                            <?php
            $trabajadores = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno ) as usuario
            FROM trabajadores as T
            INNER JOIN personas as P ON T.id_persona = P.id_persona
            INNER JOIN usuarios as U ON P.id_persona = U.id_persona
            WHERE T.activo = 1 AND U.activo = 1");
            while($row = $trabajadores->fetch(PDO::FETCH_ASSOC)){
                ?>
                            <option value="<?php echo $row['id_usuario'];?>"><?php echo $row["usuario"];?></option>
                            <?php
            }
            ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="responsable" class="control-label"><b><strong>Verificador:</strong></b> </label>
                        <select name="verificador" id="verificador" class="form-control">
                            <?php
            $trabajadores = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno ) as usuario
            FROM trabajadores as T
            INNER JOIN personas as P ON T.id_persona = P.id_persona
            INNER JOIN usuarios as U ON P.id_persona = U.id_persona
            WHERE T.activo = 1 AND U.activo = 1");
            while($row = $trabajadores->fetch(PDO::FETCH_ASSOC)){
                ?>
                            <option value="<?php echo $row['id_usuario'];?>"><?php echo $row["usuario"];?></option>
                            <?php
            }
            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4 form-group">

                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </div>

    </div>
</form>