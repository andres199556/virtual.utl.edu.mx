<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id_usuario_permisos = $_POST["id_usuario_permisos"];
//busco el usuari
$buscar_u = $conexion->query("SELECT U.id_usuario
FROM trabajadores as T
INNER JOIN usuarios as U ON T.id_persona = U.id_persona
WHERE U.id_usuario = $id_usuario_permisos");
$row_u = $buscar_u->fetch(PDO::FETCH_NUM);
$id_usuario = $row_u[0];
$modulos = $_POST["id_modulos"];
$permisos  =$_POST["permisos"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$i = 0;
foreach($modulos as $id_modulo){
    $permiso = $permisos[$i];
    //verifico el permiso
    $buscar = $conexion->prepare("SELECT id_permiso 
    FROM permiso_modulos as PM
    WHERE PM.id_usuario = $id_usuario AND id_modulo = $id_modulo");
    $buscar->execute();
    $existe = $buscar->rowCount();
    if($existe == 0){
        //inserto
        goto insertar;
        
    }
    else{
        //actualizo
        $row_datos = $buscar->fetch(PDO::FETCH_NUM);
        $id_permiso = $row_datos[0];
        goto actualizar;
    }
    
    insertar:
    $insert = $conexion->prepare("INSERT INTO permiso_modulos (
	id_modulo,
	id_usuario,
	permiso,
	fecha_hora,
	activo,
	id_usuario_alta
)
VALUES
	(
		$id_modulo,
		$id_usuario,
		$permiso,
		'$fecha_hora',
		$activo,
		$id_usuario_logueado
	)");
    $insert->execute();
    
    actualizar:
    $update = $conexion->prepare("UPDATE permiso_modulos SET 
    permiso = $permiso,
    fecha_hora = '$fecha_hora',
    id_usuario_alta = $id_usuario_logueado
    WHERE id_permiso = $id_permiso");
    $update->execute();
    ++$i;
}
header("Location:index.php");
?>