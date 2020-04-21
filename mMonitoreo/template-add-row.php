<tr>
    <td class="text-center">.</td>
    <td class="text-center"><select class="form-control" name="id_tipo_bloqueo" id="id_tipo_bloqueo" readonly>
        <option value="2">Equipo en específico</option>     
    </select></td>
    <td class="text-center">
        <select name="tipo_filtrado" id="tipo_filtrado" class="form-control">
            <option value="1">Por dominio</option>
            <option value="0">Por palabra</option>
        </select>
    </td>
    <td class="text-center">
        <input id="txtString" type="text" name="string"  class="form-control" required>
    </td>
    <td class="text-center">

    </td>
    <td class="text-center" colspan="2">
        <button class="btn btn-success btnAddRow" title="Guardar regla"><i class="fa fa-save"></i></button>
        <button class="btn btn-warning btnCancelRow" title="Cancelar"><i class="fa fa-times"></i></button>
    </td>
</tr>