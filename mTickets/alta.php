<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
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
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $modulo_actual;?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><?php echo $categoria_actual;?></a></li>
                            <li class="breadcrumb-item active"><?php echo $modulo_actual;?></li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <form action="guardar.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Generar ticket</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        if($permiso_acceso == 1){
                                            ?>
                                        <div class="col-md-4 form-group">
                                            <label for="">Usuario que solicita el servicio: </label>
                                            <select name="id_usuario_solicitante" required id="id_usuario_solicitante"
                                                class="form-control">
                                                <?php
                                                //enlisto todos los trabajadores
                                                $trabajadores = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
                                                FROM trabajadores as T
                                                INNER JOIN personas as P ON T.id_persona = P.id_persona
                                                INNER JOIN usuarios as U ON P.id_persona = U.id_persona
                                                WHERE U.activo = 1 AND T.activo = 1");
                                                while($row = $trabajadores->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row[0]>$row[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="col-md-4 form-group">
                                            <label for="id_tipo_servicio" class="control-label">Tipo de servicio:
                                            </label>
                                            <select name="id_tipo_servicio" id="id_tipo_servicio" required
                                                class="form-control" onchange="cambiar_titulo(this);">
                                                <?php
                                                $tipo_servicios = $conexion->query("SELECT id_tipo_servicio,tipo_servicio
                                                FROM tipo_servicios
                                                WHERE activo = 1");
                                                $tipo_servicios->execute();
                                                while($row = $tipo_servicios->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row[0]>$row[1]</option>";
                                                }
                                                $tipo_servicios->closeCursor();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="titulo" class="control-label">Asunto: </label>
                                            <input type="text" name="titulo" id="titulo" autofocus required
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="descripcion" class="control-label">Mensaje:</label>
                                            <textarea name="descripcion" id="descripcion" cols="15" rows="5"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="prioridad">Proridad:</label>
                                            <select name="prioridad" id="prioridad" class="form-control">
                                                <option value="baja">Baja</option>
                                                <option value="Media">Media</option>
                                                <option value="Alta">Alta</option>
                                                <option value="Critica">Crítica</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="evidencias" class="control-label">Adjuntar archivos:</label>
                                            <input type="file" name="evidencias[]" multiple id="evidencias">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" name="enviar_correo" value="1" class="filled-in"
                                                id="cambiar_fechas">
                                            <label for="cambiar_fechas">Recibir notificación por correo de la creación
                                                del ticket.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" name="mostrar_ticket" value="1" class="filled-in"
                                                id="mostrar_ticket">
                                            <label for="mostrar_ticket">Mostrar el ticket despues de crear.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-8">

                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-danger btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-info btn-block">Enviar ticket</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    <script type="text/javascript">
    <?php
    if ($permiso_acceso == 2) {
        //el usuario es el responsable
        ?>
        $("#id_usuario_solicitante").val( < ? php echo $id_usuario_logueado; ? > );
        $("#id_usuario_solicitante").prop("disabled", true); 
        <?php
    }
    ?>
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    // For the time now
    Date.prototype.timeNow = function() {
        return ((this.getHours() < 10) ? "0" : "") + this.getHours() + ":" + ((this.getMinutes() < 10) ? "0" : "") +
            this.getMinutes() + ":" + ((this.getSeconds() < 10) ? "0" : "") + this.getSeconds();
    }
    var fecha_actual = new Date();
    var todo = fecha_actual.timeNow();
    $("#horas").val(todo);

    function cambiar_titulo(combo) {
        //var otro = $(combo).find("option").prop("selected");
        //alert($(otro).html());

    }
    $('#fechas').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });
    $("#fechas").datepicker().datepicker("setDate", new Date());
    $('#horas').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $("select").select2({
        width:"100%"
    });
    </script>
</body>

</html>