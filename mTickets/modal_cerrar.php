<?php
$ticket = $_GET["ticket"];
?>
<div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Cerrar ticket de servicio</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                                       <div class="form-group">
                                                       <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
                                                        <label for="message-text" class="control-label">Escribe la nota o mensaje de cierre:</label>
                                                        <textarea class="form-control" rows="6" id="message-text" required name="respuesta_cierre"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="evidencia" class="control-label">Agregar evidencias</label>
                                                        <input type="file" multiple name="evidencias[]" id="evidencia">
                                                    </div>
                                                   <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <input type="checkbox" name="notificar_cierre" value="1" class="filled-in" id="notificar" onclick="habilitar_fechas(this);">
                                                            <label for="notificar">Notificar al solicitante.</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <input type="checkbox" name="verificar_cierre" value="1" class="filled-in" id="verificacion" onclick="habilitar_fechas(this);">
                                                            <label for="verificacion">Esperar verificación de cierre.</label>
                                                        </div>
                                                    </div>
                                                    <!-- <div id="canvasDiv" style=" background: #f0c0f0;">
                                                        <canvas id='c' style = 'position: relative; left: 0px; top: 0px; background: #ff0000;' ></canvas>
                                                    </div> -->
                                                    
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Cerrar ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                    