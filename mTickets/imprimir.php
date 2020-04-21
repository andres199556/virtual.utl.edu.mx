<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../funciones/validar_permiso.php";
include "../funciones/strings.php";
if(!isset($_GET["ticket"])){
    header("Location:index.php");
}
else{
    $ticket = $_GET["ticket"];
    $id_respuesta = $_GET["respuesta"];
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
    MT.mensaje,
    MT.fecha,
    MT.hora,
    CONCAT(PM.nombre,' ',PM.ap_paterno,' ',PM.ap_materno) as usuario_respuesta,
    TM.correo
FROM
	servicios AS S /* inner join para el usuario */
INNER JOIN usuarios as U1 ON S.id_usuario_solicitante = U1.id_usuario
INNER JOIN personas as P1 ON U1.id_persona = P1.id_persona
/* inner join para el trabajador */
LEFT JOIN usuarios as U2 ON S.id_usuario_responsable = U2.id_usuario
LEFT JOIN personas as P2 ON U2.id_persona = P2.id_persona
LEFT JOIN tipo_servicios AS TS ON S.id_tipo_servicio = TS.id_tipo_servicio
INNER JOIN estado_tickets as ET ON S.id_estado_servicio = ET.id_estado_ticket
INNER JOIN mensajes_tickets as MT ON S.codigo_servicio = MT.ticket
INNER JOIN usuarios as UM ON MT.id_usuario = UM.id_usuario
INNER JOIN personas as PM ON UM.id_persona = PM.id_persona
INNER JOIN trabajadores as TM ON PM.id_persona = TM.id_persona
WHERE
	S.codigo_servicio = '$ticket' AND MT.id_mensaje = $id_respuesta");
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
            $ultima_fecha = new datetime("$row_servicio[15] $row_servicio[16]");
            $fecha_actual = new datetime(date("Y-m-d")." ".date("H:i:s"));
            $intervalo = $ultima_fecha->diff($fecha_actual);
            $ultima_respuesta = obtener_diferencia_fecha($intervalo);
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

<body class="card-no-border">
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
    
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="">
           <br><br>
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
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
                                      <h4 class="m-b-0 text-white">Información del ticket</h4>
                                  </div>
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
                                                
                                            case "baja":
                                                $prioridad = "<span class='text-success'><strong>Baja</strong></span>";
                                                break;
                                            case "media":
                                                $prioridad = "<span class='text-warning'><strong>Media</strong></span>";
                                                break;
                                            case "alta":
                                                $prioridad = "<span class='text-danger'><strong>Alta</strong></span>";
                                                break;
                                            case "critica":
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
                                  </div>
                              </div>
                                <div class="card-outline-success">
                                    <div class="card-header">
                                       <div class="row">
                                           <div class="col-md-10">
                                               <h4 class="m-b-0 text-white">Respuesta</h4>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="card-body">
                                       <div class="row">
                                           <div class="col-md-12">
                                               <label style="font-weight:bold;">Fecha y hora de la respuesta:  </label><?php echo " ".$row_servicio[15]." - ".$row_servicio[16]." (hace ".$ultima_respuesta.")";?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="col-md-12">
                                               <label style="font-weight:bold;">Usuario: </label><?php echo " ".$row_servicio[17];?>
                                           </div>
                                       </div>
                                       <div class="row">
                                           <div class="col-md-12">
                                               <label style="font-weight:bold;">Correo: </label><?php echo " ".$row_servicio[18];?>
                                           </div>
                                       </div>
                                        <div class="row">
                                           <div class="col-md-12">
                                               <label style="font-weight:bold;">Respuesta: </label>
                                           </div>
                                       </div>
                                        <p><?php echo $row_servicio[14];?></p>
                                    </div>
                                    <div class="card-footer" id="final_mensajes">
                                        
                                    </div>
                                </div>
                               
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            window.print();
        });
    </script>
</body>
</html>