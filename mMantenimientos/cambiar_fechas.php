<?php
$id_plan = $_POST["id_plan"];
?>
<form action="#" id="frmActualizarFechas">
  <div class="modal-header">
    <h4 class="modal-title">Actualizar fechas del mantenimiento</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col-md-12 form-group">
            <input type="hidden" name="id_plan_individual" value="<?php echo $id_plan;?>">
              <label for="nueva_fecha" class="control-label">Nueva fecha para el mantenimiento: </label>
              <input type="text" name="nueva_fecha" required id="nueva_fecha" class="form-control">
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 form-group">
            <label for="comentarios_nuevos" class="control-label">Comentarios: </label>
            <textarea name="comentarios" id="comentarios_nuevos" cols="30" rows="5" style="resize:none;" class="form-control"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 form-group">
          <input type="checkbox" checked name="enviar_correo" value="1" class="filled-in" id="enviar_correo">
          <label for="enviar_correo">Enviar correo al usuario notificando el cambio.</label>
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="cerrar_modal();">Cancelar</button>
    <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar fechas</button>
  </div>
</form>

<script>
  $("#frmActualizarFechas").submit(function(e){
    $.ajax({
        url:"actualizar_fechas.php",
        type:"POST",
        dataType:"json",
        data:$(this).serialize(),
        beforeSend:function(resultado){
          $("#btn_actualizar").prop("disabled",true);
          $("#btn_actualizar").html("<i class='fa fa-spinner fa-spin'></i> Guardando cambios");
        }
    }).done(function(e){
        alert(JSON.stringify(e));
    }).fail(function(error){
        alert("Error");
    });
    e.preventDefault();
    return false;
});
</script>