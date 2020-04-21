<?php
include "../conexion/conexion.php";
$id_plan = $_POST["id_plan"];
?>
<form action="#" id="frmResponsable">
  <div class="modal-header">
    <h4 class="modal-title">Asignar responsansable de mantenimiento</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col-md-12 form-group">
            <input type="hidden" name="id_plan_individual" value="<?php echo $id_plan;?>">
              <label for="id_responsable" class="control-label">Responsable de mantenimiento: </label>
              <select name="id_responsable" id="id_responsable" >
                  <?php
                  $usuarios = $conexion->query("SELECT U.id_usuario,
                  CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
                  FROM usuarios as U
                  INNER JOIN personas as P ON U.id_persona = P.id_persona
                  INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
                  WHERE T.activo = 1 AND P.activo = 1 AND U.activo = 1");
                  while($row_u = $usuarios->fetch(PDO::FETCH_NUM)){
                      echo "<option value=$row_u[0]>$row_u[1]</option>";
                  }
                  ?>
              </select>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12 form-group">
          <input type="checkbox" checked name="correo_administrativo" value="1" class="filled-in" id="enviar_correo">
          <label for="enviar_correo">Enviar notificación al administrativo por correo.</label>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 form-group">
          <input type="checkbox" checked name="correo_responsable" value="1" class="filled-in" id="correo_responsable">
          <label for="correo_responsable">Enviar notificación al responsable por correo.</label>
        </div>
      </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="cerrar_modal();">Cancelar</button>
    <button type="submit" class="btn btn-success" id="btn_actualizar">Asignar responsable</button>
  </div>
</form>
<script>
    $("select").select2({
        width:'100%'
    });
    $("#frmResponsable").submit(function(e){
    $.ajax({
        url:"actualizar_responsable.php",
        type:"POST",
        dataType:"json",
        data:$(this).serialize(),
        beforeSend:function(resultado){
          $("#btn_actualizar").prop("disabled",true);
          $("#btn_actualizar").html("<i class='fa fa-spinner fa-spin'></i> Guardando cambios");
        }
    }).done(function(res){
      var resultado = res["resultado"];
      if(resultado == "exito"){
        var nombre = res["nombre_responsable"];
        $("#responsable").html(nombre);
        $.toast({
                heading: "Exito!",
                text: res["mensaje"],
                position: 'top-right',
                loaderBg:"#1E8449",
                icon: "success",
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