<?php
include "../conexion/conexion.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="guardar.php" method="post">
       <label for="">Trabajador</label>
        <select name="id_trabajador" id="">
            <?php
            $datos = $conexion->prepare("SELECT id_trabajador,concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as trabajador FROM trabajadores as T INNER JOIN personas as P ON T.id_persona = P.id_persona WHERE id_departamento = 1 and T.fecha is null");
$datos->execute();
while($row = $datos->fetch(PDO::FETCH_NUM)){
    echo "<option value=$row[0]>$row[1]</option>";
}
            ?>
        </select>
        <select name="id_departamento" id="">
            <?php
            $datos = $conexion->prepare("SELECT id_departamento,departamento FROM departamentos order by departamento");
$datos->execute();
while($row = $datos->fetch(PDO::FETCH_NUM)){
    echo "<option value=$row[0]>$row[1]</option>";
}
            ?>
        </select>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>