<?php
include "../conexion/conexion.php";
$ticket = $_GET["ticket"];
?>
<div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Cambiar estado de servicio</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                                      <div class="row">
                                                          <div class="form-group col-md-12">
                                                              <label for="">Nuevo estado:</label>
                                                              <select name="id_estado" id="" class="form-control">
                                                                  <?php
                                                                  $estados = $conexion->prepare("SELECT id_estado_ticket,estado_ticket FROM estado_tickets");
                                                                  $estados->execute();
                                                                  while($row = $estados->fetch(PDO::FETCH_NUM)){
                                                                      echo "<option value=$row[0]>$row[1]</option>";
                                                                  }
                                                                  ?>
                                                              </select>
                                                          </div>
                                                      </div>
                                                       <div class="form-group">
                                                       <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
                                                        <label for="message-text" class="control-label">Comentarios respecto al cambio de estado:</label>
                                                        <textarea class="form-control" id="message-text" required name="comentarios"></textarea>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Cambiar estado</button>
                                            </div>
                                        </div>
                                    </div>
                                    