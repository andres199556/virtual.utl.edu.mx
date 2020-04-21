<?php
include "../conexion/conexion.php";
$id_subclase  =$_POST["id_subclase"];
$consulta = $conexion->query("SELECT id_consecutivo_activo_fijo,
consecutivo_activo_fijo
FROM consecutivos_activos_fijos
WHERE id_subclase_activo_fijo = $id_subclase");
while($row = $consulta->fetch(PDO::FETCH_NUM)){
    ?>
    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
    <?php
}
?>