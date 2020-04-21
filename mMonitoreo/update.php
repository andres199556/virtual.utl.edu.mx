<?php
$array = $_POST["array_d"];
$activo = $array["activo"];
$ip = $array["ip"];
$resultado = array();
$errStr = false;
$errCode = 0;
$waitTimeoutInSeconds = 3;
if ($fp = @fsockopen($ip, 3389, $errCode, $errStr, $waitTimeoutInSeconds)) {
    //esta encendida
    fclose($fp);
    $resultado["activo"] = $activo;
    $resultado["isUp"] = true;

} else {
    $resultado["activo"] = $activo;
    $resultado["isUp"] = false;

}
echo json_encode($resultado);
