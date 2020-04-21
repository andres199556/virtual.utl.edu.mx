<?php
include "../conexion/conexion.php";
?>
   <div class="row">
    <div class="col-md-12">
       <label for="id_tipo_servicio">Tipo de servicio: </label>
        <select name="id_tipo_servicio" id="id_tipo_servicio" class="form-control">
            <?php
            $tipos = $conexion->prepare("SELECT id_tipo_servicio,tipo_servicio FROM tipo_servicios WHERE activo = 1");
            $tipos->execute();
            while($row = $tipos->fetch(PDO::FETCH_NUM)){
                echo "<option value=$row[0]>$row[1]</option>";
            }
            ?>
            
        </select>
    </div>
</div>
<script type="text/javascript">
    $("#id_tipo_servicio").select2({
        width:'100%'
    });
</script>