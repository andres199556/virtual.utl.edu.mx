<?php
include "../conexion/conexion.php";
$id_plan = $_POST["id_plan"];
//busco
$buscar = $conexion->query("SELECT id_plan_mantenimiento
FROM planes_individuales_mantenimientos
WHERE id_plan_individual = $id_plan");
$row_b = $buscar->fetch(PDO::FETCH_NUM);
$id_plan_mantenimiento = $row_b[0];
?>
<form action="#" id="frmActivos">
  <div class="modal-header">
    <h4 class="modal-title">Asignar activos al mantenimiento</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
      <div class="row">
          <div class="col-md-12 form-group">
            <input type="hidden" name="id_plan_individual" value="<?php echo $id_plan;?>">
            <input type="hidden" name="id_plan_mantenimiento" value="<?php echo $id_plan_mantenimiento;?>">
              <label for="id_activo" class="control-label">Nº de activo: </label>
              <select name="activos[]" id="id_activo" multiple>
                  <?php
                  $activos = $conexion->query("SELECT
                  AF.id_activo_fijo,
                  CA.consecutivo_activo_fijo,
                  AF.no_activo_fijo
              FROM
                  activos_fijos AS AF
              INNER JOIN consecutivos_activos_fijos AS CA ON AF.id_consecutivo_activo_fijo = CA.id_consecutivo_activo_fijo
              WHERE
                  AF.activo = 1 AND AF.id_activo_fijo NOT IN(SELECT id_activo
                  FROM activos_mantenimientos
                  WHERE id_plan_mantenimiento = $id_plan_mantenimiento)");
                  while($row_u = $activos->fetch(PDO::FETCH_NUM)){
                      echo "<option value=$row_u[0]>$row_u[2] - $row_u[1]</option>";
                  }
                  ?>
              </select>
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
    <button type="submit" class="btn btn-success" id="btn_actualizar">Asignar activos</button>
  </div>
</form>
<script>
    $("select").select2({
        width:'100%'
    });
    $("#frmActivos").submit(function(e){
    $.ajax({
        url:"actualizar_activos.php",
        type:"POST",
        dataType:"json",
        data:$(this).serialize(),
        beforeSend:function(resultado){
          $("#btn_actualizar").prop("disabled",true);
          $("#btn_actualizar").html("<i class='fa fa-spinner fa-spin'></i> Guardando cambios");
        }
    }).done(function(e){
        var resultado = e["resultado"];
        if(resultado == "exito_alta"){
            $("#modal_action").modal("hide");
            $.toast({
                heading: "Exito!",
                text: "Activo agregado correctamente!.",
                position: 'top-right',
                loaderBg:"#A93226",
                icon: "danger",
                hideAfter: 3000, 
                stack: 6
            });
            actualizar_activos(<?php echo $id_plan;?>);
        }
    }).fail(function(error){
        alert("Error");
    });
    e.preventDefault();
    return false;
});
</script>