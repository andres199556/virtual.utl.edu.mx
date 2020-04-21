<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
if(!isset($_GET["id"]) || !isset($_GET["estado"])){
    
}
else{
    $id = $_GET["id"];
    $estado = $_GET["estado"];
    if($id == "" || $id == null || $estado == "" || $estado == null){
        
    }
    else{
        //busco que exista
        $buscar = $conexion->query("SELECT id_activo_fijo FROM activos_fijos WHERE id_activo_fijo = $id");
        $existe = $buscar->rowCount();
        if($existe != 1){
            
        }
        else{
            //actualizo
            try{
                $activo = ($estado == 1 ? 0:1);
                $fecha = date("Y-m-d");
                $fecha_hora = date("Y-m-d H:i:s");
                $actualizar = $conexion->prepare("UPDATE activos_fijos 
                SET activo = $activo,
                fecha_hora = '$fecha_hora',
                id_usuario = $id_usuario_logueado 
                WHERE id_activo_fijo  =$id");
                $actualizar->execute();
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