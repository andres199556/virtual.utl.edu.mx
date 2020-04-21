<?php
function generar_ticket($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        if($i == 3 || $i == 6){
            $randomString.="-";
        }
    }
    return $randomString;
}
function generar_string($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 1; $i <= $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function obtener_diferencia_fecha($intervalo){
    $anios = $intervalo->format("%Y");
    $meses = $intervalo->format("%m");
    $dias = $intervalo->format("%d");
    $horas = $intervalo->format("%h");
    $minutos = $intervalo->format("%i");
    $segundos = $intervalo->format("%s");
    $resultado;
    if($anios == 0){
        if($meses == 0){
            if($dias == 0){
                if($minutos == 0){
                    if($segundos == 0){
                        
                    }
                    else{
                        if($segundos == 1){
                            $resultado.=$segundos." segundo.";
                        }
                        else{
                            $resultado.=$segundos." segundos.";
                        }
                    }
                }
                else{
                    if($minutos == 1){
                        $resultado.=$minutos." minuto.";
                    }
                    else{
                        $resultado.=$minutos." minutos.";
                    }
                }
            }
            else{
                if($dias == 1){
                    $resultado.=$dias." día.";
                }
                else{
                    $resultado.=$dias." días.";
                }
            }
        }
        else{
            if($meses == 1){
                $resultado.=$meses." mes.";
            }
            else{
                $resultado.=$meses." meses.";
            }
        }
    }
    else{
        $resultado.=$anios." años.";
    }
    return $resultado;
    /*
    if($anios == 0){
        //no los adjunto
    }
    
    else{
        if($anios == 1){
            $resultado.=$anios." año,";
        }
        else{
            $resultado.=$anios." años,";
        }
    }
    if($meses == 0){
        
    }
    else{
        if($meses == 1){
            $resultado.=$meses." mes,";
        }
        else{
            $resultado.=$meses." meses,";
        }
    }
    if($dias == 0){
        
    }
    else{
        if($dias == 1){
            $resultado.=$dias." día,";
        }
        else{
            $resultado.=$dias." días,";
        }
    }
    if($horas == 0){
        
    }
    else{
        if($horas == 1){
            $resultado.=$horas." hora,";
        }
        else{
            $resultado.=$horas." horas,";
        }
    }
    if($minutos == 0){
        
    }
    else{
        if($minutos == 1){
            $resultado.=$minutos." minuto,";
        }
        else{
            $resultado.=$minutos." minutos,";
        }
    }
    if($segundos == 1){
        $resultado.=$resultado." segundo.";
    }
    else{
        $resultado.=$resultado." segundos.";
    }
    
    return $resultado;
    */
}

function generar_random($caracteres){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $caracteres; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generar_color($caracteres){
    $characters = '0123456789ABCDEF';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $caracteres; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return "#".$randomString;
}

function obtener_nombre_mes($mes){
    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    $nombre_mes = $meses[$mes - 1];
    return $nombre_mes;
}
?>