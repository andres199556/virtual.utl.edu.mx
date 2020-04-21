<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
if(!isset($_GET["id"]) || !isset($_GET["estado"])){
    
}
else{
    $id_trabajador = $_GET["id"];
    $estado = $_GET["estado"];
    if($id_trabajador == "" || $id_trabajador == null || $estado == "" || $estado == null){
        
    }
    else{
        //busco que exista
        $buscar = $conexion->prepare("SELECT id_trabajador 
        FROM trabajadores 
        WHERE id_trabajador = $id_trabajador");
        $buscar->execute();
        $existe = $buscar->rowCount();
        if($existe != 1){
            
        }
        else{
            //actualizo
            try{
                $activo = ($estado == 1 ? 0:1);
                $fecha = date("Y-m-d H:i:s");
                $consulta = "UPDATE trabajadores as T
                INNER JOIN personas as P ON T.id_persona = P.id_persona
                INNER JOIN usuarios as U ON P.id_persona = U.id_persona
                SET T.activo = $activo,
                P.activo = $activo,
                U.activo = $activo,
                T.fecha_hora = '$fecha',
                P.fecha_hora = '$fecha',
                U.fecha_hora = '$fecha'
                WHERE T.id_trabajador = $id_trabajador";
                $actualizar = $conexion->query($consulta);
                header("Location:index.php?resultado=exito_actualizar");
            }
            catch(PDOException $error){
                echo $error->getMessage();
                //header("Location:index.php?resultado=$error");
            }
        }
    }
}
?>