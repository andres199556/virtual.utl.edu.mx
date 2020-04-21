<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
include "../conexion/conexion.php";
$resultado = array();
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_conversacion = $_POST["id_c"];
$id_usuario_logueado = $_POST["id_user"];
$array_con = "";

    //busco los datos de la conversacion, como el usuario
    $datos_conversacion = $conexion->query("SELECT
	C.id_conversacion,
	(
		SELECT
			COUNT(
				IC.id_integrante_conversacion
			)
		FROM
			integrantes_conversaciones AS IC
		WHERE
			IC.id_conversacion = $id_conversacion
	) AS integrantes,
	(
		SELECT
			IC.apodo
		FROM
			integrantes_conversaciones AS IC
		INNER JOIN usuarios AS U ON IC.id_usuario = U.id_usuario
		INNER JOIN personas AS P ON U.id_persona = P.id_persona
		WHERE
			IC.id_conversacion = $id_conversacion
		AND IC.id_usuario != $id_usuario_logueado
	) AS apodo,
    C.color,
    (
		SELECT
			IC.id_usuario
		FROM
			integrantes_conversaciones AS IC
		INNER JOIN usuarios AS U ON IC.id_usuario = U.id_usuario
		INNER JOIN personas AS P ON U.id_persona = P.id_persona
		WHERE
			IC.id_conversacion = $id_conversacion
		AND IC.id_usuario != $id_usuario_logueado
	) AS integrante_conversacion
    FROM
        conversaciones AS C
    WHERE
        C.tipo_conversacion = 'normal' AND C.id_conversacion = $id_conversacion");
        $row_conversacion = $datos_conversacion->fetch(PDO::FETCH_ASSOC);
        $apodo = $row_conversacion["apodo"];
        $color = $row_conversacion["color"];
        $user_id = $row_conversacion["integrante_conversacion"];
        $resultado["resultado"] = "existe_conversacion";
        $resultado["id_conversacion"] = $id_conversacion;
        $resultado["apodo"] = $apodo;
        $resultado["color"] = $color;
        $resultado["user_id"] = $user_id;
        $resultado["mensajes"] = array();
        //busco los ultimos 5 mensajes de la conversacion
        $buscar_mensajes = $conexion->query("SELECT
        M.id_mensaje,
        M.mensaje,
        IC.apodo,
        M.fecha_hora,
        M.acceso_mensaje,
        IF(M.id_usuario_remitente = $id_usuario_logueado,'inverse','normal') as class,
        (
            SELECT
                COUNT(VM.visto_web)
            FROM
                vistos_mensajes AS VM
            WHERE
                VM.id_mensaje = M.id_mensaje
            AND VM.id_conversacion = $id_conversacion
            AND VM.id_usuario = $id_usuario_logueado
        ) AS visto,
        (
            SELECT
                COUNT(VM.visto_app)
            FROM
                vistos_mensajes AS VM
            WHERE
                VM.id_mensaje = M.id_mensaje
            AND VM.id_conversacion = $id_conversacion
            AND VM.id_usuario = $id_usuario_logueado
        ) AS visto_app,
        P.fotografia,
        M.tipo_mensaje
    FROM
        mensajes AS M
    INNER JOIN integrantes_conversaciones AS IC ON M.id_usuario_remitente = IC.id_usuario
    INNER JOIN usuarios AS U ON IC.id_usuario = U.id_usuario
    INNER JOIN personas AS P ON U.id_persona = P.id_persona
    WHERE
        M.id_conversacion = $id_conversacion
        AND (
            M.acceso_mensaje LIKE '$id_usuario_logueado,%'
            OR M.acceso_mensaje LIKE '%,$id_usuario_logueado'
            OR M.acceso_mensaje LIKE '%,$id_usuario_logueado,%'
        )
        GROUP BY
	M.id_mensaje
ORDER BY
	M.id_mensaje DESC
    LIMIT 5");
    $cantidad = $buscar_mensajes->rowCount();
        if($cantidad == 0){
            //no tiene mensajes   
        }
        else{
            while($row_m = $buscar_mensajes->fetch(PDO::FETCH_ASSOC)){
                $resultado["mensajes"][] = $row_m;
            }
        }

echo json_encode($resultado);
?>