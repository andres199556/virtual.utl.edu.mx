<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$paterno = $_POST["paterno"];
$materno = $_POST["materno"];
$fecha_nacimiento = $_POST["fecha_nacimiento"];
$sexo = $_POST["sexo"];
$edo_civil = $_POST["edo_civil"];
$direccion = $_POST["direccion"];
$colonia = $_POST["colonia"];
$ciudad = $_POST["ciudad"];
$estado = $_POST["estado"];
$pais = $_POST["pais"];
$curp = strtoupper($_POST["curp"]);
$no_empleado = $_POST["no_empleado"];
$correo  =$_POST["correo"];
$id_direccion = $_POST["id_direccion"];
$id_departamento = $_POST["id_departamento"];
$id_puesto = $_POST["id_puesto"];
$fecha_ingreso = $_POST["fecha_ingreso"];
$resultado = array();
$activo = 1;
$fecha_hora = date("Y:m:d H:i:s");
try{
    //busco que no exista algun valor
    $buscar = $conexion->query("SELECT id_trabajador,correo,no_empleado,curp
    FROM trabajadores as T
    INNER JOIN personas as P ON T.id_persona = P.id_persona
    WHERE (P.curp = '$curp'
    OR T.no_empleado = $no_empleado OR T.correo = '$correo') AND T.id_trabajador != $id
    ");
    $existe = $buscar->rowCount();
    if($existe == 1){
        //el registro existe
        $row = $buscar->fetch(PDO::FETCH_NUM);
        $correo_t = $row[1];
        $no_t = $row[2];
        $curp_t = $row[3];
        if($curp == $curp_t){
            //coincide el correo
            $resultado["resultado"] = "existe_curp";
        }
        else if($correo == $correo_t){
            $resultado["resultado"] = "existe_correo";
        }
        else if($no_empleado == $no_t){
            $resultado["resultado"] = "existe_numero";
        }
    }
    else{
        $insertar = $conexion->query("UPDATE trabajadores as T
        INNER JOIN personas as P ON T.id_persona = P.id_persona
        INNER JOIN usuarios as U ON P.id_persona = U.id_persona
        SET P.nombre = '$nombre',
        P.ap_paterno = '$paterno',
        P.ap_materno = '$materno',
        P.fecha_nacimiento = '$fecha_nacimiento',
        P.sexo = '$sexo',
        P.edo_civil = '$edo_civil',
        P.direccion = '$direccion',
        P.colonia = '$colonia',
        P.ciudad = '$ciudad',
        P.estado = '$estado',
        P.pais = '$pais',
        P.curp = '$curp',
        T.id_direccion = $id_direccion,
        T.id_departamento = $id_departamento,
        T.id_puesto = $id_puesto,
        T.correo = '$correo',
        T.fecha_ingreso_trabajo = '$fecha_ingreso',
        T.no_empleado = $no_empleado,
        T.fecha_hora = '$fecha',
        P.fecha_hora = '$fecha',
        U.fecha_hora = '$fecha'
        WHERE T.id_trabajador = $id");
            $resultado["resultado"] = "exito";
    }
}
catch(PDOException $error){
    $resultado["resultado"] = $error->getMessage();

}
echo json_encode($resultado);
?>