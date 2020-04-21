<?php
include "../conexion/conexion.php";
$id  =$_POST["id_clase"];
$consulta = $conexion->query("SELECT id_subclase_activo,
subclase_activo
FROM subclase_activos_fijos
WHERE id_clase_activo = $id");
while($row = $consulta->fetch(PDO::FETCH_NUM)){
    ?>
    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
    <?php
}
?>