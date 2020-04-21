<?php
include "../conexion/conexion.php";
$t = $conexion->query("SELECT U.id_usuario
FROM usuarios as U
INNER JOIN trabajadores as T ON U.id_persona = T.id_persona");
while($row = $t->fetch(PDO::FETCH_ASSOC)){
    $id = $row["id_usuario"];
    $id_modulo = 24;
    $permiso  =2;
    //buscar
    $buscar = $conexion->query("SELECT id_permiso
    FROM permiso_modulos
    WHERE id_usuario = $id AND id_modulo = $id_modulo");
    $existe = $buscar->rowCount();
    if($existe == 1){
        $update = $conexion->query("UPDATE permiso_modulos SET permiso = 2 WHERE id_modulo = $id_modulo AND id_usuario = $id");
    }
    else{
        $agregar = $conexion->query("INSERT INTO permiso_modulos(id_usuario,id_modulo,permiso,activo,id_usuario_alta)VALUES($id,$id_modulo,$permiso,1,1)");
    }
}
?>