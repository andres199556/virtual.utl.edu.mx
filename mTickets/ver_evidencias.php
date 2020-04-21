<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$id_nota = $_POST["id_nota"];
//busco las evidencias
$evidencias = $conexion->prepare("SELECT id_evidencia,nombre_evidencia,ruta_archivo FROM evidencia_notas WHERE id_nota = $id_nota");
$evidencias->execute();
$n = 0;
while($row = $evidencias->fetch(PDO::FETCH_NUM)){
    ++$n;
    $id_evidencia  =$row[0];
    $evidencia = $row[1];
    $ruta = $row[2];
    ?>
    <tr>
        <td class="text-center"><?php echo $n;?></td>
        <td class="text-center"><?php echo $evidencia;?></td>
        <td class="text-center"><a href="<?php echo $ruta;?>" download class="btn btn-success btn-sm">Descargar</a></td>
    </tr>
    <?php
}
?>