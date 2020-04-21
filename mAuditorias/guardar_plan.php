<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
include "../funciones/correos.php";
$id = $_POST["id"];
$direccion  =$_POST["direccion"];
$proceso  =$_POST["proceso"];
$responsables = $_POST["responsables"];
$elementos  =$_POST["elementos"];
$auditores = $_POST["auditores"];
$fecha_plan  =$_POST["fecha_hora"];
$enviar_correo = 1;
$folio = generar_string(15);
$activo = 1;
$fecha = date("Y-m-d H:i:s");
try{
    $insert = $conexion->query("INSERT INTO planes_auditorias(id_auditoria,id_direccion,id_proceso,id_responsable,elementos,fecha_hora_plan,enviar_correo,fecha_hora,activo,id_usuario,folio_plan_auditoria)VALUES(
        $id,
        $direccion,
        $proceso,
        $responsables,
        '$elementos',
        '$fecha_plan',
        $enviar_correo,
        '$fecha',
        $activo,
        $id_usuario_logueado,
        '$folio'
    )");
    $id_plan = $conexion->lastInsertId();
    //se envia correo al responsable del proceso
    
    foreach($auditores as $id_auditor){
        $insert_a = $conexion->query("INSERT INTO auditores_planes(
            id_auditoria,
            id_plan,
            id_usuario,
            fecha_hora,
            activo
        )VALUES(
            $id,
            $id_plan,
            $id_auditor,
            '$fecha',
            $activo
        )");
        
    }
    $datos = $conexion->query("SELECT asunto,cuerpo_mensaje,correo,responsable FROM correo_responsable_auditoria as CR WHERE CR.id_plan = $id_plan AND CR.id_responsable = $responsables");
    $row  =$datos->fetch(PDO::FETCH_ASSOC);
    $res_email = send_email($row["asunto"],$row["cuerpo_mensaje"],$row["correo"],$row["responsable"]);
    foreach($auditores as $id_auditor){
        $datos = $conexion->query("SELECT asunto,cuerpo_mensaje,correo,nombre FROM correo_auditor_auditoria as CR WHERE CR.id_plan = $id_plan AND CR.id_auditor = $id_auditor");
    $row  =$datos->fetch(PDO::FETCH_ASSOC);
    $res_email = send_email($row["asunto"],$row["cuerpo_mensaje"],$row["correo"],$row["nombre"]);
    }
    header("Location:index.php?id=$id&resultado=exito_alta_plan");
}
catch(Exception $error){
    echo $error->getMessage();
}
?>