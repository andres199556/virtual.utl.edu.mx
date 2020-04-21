<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$resultado = array();
$fecha_hora = date("Y-m-d H:i:s");
$activo = 1;
$id_integrante = $_POST["id_integrante"];
$type = $_POST["type"];
$array_con = "";
if($type == "na"){
    //estoy buscando por usuario
    if($id_integrante < $id_usuario_logueado){
        $array_con.=$id_integrante.",".$id_usuario_logueado;
    }
    else{
        $array_con.=$id_usuario_logueado.",".$id_integrante;
    }
        $buscar_conversacion = $conexion->query("SELECT
    C.id_conversacion,
    (
        SELECT
            COUNT(
                IC.id_integrante_conversacion
            )
        FROM
            integrantes_conversaciones AS IC
        WHERE
            IC.id_conversacion = C.id_conversacion
        AND IC.id_usuario = $id_integrante
        OR IC.id_usuario = $id_usuario_logueado
    ) AS integrantes,
    (
            SELECT
                IC.apodo
            FROM
                integrantes_conversaciones AS IC
            INNER JOIN usuarios AS U ON IC.id_usuario = U.id_usuario
            INNER JOIN personas AS P ON U.id_persona = P.id_persona
            WHERE
                IC.id_conversacion = C.id_conversacion
            AND IC.id_usuario != $id_usuario_logueado
        ) as apodo
    FROM
    conversaciones AS C
    WHERE
    C.tipo_conversacion = 'normal' AND  C.array_integrantes = '$array_con'
    ");
    $existe = $buscar_conversacion->rowCount();
    if($existe == 0){
        $resultado["resultado"] = "no_existe";
        //no existe niguna conversacion
        //busco el nombre de la persona
        $buscar_datos = $conexion->query("SELECT CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as nombre
        FROM usuarios as U
        INNER JOIN personas as P ON U.id_persona = P.id_persona
        WHERE U.id_usuario = $id_integrante");
        $row_datos = $buscar_datos->fetch(PDO::FETCH_NUM);
        $nombre = $row_datos[0];
        $resultado["apodo"] = $nombre;
        //creo la conversacion
        $agregar_conversacion = $conexion->query("INSERT INTO conversaciones(
            nombre_conversacion,
            fecha_hora,
            color,
            activo,
            imagen_conversacion,
            tipo_conversacion,
            array_integrantes
        )VALUES(
            'NA',
            '$fecha_hora',
            '\#ff0000',
            $activo,
            'NA',
            'normal',
            '$array_con'
        )");
        //extraigo el id de conversacion insertado
        $id_conversacion = $conexion->lastInsertId();
        $resultado["id_conversacion"] = $id_conversacion;
        //agrego los integrantes
        $agregar_integrantes = $conexion->query("INSERT INTO integrantes_conversaciones(
            id_conversacion,
            id_usuario,
            apodo,
            fecha_hora,
            activo
        )VALUES(
            $id_conversacion,
            $id_usuario_logueado,
            '$nombre_completo_logueado',
            '$fecha_hora',
            $activo
        ),(
            $id_conversacion,
            $id_integrante,
            '$nombre',
            '$fecha_hora',
            $activo
        )");
    }
    else{
        $row_c = $buscar_conversacion->fetch(PDO::FETCH_NUM);
        $integrantes = $row_c[1];
        if($integrantes != 2){
            //todavia no existe la conversacion
        }
        else{
            //ya existe
            //extraigo el id de conversacion
            $resultado["resultado"] = "existe";
            $id_conversacion = $row_c[0];
            $resultado["id_conversacion"] = $id_conversacion;
            $resultado["apodo"] = $row_c[2];
            $resultado["user_id"] = $id_integrante;
            
        }
    }
}
else if($type == "normal"){
    //es una conversacion normal
    $id_conversacion = $id_integrante;
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
        P.fotografia
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
    ORDER BY
        M.fecha_hora DESC
    LIMIT 5");
    $cantidad = $buscar_mensajes->rowCount();
        if($cantidad == 0){
            //no tiene mensajes   
        }
        else{
            while($row_m = $buscar_mensajes->fetch(PDO::FETCH_NUM)){
                $resultado["mensajes"][] = $row_m;
            }
        }
}
else if($type == "grupal"){
    //es una conversacion normal
    $id_conversacion = $id_integrante;
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
	C.color,
	C.nombre_conversacion,
	C.imagen_conversacion,
	C.array_integrantes
FROM
	conversaciones AS C
WHERE
	C.tipo_conversacion = 'grupal'
AND C.id_conversacion = $id_conversacion");
        $row_conversacion = $datos_conversacion->fetch(PDO::FETCH_ASSOC);
        $color = $row_conversacion["color"];
        $resultado["resultado"] = "existe_conversacion";
        $resultado["id_conversacion"] = $id_conversacion;
        $resultado["integrantes"] = $row_conversacion["integrantes"];
        $resultado["nombre_conversacion"] = $row_conversacion["nombre_conversacion"];
        $arr_integrantes = $row_conversacion["array_intgrantes"];
        $resultado["color"] = $color;      
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
        P.fotografia
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
        GROUP BY M.id_mensaje
    ORDER BY
        M.fecha_hora DESC
    LIMIT 5");
    $cantidad = $buscar_mensajes->rowCount();
        if($cantidad == 0){
            //no tiene mensajes   
        }
        else{
            while($row_m = $buscar_mensajes->fetch(PDO::FETCH_NUM)){
                $resultado["mensajes"][] = $row_m;
            }
        }
}


echo json_encode($resultado);
?>