<?php
include "../conexion/conexion.php";
$usuario  =$_POST["usuario"];
$password = md5($_POST["password"]);
$array_resultado = array();
//mando llamar el procedimiento para buscar el usuario
try{
    //preparo la consulta
    $resultado = $conexion->query("SELECT
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
		usuario = '$usuario'
	AND PASSWORD = '$password'");
    //ejecuto la consulta
    //extraigo la cantidad de filas mediante el indice
    $fila = $resultado->fetch(PDO::FETCH_NUM);
    $cantidad_filas = $fila[0];
    if($cantidad_filas == 0){
        $array_resultado["resultado"] = "error_usuario";
    $array_resultado["mensaje"] = "El usuario no existe en el sistema";
    }
    else{
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
        if($primer_acceso == 1){
            $array_resultado["resultado"] = "primer_acceso";
            $array_resultado["id"] = $id_usuario;
            session_name("session_activa_sixara");
            session_start();
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["id_persona"] = $id_persona;
            $_SESSION["nombre_persona"] = $nombre_persona;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["correo"] = $correo;
            $_SESSION["nombre_corto"] = $nombre_corto;
            $_SESSION["id_trabajador"] = $id_trabajador;
            $_SESSION["sesion_activa"] = "SI";
            $_SESSION["ultimo_acceso"] = date("Y-m-d H:i:s");
            $_SESSION["fotografia"] = $fotografia;
        }
        else if($cambiar_contra == 1){
            //se necesita cambiar la contraseña
            $array_resultado["resultado"] = "cambiar_contra";
            $array_resultado["id"] = $id_usuario;
        }
        else if($llenar_informacion == 1 || $llenar_informacion == null){
            $array_resultado["resultado"] = "llenar_informacion";
            $array_resultado["id"] = $id_usuario;
            //creo la sesión
            session_name("session_activa_sixara");
            session_start();
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["id_persona"] = $id_persona;
            $_SESSION["nombre_persona"] = $nombre_persona;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["correo"] = $correo;
            $_SESSION["nombre_corto"] = $nombre_corto;
            $_SESSION["id_trabajador"] = $id_trabajador;
            $_SESSION["sesion_activa"] = "SI";
            $_SESSION["ultimo_acceso"] = date("Y-m-d H:i:s");
            $_SESSION["fotografia"] = $fotografia;
        }
        else{
            //creo la sesión
            session_name("session_activa_sixara");
            session_start();
            $_SESSION["id_usuario"] = $id_usuario;
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
        
    }
}
catch(PDOException $error){
    $array_resultado["resultado"] = "error_bd";
    $array_resultado["mensaje"] = "Error: ".$error->getMessage();
}
header('Content-type: application/json');
echo json_encode($array_resultado);
?>