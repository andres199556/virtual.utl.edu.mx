<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$id_marca = $_POST["id_marca"];
$modelo  =$_POST["modelo"];
$no_serie = $_POST["no_serie"];
$comentarios = $_POST["comentarios"];
$id_tipo_activo_fijo = $_POST["id_tipo_activo_fijo"];
$id_responsable = $_POST["id_responsable"]; #responsable del activo
$fecha = date("Y-m-d h:i:s");
$hora = date("H:i:s");
$no_activo_fijo = "UT-";
$activo_automatico = (isset($_POST["activo_automatico"]) ? 1:0);
$id_grupo_activo_fijo = $_POST["id_grupo_activo"];
$id_subgrupo_activo = $_POST["id_subgrupo_activo"];
$id_clase_activo = $_POST["id_clase_activo_fijo"];
$id_subclase_activo = $_POST["id_subclase_activo_fijo"];
$id_consecutivo_activo = $_POST["id_consecutivo_activo_fijo"];
$id_ubicacion  =$_POST["ubicacion"];
$id_ubicacion_secundaria = $_POST["ubicacion_secundaria"];
if($activo_automatico == 1){

}
else{
    $no_activo_fijo = $_POST["no_activo"];
}
$activo = 1;
switch($id_consecutivo_activo){
    case 77:
        //es computadora
    $mac = $_POST["mac"];
    $ram  =$_POST["ram"];
    $disco_duro = $_POST["disco_duro"];
    $procesador = $_POST["procesador"];
    $uso_cpu = $_POST["uso_cpu"];
    $id_sistema = $_POST["id_sistema"];
    $internet = (isset($_POST["internet"]) ? 1:0);
    $ip = $_POST["ip"];
    //busco que exista por la MAC
    if($mac == "NA"){
        //no se tiene por el momento, por lo tanto no se busca
        goto insertar;
        
    }
    else{
        goto validar;
    }
    
    validar:
    $buscar = $conexion->prepare("SELECT id_activo_fijo FROM activos_fijos WHERE direccion_mac = '$mac'");
    $buscar->execute();
    $existe = $buscar->rowCount();
    if($existe != 0){
        header("Location:index.php?resultado=existe_equipo");
    }
    else{
        //inserto la computadora
        insertar;
        
    }
    
    insertar:
    try{
            $agregar = $conexion->prepare("INSERT INTO activos_fijos (
            id_marca,
            modelo,
            no_serie,
            direccion_mac,
            memoria_ram,
            disco_duro,
            procesador,
            id_sistema_operativo,
            tipo_cpu,
            fecha_hora,
            activo,
            id_usuario,
            internet,
            comentarios,
            id_tipo_activo_fijo,
            id_grupo_activo_fijo,
            id_subgrupo_activo_fijo,
            id_clase_activo_fijo,
            id_subclase_activo_fijo,
            id_consecutivo_activo_fijo,
            id_ubicacion,
            id_ubicacion_secundaria,
            direccion_ip
        )
        VALUES
            (
                $id_marca,
                '$modelo',
                '$no_serie',
                '$mac',
                '$ram',
                '$disco_duro',
                '$procesador',
                $id_sistema,
                '$uso_cpu',
                '$fecha',
                $activo,
                $id_usuario_logueado,
                $internet,
                '$comentarios',
                $id_tipo_activo_fijo,
                $id_grupo_activo_fijo,
                $id_subgrupo_activo,
                $id_clase_activo,
                $id_subclase_activo,
                $id_consecutivo_activo,
                $id_ubicacion,
                $id_ubicacion_secundaria,
                '$ip'
            )");
                $agregar->execute();
                $id_activo_fijo = $conexion->lastInsertId();
        }
        catch(Exception $error){
            echo $error->getMessage();
            //header("Location:index.php?resultado=error");
        }
        break;
        //es un teclado
    default:
        try{
        $agregar = $conexion->prepare("INSERT INTO activos_fijos (
            id_marca,
            modelo,
            no_serie,
            fecha_hora,
            activo,
            id_usuario,
            comentarios,
            id_tipo_activo_fijo,
            id_grupo_activo_fijo,
            id_subgrupo_activo_fijo,
            id_clase_activo_fijo,
            id_subclase_activo_fijo,
            id_consecutivo_activo_fijo,
            id_ubicacion,
            id_ubicacion_secundaria
        )
        VALUES
            (
                $id_marca,
                '$modelo',
                '$no_serie',
                '$fecha',
                $activo,
                $id_usuario_logueado,
                '$comentarios',
                $id_tipo_activo_fijo,
                $id_grupo_activo_fijo,
                $id_subgrupo_activo,
                $id_clase_activo,
                $id_subclase_activo,
                $id_consecutivo_activo,
                $id_ubicacion,
                $id_ubicacion_secundaria
            )");
                $agregar->execute();
            $id_activo_fijo = $conexion->lastInsertId();
        }
    catch(PDOException $error){
        header("Location:index.php?resultado=error_alta");
    }
        break;      
}  
if($activo_automatico == 1){
    $no_activo_fijo = "UTL-".$id_activo_fijo;
}
else{
    //lo mando el usuario
}
//actualizo
$update_activo = $conexion->query("UPDATE activos_fijos 
SET no_activo_fijo = '$no_activo_fijo' 
WHERE id_activo_fijo = $id_activo_fijo");
//inserto el responsable del activo
try{
    //$no_activo_fijo.=$id_activo_fijo;
    $qry_responsable = $conexion->prepare("INSERT INTO asignacion_activos_fijos (
	id_activo_fijo,
	numero_activo,
	id_usuario,
	fecha_asignacion,
	hora_asignacion,
	comentarios,
	fecha_hora,
	hora,
	activo,
	id_usuario_alta
)
VALUES
	(
		$id_activo_fijo,
		'$no_activo_fijo',
		'$id_responsable',
		'$fecha',
		'$comentarios',
		'$fecha',
		'$hora',
		$activo,
		$id_usuario_logueado
	)");
    $qry_responsable->execute();
    header("Location:index.php?resultado=exito_alta");
}
catch(PDOException $error){
    echo $error->getMessage();
    //header("Location:index.php?resultado=error_alta");
}
?>