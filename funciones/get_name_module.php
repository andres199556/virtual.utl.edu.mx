<?php
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$file = dirname($url);
$otro = explode("/",$file);
$menu = end($otro);
if($menu == "mInicio"){
    //no busco información
    $categoria_actual = "Control Interno";
    $modulo_actual  = "Panel de control";
}
else{
    //busco la información del modulo para cambiar el titulo y el breadcumb
    try{
        $datos_modulo = $conexion->prepare("SELECT 
        CM.nombre_categoria,M.nombre_modulo,M.icono
        FROM modulos as M
        INNER JOIN categoria_modulos as CM ON M.id_categoria_modulo = CM.id_categoria_modulo
        WHERE M.carpeta_modulo = '$menu'");
        $datos_modulo->execute();
        $row_datos = $datos_modulo->FETCH(PDO::FETCH_NUM);
        $categoria_actual = $row_datos[0];
        $modulo_actual = $row_datos[1];
        $icono_modulo = $row_datos[2];
    }
    catch(PDOExeption $error){
        echo $error->getMessage();
    }
    
}
?>