<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
try{
    $resultado = array();
    include "../conexion/conexion.php";
    $id_usuario_logueado = $_POST["id"];
    $conversaciones = $conexion->query("SELECT
    C.id_conversacion,
    C.tipo_conversacion,

IF (
    C.tipo_conversacion = 'normal',
    (
        SELECT
            P.fotografia
        FROM
            integrantes_conversaciones AS ICO
        INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
        INNER JOIN personas AS P ON U.id_persona = P.id_persona
        WHERE
            ICO.id_conversacion = C.id_conversacion
        AND ICO.id_usuario != $id_usuario_logueado
    ),
    C.imagen_conversacion
) AS imagen_conversacion,

IF (
    C.tipo_conversacion = 'normal',
    (
        SELECT
            ICO.apodo
        FROM
            integrantes_conversaciones AS ICO
        INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
        INNER JOIN personas AS P ON U.id_persona = P.id_persona
        WHERE
            ICO.id_conversacion = C.id_conversacion
        AND ICO.id_usuario != $id_usuario_logueado
    ),
    C.nombre_conversacion
) AS nombre_conversacion,
 (
    SELECT
        M.mensaje
    FROM
        mensajes AS M
    WHERE
        M.id_conversacion = C.id_conversacion AND M.activo = 1
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
) AS mensaje,
 (
    SELECT
        DATE(M.fecha_hora)
    FROM
        mensajes AS M
    WHERE
        M.id_conversacion = C.id_conversacion
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
) AS fecha,
 (
    SELECT
        TIME_FORMAT(
            TIME(M.fecha_hora),
            '%h:%i %p'
        )
    FROM
        mensajes AS M
    WHERE
        M.id_conversacion = C.id_conversacion
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
) AS hora,
 (
    SELECT
        M.id_usuario_remitente
    FROM
        mensajes AS M
    WHERE
        M.id_conversacion = C.id_conversacion
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
) AS remitente,
(
    SELECT
        M.tipo_mensaje
    FROM
        mensajes AS M
    WHERE
        M.id_conversacion = C.id_conversacion
    ORDER BY
        M.id_mensaje DESC
    LIMIT 1
) AS tipo_mensaje,
(
SELECT
COUNT(M.id_mensaje)
FROM
mensajes AS M
WHERE
M.id_conversacion = C.id_conversacion
ORDER BY
M.id_mensaje DESC
) AS cantidad_mensajes
FROM
    conversaciones AS C
INNER JOIN integrantes_conversaciones AS IC ON C.id_conversacion = IC.id_conversacion
WHERE
C.array_integrantes LIKE ',$id_usuario_logueado,' OR C.array_integrantes LIKE '%,$id_usuario_logueado' OR C.array_integrantes LIKE '$id_usuario_logueado,%'
GROUP BY
    C.id_conversacion
ORDER BY
    fecha DESC,
    hora ASC
    LIMIT 10");
    $cantidad = $conversaciones->rowCount();
    if($cantidad == 0){
        //no existen conversaciones
        $resultado["resultado"] = "exito";
        $resultado["cantidad"] = $cantidad;
        $resultado["mensaje"] = "<p class='text-center text-success'><i class='fa fa-comments'></i> <b>Aún no tienes conversaciones</b></p>";
    }
    else{
        $resultado["resultado"] = "exito";
        $resultado["cantidad"] = $cantidad;
        $resultado["conversaciones"] = array();
        $array_conversaciones = array();
        while ($row_c = $conversaciones->fetch(PDO::FETCH_ASSOC)) {
            $resultado["conversaciones"][] = $row_c;
        }
    }
    
}
catch(PDOException $error){

}
header('Content-type: application/json');
echo json_encode($resultado);
?>