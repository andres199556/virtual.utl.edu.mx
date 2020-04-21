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
$correo  =$_POST["correo_i"];
$matricula  =$_POST["matricula"];
$sede = $_POST["sede"];
$carrera = $_POST["carrera"];
/* $password = $_POST["password"]; */
$resultado = array();
$activo = 1;
$rfc = $_POST["rfc"];
$telefono = $_POST["telefono"];
$correo_personal  =$_POST["correo"];
$tutor = $_POST["tutor"];
$seguro = $_POST["seguro"];
$fecha_hora = date("Y:m:d H:i:s");
$fotografia = ($sexo == "H") ? "images/profile/avatarH.jpg":"images/profile/avatarM.jpg";
try{
    //busco que no exista algun valor
    $buscar = $conexion->query("SELECT A.id_persona,id_alumno,curp,rfc,A.correo,A.matricula
    FROM alumnos as A
    INNER JOIN personas as P ON A.id_persona = P.id_persona
    WHERE P.curp = '$curp' OR P.rfc = '$rfc' OR A.matricula = $matricula OR A.correo = '$correo'
    ");
    $existe = $buscar->rowCount();
    if($existe == 1){
        //el registro existe
        $row = $buscar->fetch(PDO::FETCH_NUM);
        $curp_v = $row[2];
        $rfc_existe = $row[3];
        $correo_existe = $row[4];
        $matricula_existe = $row[5];
        if($curp == $curp_v){
            $resultado["resultado"] = "existe_curp";
        }
        else if($rfc == $rfc_existe){
            $resultado["resultado"] = "existe_rfc";
        }
        else if($correo_existe == $correo){
            $resultado["resultado"] = "existe_correo";
        }
        else if($matricula == $matricula_existe){
            $resultado["resultado"] = "existe_matricula";
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
            fotografia,
            rfc,
            correo_personal,
            telefono)VALUES(
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
                '$fotografia',
                '$rfc',
                '$correo_personal',
                '$telefono'
            )");
            $id_persona = $conexion->lastInsertId();
            //agrego el trabajador
            $grupo = (isset($_POST["sin_grupo"])) ? 0:$_POST["grupo"];
            $correo_institucional = (isset($_POST["crear_correo"])) ? $_POST["correo"]:$matricula."@utl.edu.mx";
            
            $add_alumno  =$conexion->query("INSERT INTO alumnos(
                id_persona,
                matricula,
                id_carrera,
                id_sede,
                id_grupo_actual,
                correo_institucional,
                tutor,
                seguro_facultativo,
                fecha_hora,
                activo,
                id_usuario
            )VALUES(
                $id_persona,
                '$matricula',
                $carrera,
                $sede,
                $grupo,
                '$correo_institucional',
                '$tutor',
                '$seguro',
                '$fecha_hora',
                $activo,
                $id_usuario_logueado  
            )");
            $id_trabajador = $conexion->lastInsertId();
            //inserto el usuario
            $password_enc = md5("123456789");
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
                '$correo_institucional',
                '$password_enc',
                '$password',
                1,
                '$fecha_hora',
                $activo,
                $id_usuario_logueado
            )");
            $resultado["resultado"] = "exito_alta";
            $resultado["mensaje"] = "alumno creado correctamente!";
    }
}
catch(PDOException $error){
    $resultado["resultado"] = $error->getMessage();

}
echo json_encode($resultado);
?>