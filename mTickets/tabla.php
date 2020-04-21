<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$consulta = "SELECT
	S.id_servicio,
	concat(
		P1.nombre,
		' ',
		P1.ap_paterno,
		' ',
		P1.ap_materno
	) AS usuario_solicitante,
	concat(
		P2.nombre,
		' ',
		P2.ap_paterno,
		' ',
		P2.ap_materno
	) AS responsable,
	TS.tipo_servicio,
	S.id_estado_servicio,
	S.id_usuario_responsable,
	S.titulo_servicio,
	S.codigo_servicio,
    S.prioridad,
    ET.estado_ticket,
    ET.color,
    S.fecha,
    S.hora
FROM
	servicios AS S /* inner join para el usuario solicitante */
INNER JOIN usuarios AS U1 ON S.id_usuario_solicitante = U1.id_usuario
INNER JOIN personas AS P1 ON U1.id_persona = P1.id_persona /* inner join para el trabajador */
LEFT JOIN usuarios AS U2 ON S.id_usuario_responsable = U2.id_usuario
LEFT JOIN personas AS P2 ON U2.id_persona = P2.id_persona
LEFT JOIN tipo_servicios AS TS ON S.id_tipo_servicio = TS.id_tipo_servicio
LEFT JOIN estado_tickets as ET ON S.id_estado_servicio = ET.id_estado_ticket";
if($permiso_acceso == 1){
    //es administrador, por lo tanto, muestro todos los tickets
    
    
}
else{
    $consulta.="
    WHERE
        S.id_usuario_solicitante = $id_usuario_logueado OR S.id_usuario_responsable = $id_usuario_logueado";
    //solo tiene permisos de ver los tickets propios
}
                                                    //busco los datos de los servicios
                                                    $servicios = $conexion->prepare($consulta);
                                                    $servicios->execute();
                                                    $n = 0;
                                                    while($row = $servicios->fetch(PDO::FETCH_NUM)){
                                                        $botones = "";
                                                        ++$n;
                                                        $id_servicio = $row[0];
                                                        $usuario_servicio = $row[1];
                                                        $servicio = $row[6];
                                                        $id_responsable = $row[5];
                                                        $codigo_servicio = $row[7];
                                                        $prioridad = $row[8];
                                                        $text_estado_servicio = $row[9];
                                                        $color_estado = $row[10];
                                                        $fecha_servicio = $row[11];
                                                        $hora_servicio = $row[12];
                                                        $ultima_fecha = new datetime("$fecha_servicio $hora_servicio");
                                                        $fecha_actual = new datetime(date("Y-m-d")." ".date("H:i:s"));
                                                        $intervalo = $ultima_fecha->diff($fecha_actual);
                                                        $ultimo_acceso_servicio = obtener_diferencia_fecha($intervalo);

                                                        if($id_responsable == 0){
                                                            //todavia no se asigna el servicio
                                                            $nombre_responsable = "N/A";
                                                        }
                                                        else{
                                                            $nombre_responsable = $row[2];
                                                        }
                                                        $estado_servicio = $row[4];
                                                        //primero verifico que ya este asignado, de lo contrario no muestro los datos
                                                        if($estado_servicio == 0){
                                                            //$usuario_servicio = "<<-Información oculta->>";
                                                        }
                                                        else{
                                                        }
                                                        switch($estado_servicio){
                                                                //sin asignar
                                                            case 0:
                                                                //muestro solo el botón para asignar
                                                                $botones.= "<td><button onclick='tomar_servicio($id_servicio);' title='Tomar servicio' data-toggle='tooltip' class='btn btn-info'><i class='fas fa-wrench'></i></button></td>";
                                                                break;
                                                                
                                                                
                                                                //asignado
                                                            case 1:
                                                                $botones.="<td><a href='javascript:liberar($id_servicio);' title='Liberar servicio' data-toggle='tooltip' class='btn btn-success'><i class='fas fa-check'></i></a></td>";
                                                                $botones.="<td class='text-center'><button class='btn btn-info' onclick='cambiar_estado($id_servicio);' title='Completar información' data-toggle='tooltip'><i class='fas fa-cogs'></i></button></td>";
                                                                break;
                                                                
                                                                //pendiente si falta comprar material
                                                            case 2:
                                                                break;
                                                                
                                                                
                                                                //servicio liberado
                                                            case 3:
                                                                //solo muestro el botón para ver el historico descargar el servicio
                                                                $botones.="<td><a href='ficha_servicio.php?servicio=$codigo_servicio' class='btn btn-success' title='Descargar ficha de servicio' data-toggle='tooltip'><i class='fas fa-download'></i></a></td>";
                                                                break;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><a href="ticket.php?ticket=<?php echo $codigo_servicio;?>"><?php echo $codigo_servicio;?></a></td>
                                                            <td class="text-center"><label for="" title="<?php echo $fecha_servicio.' - '.$hora_servicio;?>" data-toggle="tooltip"><?php echo $ultimo_acceso_servicio;?></label></td>
                                                            <?php
                                                        if($permiso_acceso == 1){
                                                            ?>
                                                            <td class="text-center"><?php echo $usuario_servicio;?></td>
                                                            <?php
                                                        }
                                                        else{
                                                            
                                                        }
                                                        ?>
                                                            
                                                            <td class="text-center"><?php echo $servicio;?></td>
                                                            <td class="text-center"><?php echo $prioridad;?></td>
                                                            <td class="text-center"><span class="label <?php echo $color_estado;?> m-r-10"><?php echo $text_estado_servicio;?></span></td>
                                                            
                                                            <?php
                                                           }
                                                           ?>