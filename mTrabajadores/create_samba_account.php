<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include '../assets/plugins/phpssh/Net/SSH2.php';
include "../clases/ssh.php";
$id = $_POST["id"];
$password = "12345";
$comentarios = "usuario creado por la plataforma";
//busco los datos del usuario
$datos = $conexion->query("SELECT P.nombre,CONCAT(P.ap_paterno,' ',P.ap_materno) as apellidos,T.correo,U.id_usuario
FROM trabajadores as T
INNER JOIN personas as P ON T.id_persona = P.id_persona
INNER JOIN usuarios as U ON P.id_persona = U.id_persona
WHERE T.id_trabajador = $id");
$row_datos = $datos->fetch(PDO::FETCH_ASSOC);
$nombre = $row_datos["nombre"];
$apellidos = $row_datos["apellidos"];
$correo  =$row_datos["correo"];
$id_usuario  =$row_datos["id_usuario"];
$division = explode("@",$correo);
$usuario = $division[0];
$fecha = date("Y-m-d H:i:s");
$ssh = new server_ssh();
$conexion_ssh = $ssh->get_connection();
$result = array();
$ssh->prepare("/usr/local/bin/./create_user ",true);
$ssh->argumentos = '"'.$nombre.'" "'.$apellidos.'" '.$correo.' '.$password.' '.$usuario.' "'.$comentarios.'"';
$resultado = $ssh->run_command($conexion_ssh);
$real_res = str_replace("[sudo] password for soporte: ","",$resultado);
if($real_res == "exito"){
    //el usuario se creo correctamente
    $result["resultado"] = "exito";
    $result["mensaje"] = "El usuario se ha creado correctamente!.";
    $update = $conexion->query("UPDATE usuarios
    SET usuario_red = 1,
    fecha_hora_creacion_red = '$fecha'
    WHERE id_usuario = $id_usuario");
}
else{
    $error = "";
    if(strstr($real_res,"Nombre de cuenta ya existente")){
        $error = "existe_usuario";
    }
    $result["resultado"] = $error;
    $result["mensaje"] = $real_res;
}
echo json_encode($result);
?>
