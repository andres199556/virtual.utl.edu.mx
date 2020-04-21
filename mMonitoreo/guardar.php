<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$estado = 1;
    $wake = 1;
    $fecha_hora = date("Y-m-d H:i:s");
    $activo = 1;
try{
    $tipo  =$_POST["tipo"];
    if($tipo == 1){
        //es por equipo
        $id_activo = $_POST["id_activo"];
    $comentarios = "NA";
    $insertar = $conexion->query("INSERT INTO monitoreos(
        id_activo,
        estado_monitoreo,
        wakeonlan,
        fecha_hora,
        activo,
        id_usuario,
        comentarios
    )VALUES(
        $id_activo,
        $estado,
        $wake,
        '$fecha_hora',
        $activo,
        $id_usuario_logueado,
        '$comentarios'
    )");
    }
    else if($tipo == 2){
        //es por grupo
        $id_grupo  =$_POST["id_grupo"];
        //busco los activos
        $activos = $conexion->query("SELECT id_activo_fijo
        FROM detalle_grupos_computadoras
        WHERE id_grupo_computadora = $id_grupo");
        while($row_grupo = $activos->fetch(PDO::FETCH_ASSOC)){
            $id_activo = $row_grupo["id_activo_fijo"];
            $comentarios  ="N/A";
            //busco si existe
            $validar = $conexion->query("SELECT id_activo
            FROM monitoreos
            WHERE id_activo  =$id_activo");
            $existe = $validar->rowCount();
            if($existe == 1){
                //ya existe
            }
            else{
                $insertar = $conexion->query("INSERT INTO monitoreos(
                    id_activo,
                    estado_monitoreo,
                    wakeonlan,
                    fecha_hora,
                    activo,
                    id_usuario,
                    comentarios
                )VALUES(
                    $id_activo,
                    $estado,
                    $wake,
                    '$fecha_hora',
                    $activo,
                    $id_usuario_logueado,
                    '$comentarios'
                )");
            }
            
        }
    }
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    echo $error->getMessage();
    //header("Location:index.php?resultado=error");

}
?>