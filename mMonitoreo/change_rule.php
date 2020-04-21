<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include '../assets/plugins/phpssh/Net/SSH2.php';
include "../clases/ssh.php";
$id_rule = $_POST["id"];
//busco la regla
$buscar = $conexion->query("SELECT iptable_rule,activo
FROM bloqueo_firewall
WHERE id_bloqueo = $id_rule");
$row_buscar = $buscar->fetch(PDO::FETCH_ASSOC);
$rule = $row_buscar["iptable_rule"];
$activo = $row_buscar["activo"];
$nuevo = ($activo == 1) ? 0:1;
$fecha_hora = date("Y-m-d h:i:s");
//actualizo
$insert = $conexion->query("UPDATE bloqueo_firewall
SET activo = $nuevo,
fecha_hora = '$fecha_hora'");
$ssh = new server_ssh();
$conexion_ssh = $ssh->get_connection();
$result = array();
if($activo == 1){
    //voy a borrar
    $result["nuevo"] = "ACEPTAR";
    $ssh->prepare("sed -i \"s/".$rule."/\\n/g\" /etc/zentyal/hooks/firewall.postservice",false);
}
else{
    //vuelvo a agregar
    $result["nuevo"] = "DENEGAR";
    $ssh->prepare("sed -i -e \""."\\"."\$a".$rule. "\" /etc/zentyal/hooks/firewall.postservice",false);
}

$resultado = $ssh->run_command($conexion_ssh);
$real_res = str_replace("[sudo] password for soporte: ","",$resultado);
$res_l = strlen($real_res);
if($res_l == 0){
    //la regla se agrego correctamente, reinicio el firewall
    $ssh->prepare("zs firewall restart",false);
    $resultado = $ssh->run_command($conexion_ssh);
    $result["resultado"] = "exito";
    $result["mensaje"] = "Regla actualizada correctamente!.";
}
else{
    $result["resultado"] = $error;
    $result["mensaje"] = $real_res;
}
echo json_encode($result);
?>
