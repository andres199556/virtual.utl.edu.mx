<?php
//con el nombre del modulo y el usuario lo extraigo
if($menu == "mInicio"){

}
else{
    $buscar_permiso = $conexion->prepare("SELECT permiso
FROM permiso_modulos PM 
INNER JOIN modulos as M ON PM.id_modulo = M.id_modulo 
WHERE PM.id_usuario = $id_usuario_logueado AND M.carpeta_modulo = '$menu'");
$buscar_permiso->execute();
$row_permiso_array = $buscar_permiso->fetch(PDO::FETCH_NUM);
$permiso_acceso = $row_permiso_array[0];
switch($permiso_acceso){
    case 0:
        //sin acceso
        header("Location:../mInicio/index.php");
        break;
    case 2:
        //cuenta con solo acceso
        break;
    case 1:
        //es administrador
        break;
}
}

?>