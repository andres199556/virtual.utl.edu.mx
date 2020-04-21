<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
//busco los trabajadores
$contactos = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as contacto
FROM usuarios as U INNER JOIN personas as P ON U.id_persona = P.id_persona
WHERE (P.activo = 1 AND U.activo = 1) AND U.id_usuario != $id_usuario_logueado");
while($row = $contactos->fetch(PDO::FETCH_NUM)){
    ?>
    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
    <?php
}
?>