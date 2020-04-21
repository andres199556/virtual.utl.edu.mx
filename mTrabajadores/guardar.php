<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
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
$password = $_POST["password"];
$resultado = array();
$activo = 1;
$fecha_hora = date("Y:m:d H:i:s");
if($sexo == "H"){
    $fotografia = "images/profile/avatarH.jpg";
}
else{
    $fotografia = "images/profile/avatarM.jpg";
}
try{
    //busco que no exista algun valor
    $buscar = $conexion->query("SELECT id_trabajador,correo,no_empleado,curp
    FROM trabajadores as T
    INNER JOIN personas as P ON T.id_persona = P.id_persona
    WHERE P.curp = '$curp'
    OR T.no_empleado = $no_empleado OR T.correo = '$correo'
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
        $insertar = $conexion->query("INSERT INTO personas(
            nombre,
            ap_paterno,
            ap_materno,
            fecha_nacimiento,
            sexo,
            direccion,
            colonia,
            ciudad,
            estado,
            pais,
            edo_civil,
            fecha_hora,
            activo,
            id_usuario,
            curp,
            fotografia)VALUES(
                '$nombre',
                '$paterno',
                '$materno',
                '$fecha_nacimiento',
                '$sexo',
                '$direccion',
                '$colonia',
                '$ciudad',
                '$estado',
                '$pais',
                '$edo_civil',
                '$fecha_hora',
                $activo,
                $id_usuario_logueado,
                '$curp',
                '$fotografia'
            )");
            $id_persona = $conexion->lastInsertId();
            //agrego el trabajador
            $insertar_trabajador = $conexion->query("INSERT INTO trabajadores(
                id_persona,
                no_empleado,
                correo,
                fecha_ingreso_trabajo,
                id_departamento,
                id_direccion,
                id_puesto,
                fecha_hora,
                activo,
                id_usuario
            )VALUES(
                $id_persona,
                $no_empleado,
                '$correo',
                '$fecha_ingreso',
                $id_departamento,
                $id_direccion,
                $id_puesto,
                '$fecha_hora',
                $activo,
                $id_usuario_logueado
            )");
            $id_trabajador = $conexion->lastInsertId();
            //inserto el usuario
            $password_enc = md5($password);
            $insertar_usuario  =$conexion->query("INSERT INTO usuarios(
                id_persona,
                usuario,
                password,
                password_sin_enc,
                cambiar_contra,
                fecha_hora,
                activo,
                id_usuario_alta
            )VALUES(
                $id_persona,
                '$correo',
                '$password_enc',
                '$password',
                1,
                '$fecha_hora',
                $activo,
                $id_usuario_logueado
            )");
            $id_usuario = $conexion->lastInsertId();
            //busco los modulos
            $modulos = $conexion->query("SELECT id_modulo,carpeta_modulo
            FROM modulos");
            while($row_m = $modulos->fetch(PDO::FETCH_NUM)){
                $id_modulo = $row_m[0];
                $carpeta = $row_m[1];
                if($carpeta == "mMensajes"){
                    $permiso = 2;
                }
                else{
                    $permiso = 0;
                }
                //Agrego el registro del modulo
                $agregar = $conexion->query("INSERT INTO permiso_modulos(
                    id_modulo,
                    id_usuario,
                    permiso,
                    fecha_hora,
                    activo,
                    id_usuario_alta
                )VALUES(
                    $id_modulo,
                    $id_usuario,
                    $permiso,
                    '$fecha_hora',
                    $activo,
                    $id_usuario_logueado
                )");
            }
            $resultado["resultado"] = "exito";
    }
}
catch(PDOException $error){
    $resultado["resultado"] = $error->getMessage();

}
echo json_encode($resultado);
?>