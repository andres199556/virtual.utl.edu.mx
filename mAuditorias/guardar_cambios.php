<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../clases/mail.php";
$id_accion  =$_POST["id"];
$mano = $_POST["mano"];
$medio = $_POST["medio"];
$material = $_POST["material"];
$metodo = $_POST["metodo"];
$maquinaria = $_POST["maquinaria"];
$analisis = $_POST["analisis"];
$fecha = date("Y-m-d H:i:s");
$activo = 1;
$resultado = array();
try{
    
    $update = $conexion->query("UPDATE detalle_acciones
    SET mano_obra = '$mano',
    medio_ambiente = '$medio',
    material = '$material',
    metodo = '$metodo',
    maquinaria = '$maquinaria',
    analisis_conformidad = '$analisis',
    fecha_hora = '$fecha',
    id_usuario = $id_usuario_logueado,
    pendiente_validar = 1
    WHERE id_accion = $id_accion AND validado != 1");
    //agrego el log
    $log = "Se ha actualizado el análisis de conformidad de la acción n° $id_accion quedando a espera de su validación. Realizó: ".$_SESSION["nombre_persona"];
    $insert_log = $conexion->query("INSERT INTO historial_acciones(
      id_accion,
      log,
      fecha_hora
      )VALUES(
      $id_accion,
      '$log',
      '$fecha'
      )");
    //busco los datos del verificador
    $datos = $conexion->query("SELECT T.correo,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as usuario,A.descripcion,DI.direccion
    FROM acciones as A
    INNER JOIN detalle_acciones as DA ON A.id_accion = DA.id_accion
    LEFT JOIN direcciones as DI ON A.id_direccion = DI.id_direccion
    INNER JOIN usuarios as U ON DA.id_verificador = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON U.id_persona = T.id_persona
    WHERE DA.id_accion = $id_accion");
    $r_datos = $datos->fetch(PDO::FETCH_ASSOC);
    $correo  =$r_datos["correo"];
    $usuario = $r_datos["usuario"];
    $direccion = $r_datos["direccion"];
    $descripcion = $r_datos["descripcion"];
    $asunto = "Validación de análisis";
    $cuerpo = "<p>El siguiente correo es para notificar que el responsable de la acción correctiva n° $id_accion ha completado el análisis de conformidad, por lo cual se necesita validar dicha información. Los datos de la acción correctiva son los siguientes:&nbsp;</p>
    <p><b>Acción n°</b>: $id_accion</p>
    <p><b>Descripción:</b> $descripcion</p>
    <p><b>Dirección:</b> $direccion</p>
    <p>Para validar el análisis, deberás ingresar al Sistemas Administrador de Calidad mediante el 
      <a href='http://128.100.0.3:50/erp/' target='_blank'>siguiente enlace</a>, posteriormente entrar al módulo de Acciones Correctivas y ubicar la acción correctiva en cuestión.
    </p>
    <p>Atentamente: gestión de calidad.</p>";
    //envio el correo
    $mail = new correos($asunto,$correo,$usuario);
    $enviar_correo  =$mail->send_mail_plain($cuerpo);
    
    $resultado["resultado"] = "exito";
    $resultado["mensaje"] = "Análisis llenado completamente";
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>