<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
//busco los datos
$datos = $conexion->query("SELECT
alcance,
tipo,
objetivo,
criterio,
fecha_apertura,
fecha_cierre,
conclusiones,
activo,
( SELECT GROUP_CONCAT( ECA.`name` ) FROM evidencias_cierre_auditorias AS ECA WHERE auditorias.id_auditoria = ECA.id_auditoria ) AS nombres,
( SELECT GROUP_CONCAT( ECA.file_string ) FROM evidencias_cierre_auditorias AS ECA WHERE auditorias.id_auditoria = ECA.id_auditoria ) AS file_strings 
FROM
auditorias 
WHERE
id_auditoria =$id");
$row_datos = $datos->fetch(PDO::FETCH_ASSOC);
//busco los planes
$planes = $conexion->query("SELECT
PA.id_plan,
D.direccion,
P.proceso,
CONCAT(
    Pe.nombre,
    ' ',
    PE.ap_paterno,
    ' ',
    PE.ap_materno
) AS responsable,
PA.fecha_hora_plan,
PA.elementos,
PA.activo,
GROUP_CONCAT(
    CONCAT(
        PE2.nombre,
        ' ',
        PE2.ap_paterno,
        ' ',
        PE2.ap_materno
    )
) AS auditores
FROM
planes_auditorias AS PA
INNER JOIN direcciones AS D ON PA.id_direccion = D.id_direccion
INNER JOIN procesos AS P ON PA.id_proceso = P.id_proceso
INNER JOIN usuarios AS U ON PA.id_responsable = U.id_usuario
INNER JOIN personas AS PE ON U.id_persona = PE.id_persona
INNER JOIN auditores_planes AS AP ON PA.id_plan = AP.id_plan
INNER JOIN usuarios AS U2 ON AP.id_usuario = U2.id_usuario
INNER JOIN personas AS PE2 ON U2.id_persona = PE2.id_persona
WHERE
PA.id_auditoria = $id
GROUP BY
PA.id_plan");
$row_datos["planes"] = $planes->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($row_datos);
?>