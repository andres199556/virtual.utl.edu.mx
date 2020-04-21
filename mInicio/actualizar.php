<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$nombre = $_POST["nombre"];
$paterno  =$_POST["paterno"];
$materno  =$_POST["materno"];
$fecha_nacimiento  =$_POST["fecha_nacimiento"];
$sexo = $_POST["sexo"];
$direccion  =$_POST["direccion"];
$colonia = $_POST["colonia"];
$ciudad = $_POST["ciudad"];
$estado = $_POST["estado"];
$pais = $_POST["pais"];
$edo_civil = $_POST["edo_civil"];
$id_direccion  =$_POST["id_direccion"];
$id_departamento = $_POST["id_departamento"];
$id_puesto = $_POST["id_puesto"];
$correo = $_POST["correo"];
$no_empleado = $_POST["no_empleado"];
$antigua = $_POST["antigua"];
$nueva = $_POST["nueva"];
$repetir  =$_POST["repetir"];
$curp = strtoupper($_POST["curp"]);
$fecha_ingreso = $_POST["fecha_ingreso"];
$id_direccion  =$_POST["id_direccion"];
$id_departamento = $_POST["id_departamento"];
$id_puesto = $_POST["id_puesto"];
try{
    $fecha_hora = date("Y-m-d H:i:s");
    $activo = 1;
    $id_usuario = $_SESSION["id_usuario"];
    //busco que el curp no se encuentre registrado
    $buscar = $conexion->query("SELECT P.id_persona 
    FROM personas as P
    INNER JOIN usuarios as U ON U.id_persona = P.id_persona
    WHERE curp = '$curp' AND U.id_usuario != $id_usuario");
    $existe = $buscar->rowCount();
    if($existe != 0){
        header("Location:completar_informacion.php?resultado=existe_persona");
    }
    else{
        $insertar = $conexion->query("UPDATE personas as P
        INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
        INNER JOIN usuarios as U ON P.id_persona = U.id_persona
        SET
            nombre = '$nombre',
            ap_paterno = '$paterno',
            ap_materno = '$materno',
            fecha_nacimiento = '$fecha_nacimiento',
            sexo = '$sexo',
            direccion = '$direccion',
            colonia = '$colonia',
            ciudad = '$ciudad',
            estado = '$estado',
            pais = '$pais',
            estado_civil = '$edo_civil',
            P.fecha_hora = '$fecha_hora',
            P.id_usuario = $id_usuario,
            T.no_empleado = $no_empleado,
            T.correo = '$correo',
            T.id_direccion = $id_direccion,
            T.id_departamento = $id_departamento,
            T.id_puesto = $id_puesto,
            T.fecha_ingreso_trabajo = '$fecha_ingreso',
            curp = '$curp',
            U.llenar_informacion = 0
            WHERE U.id_usuario = $id_usuario");
            //verifico si quiere cambiar la contraseña
            if($antigua == "" || $antigua == null){
                //no voy a actualizar
                header("Location:index.php?resultado=exito_actualizacion");
            }
            else{
                //busco si es esa
                $password_antigua = md5($antigua);
                $validar = $conexion->query("SELECT id_usuario
                FROM usuarios
                WHERE id_usuario = $id_usuario AND password = '$password_antigua'");
                $existe = $validar->rowCount();
                if($existe == 0){
                    header("Location:completar_informacion.php?resultado=password_invalido");
                }
                else{
                    //trato de actualizarla
                    $md5_password = md5($nueva);
                    $actualizar_password = $conexion->query("UPDATE usuarios
                    SET password = '$md5_password',
                    fecha_hora = '$fecha_hora',
                    password_sin_enc = '$nueva',
                    cambiar_contra = 0,
                    llenar_informacion = 0
                    WHERE id_usuario = $id_usuario");
                    header("Location:index.php?resultado=exito_actualizacion");
                }
                
            }
            
    }
    
}
catch(Exception $error){
    $error->getMessage();
    header("Location:completar_informacion.php?resultado=error_actualizacion");
}
?>