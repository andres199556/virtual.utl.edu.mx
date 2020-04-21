<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
if(!isset($_GET["ticket"])){
    header("Location:index.php");
}
else{
    $ticket = $_GET["ticket"];
    if($ticket == "" || $ticket == null){
        header("Location:index.php");
    }
    else{
        //busco los datos del servicio
        $servicio = $conexion->prepare("SELECT
	S.id_servicio,
	concat(
		P1.nombre,
		' ',
		P1.ap_paterno,
		' ',
		P1.ap_materno
	) AS usuario,
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
    S.fecha_apertura,
    S.hora_apertura,
    (
		SELECT
			count(id_mensaje)
		FROM
			mensajes_tickets AS TM
		WHERE
			TM.ticket = S.codigo_servicio
	) AS cantidad_mensajes,
    S.prioridad,
    ET.estado_ticket,
    S.id_estado_servicio,
    ET.color,
    S.fecha_liberacion,
    S.hora_liberacion,
    CONCAT(PL.nombre,' ',PL.ap_paterno,' ',PL.ap_materno) as usuario_libero,
    S.comentarios_verificacion
FROM
	servicios AS S /* inner join para el usuario */
INNER JOIN usuarios as U1 ON S.id_usuario_solicitante = U1.id_usuario
INNER JOIN personas as P1 ON U1.id_persona = P1.id_persona
/* inner join para el trabajador */
LEFT JOIN usuarios as U2 ON S.id_usuario_responsable = U2.id_usuario
LEFT JOIN personas as P2 ON U2.id_persona = P2.id_persona
LEFT JOIN tipo_servicios AS TS ON S.id_tipo_servicio = TS.id_tipo_servicio
LEFT JOIN estado_tickets as ET ON S.id_estado_servicio = ET.id_estado_ticket
LEFT JOIN usuarios as UL ON S.id_usuario_liberacion = UL.id_usuario
LEFT JOIN personas as PL ON UL.id_persona = PL.id_persona
WHERE
	S.codigo_servicio = '$ticket'");
        $servicio->execute();
        //existe servicio
        $existe_servicio = $servicio->rowCount();
        if($existe_servicio != 1){
            //no existe y redirigo
            header("Location:index.php");
        }
        else{
            $row_servicio = $servicio->fetch(PDO::FETCH_NUM);
            $id_servicio = $row_servicio[0];
            $usuario_solicitante = $row_servicio[1];
            $responsable = $row_servicio[2];
            $tipo_servicio = $row_servicio[3];
            $estado_servicio = $row_servicio[4];
            $titulo = $row_servicio[6];
            $texto_estado_servicio = $row_servicio[12];
            $id_estado_servicio = $row_servicio[13];
            $color_estado = $row_servicio[14];
            $fecha_liberacion  =$row_servicio[15];
            $hora_liberacion = $row_servicio[16];
            $usuario_libero = $row_servicio[17];
            $comentarios_liberacion = $row_servicio[18];
            $ultima_fecha = new datetime("$fecha_liberacion $hora_liberacion");
            $fecha_actual = new datetime(date("Y-m-d")." ".date("H:i:s"));
            $intervalo = $ultima_fecha->diff($fecha_actual);
            $string_fecha = obtener_diferencia_fecha($intervalo);
            if($responsable == ""){
                $responsable = "Sin definir";
            }
            if($tipo_servicio == ""){
                $tipo_servicio = "Sin especificar";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    include "../template/metas.php";
    ?>
</head>

<body class="fix-sidebar fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        
         <?php
                include "../template/navbar.php";
                ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php
        include "../template/sidebar.php";
        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-8 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $modulo_actual;?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><?php echo $categoria_actual;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $modulo_actual;?></li>
                            <li class="breadcrumb-item">Información del ticket <?php echo $ticket;?></li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-success">
                           <div class="card-header">
                              <div class="row">
                                  <div class="col-lg-9 col-md-10">
                                      <h4 class="m-b-0 text-white">Información histórica del servicio</h4>
                                  </div>
                                  <?php
                                  if($permiso_acceso == 1){
                                      ?>
                                      <div class="col-lg-1">
                                          
                                      </div>
                                      <div class="col-lg-2 col-md-2">
                                                           <div class="btn-group">
          <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-wrench"></i> Opciones</button>
          <div class="dropdown-menu">
           <?php
                                      if($id_estado_servicio != 8 && $id_estado_servicio != 6){
                                          ?>
                                          <a class="dropdown-item" href="#"  data-toggle="modal" data-target="#modal_responsable"><i class="fas fa-envelope"></i> Asignar ticket</a>
                                          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_prioridad"><i class="fas fa-wrench"></i> Cambiar prioridad</a>
                                          <a class="dropdown-item" href="javascript:cambiar_estado('<?php echo $ticket;?>');"><i class="fas fa-info"></i> Cambiar estado</a>
                                          <a class="dropdown-item" href="javascript:cerrar_ticket('<?php echo $ticket;?>')"><i class=" fas fa-check-circle"></i> Cerrar ticket</a>
                                          <?php
                                      }
                                      else if($id_estado_servicio == 6){
                                          //se va a verificar
                                          ?>
                                          <a class="dropdown-item text-success" href="javascript:verificar('<?php echo $ticket;?>');"><i class=" fas fa-check-circle"></i> Verificar y cerrar ticket</a>
                                          <?php
                                      }
                                      else{
                                          
                                      }
                                      ?>
            
            <a class="dropdown-item text-danger" href="javascript:eliminar_ticket('<?php echo $ticket;?>')"><i class=" fas fa-times-circle"></i> Eliminar ticket</a>
            
          </div>
        </div>
                                                       </div>
                                      <?php
                                  }
                                  else{
                                      if($id_estado_servicio == 6){
                                          //muestro solo esa opcion
                                          ?>
                                  <div class="col-lg-1">
                                          
                                      </div>
                                  <div class="col-lg-2 col-md-2">
                                                           <div class="btn-group">
          <button type="button" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-wrench"></i> Opciones</button>
          <div class="dropdown-menu">
                                                        <a class="dropdown-item text-success" href="javascript:verificar('<?php echo $ticket;?>');"><i class=" fas fa-check-circle"></i> Verificar y cerrar ticket</a>
                                                               </div>
                                  </div>
                                  </div>

                                  <?php
                                      }
                                  }
                                  ?>
                                  
                              </div>
                           </div>
                            <div class="card-body">
                              <div class="card card-outline-success">
                                  <div class="card-body">
                                      <div class="row separador-lineas">
                                    <div class="col-md-8">
                                        <label style="font-weight:bold;" class="control-label" for="">Título: </label> <?php echo $titulo;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" style="font-weight:bold;" class="control-label">N° de seguimiento:    </label> <?php echo $ticket;?> (Ticket N° <?php echo $id_servicio;?>)
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" style="font-weight:bold;" class="control-label">Fecha de creación:    </label> <?php echo $row_servicio[8]." - ".$row_servicio[9];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" style="font-weight:bold;" class="control-label">Respuestas:    </label> <?php echo $row_servicio[10];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                       <?php
                                        switch($row_servicio[11]){
                                                
                                            case "Baja":
                                                $prioridad = "<span class='text-success'><strong>Baja</strong></span>";
                                                break;
                                            case "Media":
                                                $prioridad = "<span class='text-warning'><strong>Media</strong></span>";
                                                break;
                                            case "Alta":
                                                $prioridad = "<span class='text-danger'><strong>Alta</strong></span>";
                                                break;
                                            case "Critica":
                                                $prioridad = "<span class='text-black'><strong>Crítica</strong></span>";
                                                break;
                                                
                                        }
                                        ?>
                                        <label for="" style="font-weight:bold;" class="control-label">Prioridad: </label> <?php echo $prioridad;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight:bold;" class="control-label" for="">Usuario solicitante:   </label>  <?php echo $usuario_solicitante;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight:bold;" class="control-label" for="">Usuario responsable del servicio: </label> <?php echo $responsable;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="font-weight:bold;" class="control-label" for="">Tipo de servicio:  </label> <label for="" id="nombre_tipo"><?php echo $tipo_servicio;?> </label> 
                                        <?php
                                        if($permiso_acceso == 1 && $id_estado_servicio != 8){
                                            ?>
                                            <button onclick="mostrar_tipos();" type="button" class="btn btn-sm btn-success">Cambiar</button>
                                            <?php
                                        }
                                        else{
                                            
                                        }
                                        ?>
                                        
                                    </div>
                                </div>
                                 <div class="row">
                                     <div class="col-md-12">
                                         <label style="font-weight:bold;" class="control-label" for="">Estado del ticket:  </label> <label for="" class="label <?php echo $color_estado;?>"><?php echo $texto_estado_servicio;?></label>
                                     </div>
                                 </div>
                                 <?php
                                      if($id_estado_servicio == 8){
                                          //se encuentra liberado
                                          ?>
                                          <div class="row">
                                              <div class="col-md-12 text-center">
                                                  <label style="font-weight:bold;" class="text-center">Fecha y hora de liberación: </label><?php echo " ". $fecha_liberacion;?> - <?php echo $hora_liberacion. " ($string_fecha)";?>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-md-12 text-center">
                                                  <label style="font-weight:bold;" class="text-center">Usuario que liberó el ticket: </label><?php echo " ". $usuario_libero;?>
                                              </div>
                                          </div>
                                          <!-- <div class="row">
                                              <div class="col-md-12 text-center">
                                                  <label style="font-weight:bold;" class="text-center">Comentarios realizados: </label><?php echo " ". $comentarios_liberacion;?>
                                              </div>
                                          </div> -->
                                          <?php
                                      }
                                      ?>
                                  </div>
                              </div>
                                <div class="card-outline-success">
                                    <div class="card-header">
                                       <div class="row">
                                           <div class="col-md-10">
                                               <h4 class="m-b-0 text-white">Respuestas y mensajes</h4>
                                           </div>
                                           <?php
                                           if($id_estado_servicio != 8 && $id_estado_servicio != 6){
                                               ?>
                                               <div class="col-md-2">
                                                           <button type="button" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#modal_respuesta"><i class="fas fa-plus"></i> Respuesta</button>
                                                       </div>
                                               <?php
                                           }
                                           ?>
                                       </div>
                                    </div>
                                    <div class="card-body" id="cuerpo_respuestas">
                                        
                                    </div>
                                    <div class="card-footer" id="final_mensajes">
                                        
                                    </div>
                                </div>
                                <input type="hidden" name="na" id="ticket_activo" value="<?php echo $ticket;?>">
                               
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                   <div class="col-md-8">
                                       
                                   </div>
                                   <div class="col-md-2">
                                        <a href="#top" class="btn btn-primary btn-block">Ir arriba</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php
                include "../template/right-sidebar.php";
                ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <form id="form_respuesta" action="#" method="post" enctype="multipart/form-data">
            <div id="modal_respuesta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Agregar respuesta</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="respuesta" class="control-label">Mensaje: </label>
                                                        <textarea required name="respuesta" id="respuesta" cols="30" rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="">Evidencias: </label>
                                                        <input type="file" name="evidencias[]" id="evidencias" multiple>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <input type="checkbox" name="notificar_respuesta" value="1" class="filled-in" id="notificar_respuesta" checked >
                                                        <label for="notificar_respuesta">Notificar de respuesta por correo al remitente.</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
            <form id="form_responsable" action="asignar.php" method="post" enctype="multipart/form-data">
            <div id="modal_responsable" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Asignar responsable</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="respuesta" class="control-label">Responsable: </label>
                                                        <select name="id_usuario_responsable" id="id_usuario_responsable" class="form-control select2">
                                                            <?php
                                                            $trabajadores = $conexion->prepare("SELECT U.id_usuario,concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable 
                                                            FROM usuarios as U 
                                                            INNER JOIN personas as P ON U.id_persona = P.id_persona 
                                                            INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
                                                            WHERE U.activo = 1 AND P.activo = 1");
                                                            $trabajadores->execute();
                                                            while($row_t = $trabajadores->fetch(PDO::FETCH_NUM)){
                                                                echo "<option value=$row_t[0]>$row_t[1]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect">Asignar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
            <form id="form_prioridad" action="cambiar_prioridad.php" method="post" enctype="multipart/form-data">
            <div id="modal_prioridad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Cambiar prioridad</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="respuesta" class="control-label">Prioridad: </label>
                                                        <select name="prioridad" id="prioridad" class="form-control select2">
                                                            <option value="baja">Baja</option>
                                                            <option value="media">Media</option>
                                                            <option value="alta">Alta</option>
                                                            <option value="critica">Crítica</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ticket" value="<?php echo $ticket;?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                
            <form id="form_modal_generico" action="cambiado.php" method="post" enctype="multipart/form-data">
            <div id="modal_generico" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title" id="modal_title_generico">Cambiar prioridad</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body" id="cuerpo_modal_generico">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-success waves-effect">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                           
            <form id="frmModalCerrar" action="cerrar.php" method="post" enctype="multipart/form-data">
                <div id="modal_cerrar_ticket" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                </div>
                                </form>
            <form id="frmModalCambiarEstado" action="#" method="post">
                <div id="modal_cambiar_estado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                </div>
                                </form>                                

                                            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php
            include "../template/footer.php";
            ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?php
    include "../template/footer-js.php";
    ?>
    <script src="funciones.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //listar_respuestas
            show_respuestas('<?php echo $ticket;?>');
        });
    </script>
    <script type="text/javascript">
        $("#form_respuesta").submit(function(e){
            //creo el formData
            var frm_respuesta = new FormData(document.getElementById("form_respuesta"));
            $.ajax({
                url:"agregar_respuesta.php",
                type:"POST",
                xhr:function(){
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                data:frm_respuesta,
                cache:false,
                contentType:false,
                processData:false,
                dataType:"json",
                beforeSend:function(){
                    //acción mientras se envia el mensaje
                    $("#modal_respuesta").modal("hide");
                },
                success:function(respuesta){
                     $.toast({
                        heading: respuesta["titulo"],
                        text: respuesta["mensaje"],
                        position: 'top-right',
                        loaderBg:respuesta["color"],
                        icon: "info",
                        hideAfter: 3000, 
                        stack: 6
                    });
                    $("#modal_respuesta").modal("hide");
                    $("#respuesta").val("");
                    show_respuestas('<?php echo $ticket;?>');
                    var id_mensaje = respuesta["id"];
                    $("html,body").animate({scrollTop: $("#final_mensajes").offset().top}, 1000);
                },
                error:function(xhr,status){
                    alert("Error");
                }
            });
            e.preventDefault;
            return false;
        });
        function ver_evidencias(id_nota){
            //primero abro la ventana modal
            $.ajax({
                url:"ver_evidencias.php",
                type:"POST",
                dataType:"html",
                data:{'id_nota':id_nota},
                success:function(respuesta){
                    $("#cuerpo_evidencias").html(respuesta);
                    $("#modal_evidencias").modal("show");
                },
                error:function(status){
                    alert(status);
                }
            })            
        }
        $(".select2").select2({
        width: '100%'
        });
    </script>
    <script>
        <?php
        if(!isset($_GET["resultado"])){
            //no envie nada
        }
        else{
            $resultado = $_GET["resultado"];
            if($resultado == "exito_alta"){
                ?>
                    $.toast({
                        heading: "Exito!",
                        text: "El ticket ha sido creado correctamente!",
                        position: 'top-right',
                        loaderBg:"#1E8449",
                        icon: "info",
                        hideAfter: 3000, 
                        stack: 6
                    });
        <?php
            }
            else if($resultado == "exito_creacion"){
                //no se envio el correo
                ?>
                $.toast({
                        heading: "Exito!",
                        text: "El ticket ha sido creado correctamente, sin embargo no se ha podido enviar el correo electrónico.",
                        position: 'top-right',
                        loaderBg:"#DC8F08",
                        icon: "warning",
                        hideAfter: 6000, 
                        stack: 6
                    });
        <?php
            }
        }
        ?>
    </script>
    <div id="t"></div>
</body>
</html>