<?php
$servidor = 'localhost';
$bd_name = 'virtual.utl.edu.mx';
$usuario = 'root';
$password = 'skynet_andres633156';
$cadena_conexion = 'mysql:dbname='.$bd_name.';host='.$servidor.'';
global $conexion;
try {
    $conexion = new PDO($cadena_conexion, $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    date_default_timezone_set("America/Monterrey");
    //llamo la consulta para especificar UTF-8
    $conexion->query("SET NAMES utf8");
    $conexion->query("SET lc_time_names = 'es_ES';");
    
} 
catch (PDOException $error) {
    //muestro el error de la conexión
    echo 'Falló la conexión: ' . $error->getMessage();
}

/* class db_functions{
    public function insert_row($table,$columns,$values,$condition){
        $conexion = $GLOBALS["conexion"];
        //print_r($GLOBALS);
        $res = false;
        try{
            $qry = $conexion->prepare("INSERT INTO $table(:columns) VALUES(:values)",array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            echo $qry;
            $columns = "id,otro,otro,otro";
            //$columns = join($columns,",");
            $values = join($values,",");
            $qry->execute(array(':columns' => $columns,':values' => $conexion->quote($values)));
            $res = true;
        }
        catch(PDOException $error){
            echo $error->getMessage();
            $res = false;
        }
    }
} */
?>