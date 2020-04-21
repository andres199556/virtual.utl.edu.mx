<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../clases/mail.php";
$id_accion  =$_POST["id_accion"];
$id_responsable = $_POST["id_responsable"];
$id_verificador = $_POST["verificador"];
if($id_responsable == $id_verificador){
    header("Location:accion.php?id=$id_accion&resultado=mismos");
}
else{
    $fecha = date("Y-m-d H:i:s");
    $activo = 1;
    try{
        $agregar = $conexion->query("INSERT INTO detalle_acciones(
            id_accion,
            fecha_asignacion,
            id_responsable,
            id_verificador,
            fecha_hora,
            activo,
            id_usuario,
            pendiente_validar,
            validado
        )VALUES(
            $id_accion,
            '$fecha',
            $id_responsable,
            $id_verificador,
            '$fecha',
            $activo,
            $id_usuario_logueado,
            0,
            0
        )");
        //actualizo el estado
        $update = $conexion->query("UPDATE acciones
        SET id_estado = 2,
        fecha_hora = '$fecha',
        id_usuario = $id_usuario_logueado
        WHERE id_accion  =$id_accion");
        //agrego el log
        $log = "La acción con el n° $id_accion ha procedido, autorizó: ".$_SESSION["nombre_persona"];
        $insert_log = $conexion->query("INSERT INTO historial_acciones(
    id_accion,
    log,
    fecha_hora
    )VALUES(
    $id_accion,
    '$log',
    '$fecha'
    )");
    //envio los correos
    $datos = $conexion->query("SELECT T.correo as correo_responsable,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno ) as responsable,T2.correo as correo_verificador,CONCAT(P2.nombre,' ',P2.ap_paterno,' ',P2.ap_materno ) as verificador,DI.direccion,A.descripcion
    FROM acciones as A
    INNER JOIN detalle_acciones as DA ON A.id_accion = DA.id_accion
    INNER JOIN usuarios as U ON DA.id_responsable = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN direcciones as DI ON A.id_direccion = DI.id_direccion
    INNER JOIN trabajadores as T ON P.id_persona =T.id_persona
    INNER JOIN usuarios as U2 ON DA.id_verificador = U2.id_usuario
    INNER JOIN personas as P2 ON U2.id_persona = P2.id_persona
    INNER JOIN trabajadores as T2 ON P2.id_persona =T2.id_persona
    WHERE A.id_accion = $id_accion
    ");
    $row = $datos->fetch(PDO::FETCH_ASSOC);
    $correo_responsable = $row["correo_responsable"];
    $responsable = $row["responsable"];
    $correo_verificador = $row["correo_verificador"];
    $verificador = $row["verificador"];
    $direccion = $row["direccion"];
    $descripcion = $row["descripcion"];
    $asunto = "Asignación de seguimiento a acción correctiva";
    $cuerpo = "<p>El siguiente correo es para notificar que haz sido asignado como responsable de la acción correctiva n° $id_accion. Los datos de la acción correctiva son los siguientes:&nbsp;</p>
    <p><b>Acción n°</b>: $id_accion</p>
    <p><b>Descripción:</b> $descripcion</p>
    <p><b>Dirección:</b> $direccion</p>
    <p>Para validar el análisis, deberás ingresar al Sistemas Administrador de Calidad mediante el 
      <a href='http://128.100.0.3:50/erp/' target='_blank'>siguiente enlace</a>, posteriormente entrar al módulo de Acciones Correctivas y ubicar la acción correctiva en cuestión.
    </p>
    <p>Atentamente: gestión de calidad.</p>";
    //envio el correo
    $mail_responsable = new correos($asunto,$correo_responsable,$responsable);
    $mail_verificador = new correos($asunto,$correo_verificador,$verificador);
    $enviar_correo_r  =$mail_responsable->send_mail_plain($cuerpo);
    $cuerpo = "<p>El siguiente correo es para notificar que haz sido asignado como verificador de la acción correctiva n° $id_accion. Los datos de la acción correctiva son los siguientes:&nbsp;</p>
    <p><b>Acción n°</b>: $id_accion</p>
    <p><b>Descripción:</b> $descripcion</p>
    <p><b>Dirección:</b> $direccion</p>
    <p>Para validar el análisis, deberás ingresar al Sistemas Administrador de Calidad mediante el 
      <a href='http://128.100.0.3:50/erp/' target='_blank'>siguiente enlace</a>, posteriormente entrar al módulo de Acciones Correctivas y ubicar la acción correctiva en cuestión.
    </p>
    <p>Atentamente: gestión de calidad.</p>";
    $enviar_correo_v  =$mail_verificador->send_mail_plain($cuerpo);

        header("Location:accion.php?id=$id_accion&resultado=exito_alta");
    }
    catch(PDOException $error){
        header("Location:accion.php?id=$id_accion&resultado=error_alta");
    }
}
?>