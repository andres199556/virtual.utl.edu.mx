<div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Entradas directas de efectivo</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="nombre_cliente" class="control-label">Producto: </label>
                                                           
                                                            <input type="text" onkeypress="buscar_producto_form(this,event);" name="criterio_producto" id="criterio_producto" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table-hover table table-bordered color-table success-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Código</th>
                                                                        <th class="text-center">Descripción del producto</th>
                                                                        <th class="text-center">Inventario actual</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbody_productos">
                                                                    <tr>
                                                                        <td class="text-center" colspan=4>Esperando busqueda . . </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancelar</button>
                                                    <button type="button" onclick="agregar_producto_form();" disabled id="btn_seleccionar_producto" class="btn btn-disabled waves-effect" >Agregar producto [ENTER]</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>