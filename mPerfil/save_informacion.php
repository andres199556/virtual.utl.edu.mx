<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
$nombre = $_POST["nombre"];
$id = $_POST["id"];
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
$tipo  =$_POST["tipo"];
if($sexo == "H"){
    $fotografia = "images/profile/avatarH.jpg";
}
else{
    $fotografia = "images/profile/avatarM.jpg";
}
try{
    $fecha_hora = date("Y-m-d H:i:s");
    $actualizar = $conexion->query("UPDATE personas as P
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    INNER JOIN usuarios as U ON P.id_persona = U.id_persona
    SET P.nombre = '$nombre',
    P.ap_paterno = '$paterno',
    P.ap_materno = '$materno',
    P.sexo = '$sexo',
    P.fecha_nacimiento = '$fecha_nacimiento',
    P.edo_civil = '$edo_civil',
    P.direccion = '$direccion',
    P.colonia = '$colonia',
    P.ciudad = '$ciudad',
    P.estado = '$estado',
    P.pais = '$pais',
    P.curp = '$curp',
    T.correo = '$correo',
    T.fecha_ingreso_trabajo = '$fecha_inicio_trabajo',
    T.id_direccion = $id_direccion,
    T.id_departamento = $id_departamento,
    T.id_puesto = $id_puesto,
    T.no_empleado = $no_empleado,
    U.llenar_informacion = 0,
    P.fecha_hora = '$fecha_hora',
    T.fecha_hora = '$fecha_hora',
    U.fecha_hora = '$fecha_hora'
    WHERE U.id_usuario = $id");
    if($tipo == "primer_acceso"){
        $password = $_POST["password"];
        
        $pd = md5($password);
        $update = $conexion->query("UPDATE usuarios SET password = '$pd',password_sin_enc = '$password',primer_acceso = 0,cambiar_contra = 0,llenar_informacion = 0 WHERE id_usuario  =$id");
        session_name("session_activa_sixara");
        //preparo la consulta
    $resultado2 = $conexion->query("SELECT
	count(U.id_usuario) as existe_usuario ,
		U.id_usuario,
P.id_persona,
concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona,
T.correo,
concat(SUBSTRING_INDEX(P.nombre,' ',1),' ',P.ap_paterno) as nombre_corto,T.id_trabajador,
U.cambiar_contra,
U.llenar_informacion,
U.primer_acceso,
P.fotografia
	FROM
		usuarios as U
inner join personas as P ON U.id_persona = P.id_persona
left join trabajadores as T ON P.id_persona = T.id_persona
	WHERE
        U.id_usuario = $id");
        $fila = $resultado2->fetch(PDO::FETCH_NUM);
        //extraigo los datos
        $id_usuario = $fila[1];
        $id_persona = $fila[2];
        $nombre_persona = $fila[3];
        $correo = $fila[4];
        $nombre_corto = $fila[5];
        $id_trabajador = $fila[6];
        $cambiar_contra = $fila[7];
        $llenar_informacion = $fila[8];
        $primer_acceso = $fila[9];
        $fotografia = $fila[10];
            session_start();
            $_SESSION["id_usuario"] = $id;
            $_SESSION["id_persona"] = $id_persona;
            $_SESSION["nombre_persona"] = $nombre_persona;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["correo"] = $correo;
            $_SESSION["nombre_corto"] = $nombre_corto;
            $_SESSION["id_trabajador"] = $id_trabajador;
            $_SESSION["sesion_activa"] = "SI";
            $_SESSION["ultimo_acceso"] = date("Y-m-d H:i:s");
            $array_resultado["resultado"] = "exito";
            $array_resultado["s_id"] = session_id();
            $array_resultado["user_id"] = $id_usuario;
            $array_resultado["date"] = date("Y-m-d H:i:s");
            $array_resultado["mensaje"] = "Bienvenido: ".$nombre_persona;
            $_SESSION["fotografia"] = $fotografia;
    }
    $resultado["resultado"] = "exito";
    
}
catch(PDOException $error){
    $resultado["resultado"] = $error->getMessage();

}
echo json_encode($resultado);
?>