<form action="#" id="frmGenerarSalida">
<div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Salidas de efectivo</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label for="nombre_cliente" class="control-label">Cantidad a retirar: </label>
                                                            <input type="number" step="any" name="cantidad_retirar" required id="cantidad_retirar" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="nota" class="control-label">Nota de retiro: </label>
                                                            <textarea name="nota_retiro" id="nota" cols="30" rows="5" required class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit"   class="btn btn-info waves-effect" >Generar salida</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        </form>