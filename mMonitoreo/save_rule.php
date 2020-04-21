<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include '../assets/plugins/phpssh/Net/SSH2.php';
include "../clases/ssh.php";
print_r($_POST);
$id_activo = $_POST["no_activo_fijo"];
$id_tipo_bloqueo = $_POST["id_tipo_bloqueo"];
$tipo_filtrado = $_POST["tipo_filtrado"];
$string = $_POST["string"];
//busco la direccion mac
$buscar = $conexion->query("SELECT direccion_mac,direccion_ip
FROM activos_fijos
WHERE no_activo_fijo = '$id_activo'");
$row_buscar = $buscar->fetch(PDO::FETCH_ASSOC);
$mac = $row_buscar["direccion_mac"];
$ip = $row_buscar["direccion_ip"];
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$rule = "iptables -I FORWARD -p tcp --dport 443 -m mac --mac-source $mac -m string --string \'$string\' --algo bm -j DROP";
//inserto la regla
$insert = $conexion->query("INSERT INTO bloqueo_firewall(
    id_tipo_bloqueo,
    id_activo_fijo,
    mac_origen,
    ip_origen,
    es_dominio,
    string_bloqueo,
    fecha_hora,
    activo,
    id_usuario,
    iptable_rule
)VALUES(
    2,
    '$id_activo',
    '$mac',
    '$ip',
    $tipo_filtrado,
    '$string',
    '$fecha_hora',
    $activo,
    $id_usuario_logueado,
    '$rule'
)");
$ssh = new server_ssh();
$conexion_ssh = $ssh->get_connection();
$result = array();
$ssh->prepare("sed -i -e \""."\\"."\$a".$rule. "\" /etc/zentyal/hooks/firewall.postservice",false);
$resultado = $ssh->run_command($conexion_ssh);
$real_res = str_replace("[sudo] password for soporte: ","",$resultado);
echo $real_res;
$res_l = strlen($real_res);
if($res_l == 0){
    //la regla se agrego correctamente, reinicio el firewall
    $ssh->prepare("zs firewall restart",false);
    $resultado = $ssh->run_command($conexion_ssh);
    $result["resultado"] = "exito";
    $result["mensaje"] = "Regla agregada correctamente!.";
}
else{
    $result["resultado"] = $error;
    $result["mensaje"] = $real_res;
}
echo json_encode($result);
?>
