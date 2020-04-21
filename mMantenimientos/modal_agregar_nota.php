<?php
include "../conexion/conexion.php";
$id_plan = $_POST["id_plan"];
?>
<form action="#" id="frmNota">
  <div class="modal-header">
    <h4 class="modal-title">Agregar nota</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col-md-12 form-group">
            <input type="hidden" name="id_plan_individual" value="<?php echo $id_plan;?>">
              <label for="nota" class="control-label">Nota: </label>
              <textarea name="nota" id="nota" cols="30" rows="5" class="form-control"></textarea>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 form-group">
          <input type="checkbox" checked name="enviar_correo_a" value="1" class="filled-in" id="enviar_correo">
          <label for="enviar_correo">Enviar notificación al administrativo por correo.</label>
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="cerrar_modal();">Cancelar</button>
    <button type="submit" class="btn btn-success" id="btn_actualizar">Agregar nota</button>
  </div>
</form>
<script>
    $("select").select2({
        width:'100%'
    });
    $("#frmNota").submit(function(e){
    $.ajax({
        url:"guardar_nota.php",
        type:"POST",
        dataType:"json",
        data:$(this).serialize(),
        beforeSend:function(resultado){
          $("#btn_actualizar").prop("disabled",true);
          $("#btn_actualizar").html("<i class='fa fa-spinner fa-spin'></i> Guardando cambios");
        }
    }).done(function(res){
      var resultado = res["resultado"];
      if(resultado == "exito_nota"){
        location.reload();
      }
      else if(resultado == "exito_completo"){
        $.toast({
                heading: "Exito!",
                text: "La nota se ha agregado correctamente!.",
                position: 'top-right',
                loaderBg:"#1E8449",
                icon: "success",
                hideAfter: 3000, 
                stack: 6
            });
      }
      else if(resultado == "exito_parcial"){
        $.toast({
                heading: "Exito",
                text: "La nota se ha agregado, pero no el correo no ha podido ser enviado.",
                position: 'top-right',
                loaderBg:"#1E8449",
                icon: "warning",
                hideAfter: 3000, 
                stack: 6
            });
      }
      else if(resultado == "error"){
        $.toast({
                heading: "Error",
                text: "Se ha enviado la notificación de mantenimiento al usuario!.",
                position: 'top-right',
                loaderBg:"#1E8449",
                icon: "danger",
                hideAfter: 3000, 
                stack: 6
            });
      }
      $("#modal_action").modal("hide");
    }).fail(function(error){
        alert("Error");
    });
    e.preventDefault();
    return false;
});
</script>