<?php
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    $contador = 0;
    for ($i = 0; $i < $length; $i++) {
        if($contador == 3 || $contador == 6){
            $randomString.="-";
        }
        else{
            
        }
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        $contador++;
    }
    return $randomString;
} 
for($n =1;$n<=65;$n++){
    $valor = strtoupper(generateRandomString(10));
    echo $valor."<br>";
}
?>