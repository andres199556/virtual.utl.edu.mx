<?php
include "../conexion/conexion.php";
print_r($_POST);
$id  =$_POST["id_grupo"];
$consulta = $conexion->query("SELECT id_subgrupo_activo,
subgrupo_activo
FROM subgrupo_activos_fijos
WHERE id_grupo_activo = $id");
while($row = $consulta->fetch(PDO::FETCH_NUM)){
    ?>
    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
    <?php
}
?>