<?php
include "../conexion/conexion.php";
$id  =$_POST["id_subgrupo"];
$consulta = $conexion->query("SELECT id_clase_activo,
clase_activo_fijo
FROM clase_activos_fijos
WHERE id_subgrupo_activo = $id");
while($row = $consulta->fetch(PDO::FETCH_NUM)){
    ?>
    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
    <?php
}
?>