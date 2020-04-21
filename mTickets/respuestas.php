<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$ticket = $_POST["ticket"];
                                        //busco las respuestas del ticket
                                        $respuestas = $conexion->prepare("SELECT
	id_mensaje,
	mensaje,
	MT.fecha,
	MT.hora,
	concat(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS solicitante,
    (
		SELECT
			count(ET.id_evidencia)
		FROM
			evidencias_tickets AS ET
		WHERE
			ET.id_mensaje = MT.id_mensaje
	) AS evidencias,
    S.id_estado_servicio
FROM
	mensajes_tickets AS MT
INNER JOIN usuarios AS U ON MT.id_usuario = U.id_usuario
INNER JOIN personas AS P ON P.id_persona = U.id_persona
INNER JOIN servicios as S ON MT.ticket = S.codigo_servicio
WHERE
	ticket = '$ticket'");
                                        $respuestas->execute();
                                        while($row_mensajes = $respuestas->fetch(PDO::FETCH_NUM)){
                                            $id_mensaje = $row_mensajes[0];
                                            $mensaje = $row_mensajes[1];
                                            $fecha_mensaje = $row_mensajes[2];
                                            $hora_mensaje = $row_mensajes[3];
                                            $solicitante = $row_mensajes[4];
                                            $evidencias = $row_mensajes[5];
                                            $id_estado_servicio = $row_mensajes[6];
                                            ?>
                                            <div class="card card-outline-success" id="respuesta_<?php echo $id_mensaje;?>">
                                               <div class="card-header">
                                                   <div class="row">
                                                     <?php
                                            if($id_estado_servicio != 8 && $id_estado_servicio != 6){
                                                ?>
                                                <div class="col-md-8"></div>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <div class="col-md-10"></div>
                                                <?php
                                            }
                                            ?>
                                                       <div class="col-md-2">
                                                           <a href="imprimir.php?ticket=<?php echo $ticket;?>&respuesta=<?php echo $id_mensaje;?>" target="_blank" class="btn btn-secondary btn-block"><i class="fas fa-print"></i> Imprimir</a>
                                                       </div>
                                                       <?php
                                            if($permiso_acceso == 1 && $id_estado_servicio != 8 && $id_estado_servicio != 6){
                                                ?>
                                                <div class="col-md-2">
                                                           <div class="btn-group">
          <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-wrench"></i> Opciones</button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="javascript:enviar_notificacion('<?php echo $ticket;?>',<?php echo $id_mensaje;?>)"><i class="fas fa-envelope"></i> Enviar notificación</a>
            <a class="dropdown-item" href="javascript:eliminar_respuesta(<?php echo $id_mensaje;?>,'<?php echo $ticket;?>')"><i class=" fas fa-times-circle"></i> Eliminar respuesta</a>
            
          </div>
        </div>
                                                       </div>
                                                <?php
                                            }
                                            else{
                                                
                                            }
                                            ?>
                                                   </div>
                                               </div>
                                                <div class="card-body">
                                                   <div class="row">
                                                       <div class="col-md-12">
                                                           <label for="style:font-weight:bold;"><strong>Fecha: </strong></label> <?php echo $fecha_mensaje." - ".$hora_mensaje;?>
                                                       </div>
                                                       <div class="col-md-12">
                                                           <label for="style:font-weight:bold;"><strong>Usuario: </strong></label> <?php echo $solicitante;?>
                                                       </div>
                                                   </div>
                                                   <div class="row">
                                                           <div class="col-md-12">
                                                               <label style="font-weight:bold;" for="" class="control-label">Mensaje: </label>
                                                           </div>
                                                       </div>
                                                       <div class="row">
                                                           <div class="col-md-12">
                                                               <?php echo $mensaje;?>
                                                           </div>
                                                       </div>
                                                       <br><br>
                                                       <?php
                                            if($evidencias != 0){
                                                ?>
                                                <div class="row">
                                                           <div class="col-md-12">
                                                               <label for="" class="control-label"><strong>Archivos adjuntos:</strong></label>
                                                           </div>
                                                           <?php
                                                //busco las evidencias
                                                $evidencias = $conexion->prepare("SELECT id_evidencia,ruta_evidencia,nombre_evidencia FROM evidencias_tickets WHERE ticket = '$ticket' AND id_mensaje = $id_mensaje");
                                                $evidencias->execute();
                                                while($row_evidencias = $evidencias->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <div class="col-md-12">
                                                        <a href="<?php echo $row_evidencias[1];?>" download><?php echo $row_evidencias[2];?></a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                       </div>
                                                <?php
                                            }
                                            else{
                                                
                                            }
                                            ?>      
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>