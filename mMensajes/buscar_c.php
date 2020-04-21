<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$criterio = $_POST["criterio"];
$array_resultado  =array();
//busco las coincidencias con contactos
try{
    $usuarios = $conexion->query("SELECT U.id_usuario,CONCAT(SUBSTRING_INDEX(P.nombre, ' ', 1),' ',P.ap_paterno) as trabajador,T.id_trabajador,P.fotografia
    FROM trabajadores as T
    INNER JOIN personas as P ON T.id_persona = P.id_persona
    INNER JOIN usuarios as U ON P.id_persona = U.id_persona
    WHERE P.nombre LIKE '%$criterio%' OR P.ap_paterno LIKE '%$criterio%' OR P.ap_materno LIKE '%$criterio%' AND U.id_usuario != $id_usuario_logueado
    GROUP BY T.id_trabajador");
    $existe_usuarios = $usuarios->rowCount();
    $row_usuarios = $usuarios->fetchAll(PDO::FETCH_ASSOC);
    $array_resultado["cantidad_usuarios"] = $existe_usuarios;
    $array_resultado["array_usuarios"] = array();
    $array_resultado["array_usuarios"] = $row_usuarios;
    print_r($filas);

    //busco en conversaciones
    $conversaciones = $conexion->query("SELECT id_conversacion,nombre_conversacion
    FROM conversaciones
    WHERE nombre_conversacion LIKE '%$criterio%'");
    $existe_conversaciones = $conversaciones->rowCount();
    $row_conversaciones = $conversaciones->fetchAll(PDO::FETCH_ASSOC);
    $array_resultado["cantidad_conversaciones"] = $existe_conversaciones;
    $array_resultado["array_conversaciones"] = array();
    $array_resultado["array_conversaciones"] = $row_conversaciones;
    echo json_encode($array_resultado);
}
catch(PDOException $error){

}
?>