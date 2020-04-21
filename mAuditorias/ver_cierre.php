<?php
include "../conexion/conexion.php";
$id = $_POST["id"];
$datos = $conexion->query("SELECT puntuacion,comentarios_evidencia,fecha_cierre_plan FROM planes_auditorias WHERE id_plan  =$id AND activo = 0");
$row = $datos->fetch(PDO::FETCH_ASSOC);
?>
<div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Evidencia de cierre</h4>
                        <input type="hidden" name="id_plan" id="id_plan">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="puntuacion" class="control-label">Puntuación: </label>
                                <input type="number" min=0 max=100 name="puntuacion" value="<?php echo $row['puntuacion'];?>" readonly required id="puntuacion" class="form-control">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="evidencia" class="control-label">Fecha de cierre: </label>
                                <input type="text" value="<?php echo $row['fecha_cierre_plan'];?>" readonly id="evidencias" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="comentarios" class="control-label">Comentarios: </label>
                                <textarea name="comentarios" id="comentarios" cols="30" rows="5" readonly style="resize:none;"
                                    class="form-control"><?php echo $row['comentarios_evidencia'];?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Evidencias</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                $evidencias = $conexion->query("SELECT name,file_string FROM evidencias_planes_auditorias WHERE id_plan  =$id");
                                while($row = $evidencias->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <tr>
                                    <td class="text-center"><a href="download.php?f=<?php echo $row["file_string"];?>"><?php echo $row["name"];?></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" onclick="cerrar();">Cerrar</button>
                    </div>
                </div>

            </div>