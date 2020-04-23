<?php
include "../conexion/conexion.php";
$carrera = $conexion->query("SELECT id_sede,sede FROM sedes");
?>
<table border=1>
<tbody>

<?php
while($row = $carrera->fetch(PDO::FETCH_ASSOC)){
    /* echo "<tr>"; */
    $id_carrera = $row["id_sede"];
    $n_carrera = $row["sede"];
    echo "<td>$id_carrera - $n_carrera</td>";
    /* echo "</tr>"; */
}

?>
</tbody>
</table>