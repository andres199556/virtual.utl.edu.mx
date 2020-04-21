<?php
$paginas = array("netflix.com","facebook.com","youtube.com","mega.nz","mediafire.com","messenger.com");
include "../conexion/conexion.php";
$datos = $conexion->query("SELECT
id_activo_fijo,
modelo,
no_serie,
direccion_ip,
direccion_mac,
comentarios,
id_ubicacion_secundaria,
id_consecutivo_activo_fijo,
no_activo_fijo,
activo
FROM
activos_fijos
WHERE
id_ubicacion_secundaria = 11
AND id_consecutivo_activo_fijo = 77
ORDER BY
direccion_ip ASC");
echo "#-----------------------------------------------CYBER--------------------------------------------------------------------------------------------<br>";
while($row = $datos->fetch(PDO::FETCH_ASSOC)){
    $mac  =$row["direccion_mac"];
    $ip = $row["direccion_ip"];
    $nombre = $row["comentarios"];
    foreach($paginas as $pagina){
        $rule = "iptables -I FORWARD -p tcp --dport 443 -m mac --mac-source $mac -m string --string '$pagina' --algo bm -j DROP #$ip $nombre";
        echo $rule."<br>";
    }
    echo "#------------------------------------------------------------------------------------------------------<br>";
    
    
}
echo "#-----------------------------------------------CYBER--------------------------------------------------------------------------------------------<br>";
$array = array()
?>