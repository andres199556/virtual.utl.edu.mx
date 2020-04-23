<?php
set_time_limit(600);
function actualizar_grupo($grupo,$criterio,$id_grupo,$id_sede){
    $id_periodo = 2;
    $fecha_hora  =date("Y-m-d H:i:s");
    $activo = 1;
    include "../conexion/conexion.php";
    include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
    $posicion = strpos($grupo,$criterio);
        if($posicion == ""){
            return false;
        }
        else{
            switch($criterio){
                case "02":
                    $grupo = str_replace("02","03",$grupo);
                break;
                case "05":
                    $grupo = str_replace("05","06",$grupo);
                break;
                case "08":
                    $grupo = str_replace("08","09",$grupo);
                break;
            }
            if($criterio == "11"){
                //solo actualizo el grupo
                $update_grupo = $conexion->query("UPDATE grupos SET activo = 0 WHERE id_grupo  =$id_grupo");
            }
            else{
                //inserto el nuevo grupo
                $add_grupo = $conexion->query("INSERT INTO grupos(
                    grupo,
                    descripcion,
                    tipo_grupo,
                    id_periodo,
                    id_sede,
                    fecha_hora,
                    activo
                )VALUES(
                    '$grupo',
                    '$grupo',
                    'carrera',
                    $id_periodo,
                    $id_sede,
                    '$fecha_hora',
                    $activo
                )");
                $id_nuevo_grupo = $conexion->lastInsertId();
                //actualizo el alumno
                $update_alumno = $conexion->query("UPDATE alumnos SET id_grupo_actual = $id_nuevo_grupo,fecha_hora = '$fecha_hora' WHERE id_grupo_actual = $id_grupo");
                //actualzo el grupo
                $update_grupo = $conexion->query("UPDATE grupos SET activo = 0 WHERE id_grupo  =$id_grupo");
                //busco los integrantes del grupo anterior
                $alumnos = $conexion->query("SELECT id_alumno FROM alumnos_grupos WHERE id_grupo = $id_grupo");
                while($row = $alumnos->fetch(PDO::FETCH_ASSOC)){
                    $id_alumno = $row["id_alumno"];
                    $add = $conexion->query("INSERT INTO alumnos_grupos(
                        id_alumno,
                        id_grupo,
                        fecha_hora,
                        activo,
                        id_usuario
                    )VALUES(
                        $id_alumno,
                        $id_nuevo_grupo,
                        '$fecha_hora',
                        1,
                        1
                    )");
                }
            }
            return true;
        }
}
try{
    include "../conexion/conexion.php";
    $buscar_periodo = $conexion->query("SELECT id_periodo FROM periodos WHERE activo = 1");
    $row_periodo = $buscar_periodo->fetch(PDO::FETCH_ASSOC);
    $id_periodo = $row_periodo["id_periodo"];
    //busco los grupos
    $grupos = $conexion->query("SELECT id_grupo,grupo,id_sede FROM grupos");
    while($row_grupos = $grupos->fetch(PDO::FETCH_ASSOC)){
        $id_grupo = $row_grupos["id_grupo"];
        $grupo =$row_grupos["grupo"];
        $id_sede = $row_grupos["id_sede"];
        //primero busco el 02
        $actualizar = actualizar_grupo($grupo,"02",$id_grupo,$id_sede);
        if($actualizar == false){
            //no coincide
            $actualizar_2 = actualizar_grupo($grupo,"05",$id_grupo,$id_sede);
            if($actualizar_2 == false){
                $actualizar_3 = actualizar_grupo($grupo,"08",$id_grupo,$id_sede);
                if($actualizar_3 == false){
                    $actualizar_4 = actualizar_grupo($grupo,"11",$id_grupo,$id_sede);
                }
            }

        }
        
    }
    
}
catch(Exception $error){
    echo $error->getMessage();
}

?>