<?php
$archivo = $_FILES["file"];
date_default_timezone_set("America/Monterrey");
require_once 'Classes/PHPExcel.php';
$archivo = $archivo["tmp_name"];
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
for ($row = 2; $row <= $highestRow; $row++){ 
    $direccion_ip = $sheet->getCell("A".$row);
    $mac = $sheet->getCell("B".$row);
    $host = $sheet->getCell("C".$row);
    $cantidad = strlen($mac);
    $nueva_mac = "";
    $contador = 1;
    for($i = 0;$i<$cantidad;$i++){
        $caracter = substr($mac,$i,1);
        $nueva_mac.=$caracter;
        if($contador % 2 == 0){
            $nueva_mac.=":";
        }
        ++$contador;
        
    }
    $nueva_mac = trim($nueva_mac,":");
    
    $salida = "#HOST-INTERNO-$host \t
            host $host{
                \t option host-name \"$host\";
                \t hardware ethernet $nueva_mac;
                \t fixed-address $direccion_ip;
            }";
    echo "<pre>";
    echo $salida."<br>";
    echo "</pre>";
		/*echo $sheet->getCell("A".$row)->getValue()." - ";
		echo $sheet->getCell("B".$row)->getValue()." - ";
		echo $sheet->getCell("C".$row)->getValue();
		echo "<br>";*/
}
?>