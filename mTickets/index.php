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
                <div class="row">
                    <div class="col-12">
                      
                       <div class="row">
                           <div class="col-md-12">
                               <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">Listado de tickets</h4>
                                <?php
                                if($permiso_acceso == 1){
                                    $buscar_totales = $conexion->query("SELECT
                                    COUNT(S.id_servicio) AS total,
                                    (
                                        SELECT
                                            count(id_servicio)
                                        FROM
                                            servicios
                                        WHERE
                                            id_estado_servicio = 8
                                    ) AS liberados,
                                    (
                                        SELECT
                                            count(id_servicio)
                                        FROM
                                            servicios
                                        WHERE
                                            id_estado_servicio = 5
                                    ) AS respondidos,
                                    (
                                        SELECT
                                            count(id_servicio)
                                        FROM
                                            servicios
                                        WHERE
                                            id_estado_servicio = 1
                                    ) AS sin_asignar,
                                    (
                                        SELECT
                                            count(id_servicio)
                                        FROM
                                            servicios
                                        WHERE
                                            id_estado_servicio = 2
                                    ) AS asignados
                                FROM
                                    servicios AS S");
                                    $fila = $buscar_totales->fetch(PDO::FETCH_ASSOC);
                                    $totales = $fila["total"];
                                    $liberados = $fila["liberados"];
                                    $respondidos = $fila["respondidos"];
                                    $sin_asignar = $fila["sin_asignar"];
                                    $asignados = $fila["asignados"];
                                    ?>
                                    <div class="row m-t-40">
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-inverse card-info">
                                            <div class="box bg-inverse text-center">
                                                <h1 class="font-light text-white"><?php echo $totales;?></h1>
                                                <h6 class="text-white">Tickets en total</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-info card-inverse">
                                            <div class="box text-center">
                                                <h1 class="font-light text-white"><?php echo $respondidos;?></h1>
                                                <h6 class="text-white">Respondidos</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-inverse card-success">
                                            <div class="box text-center">
                                                <h1 class="font-light text-white"><?php echo $liberados;?></h1>
                                                <h6 class="text-white">Liberados</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-danger">
                                            <div class="box text-center">
                                                <h1 class="font-light text-white"><?php echo $sin_asignar;?></h1>
                                                <h6 class="text-white">Sin atender</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-primary">
                                            <div class="box text-center">
                                                <h1 class="font-light text-white"><?php echo $asignados;?></h1>
                                                <h6 class="text-white">Asignados</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                </div>
                                    <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-condensed table-bordered color-table info-table" id="tabla_registros">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Ticket</th>
                                                        <th class="text-center">Ultima actualización</th>
                                                        <?php
                                                        if($permiso_acceso == 1){
                                                            //si muestro el solicitante
                                                            ?>
                                                            <th class="text-center">Solicitante</th>
                                                            <?php
                                                        }
                                                        else{
                                                            
                                                        }
                                                        ?>
                                                        
                                                        <th class="text-center">Servicio</th>
                                                        <th class="text-center">Prioridad</th>
                                                        <th class="text-center">Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpo_tabla">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                        <div class="col-md-1">
                                        <div class="pull-right">
                                            <a href="alta.php" class="btn btn-success">Agregar ticket</a>
                                        </div>
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
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php
                include "../template/right-sidebar.php";
                ?>
                <div id="modal_fechas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Configuración de fechas</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <form action="">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="" class="control-label">Fecha de alta servicio:</label>
                                                        <input type="text" name="fecha_apertura" id="fecha_apertura" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="" class="control-label">Hora de alta servicio:</label>
                                                        <input type="text" name="hora_apertura" id="hora_apertura" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary waves-effect">Actualizar fechas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                <div id="modal_configuracion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Configuración del servicio</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <form action="">
                                            <div class="modal-body">
                                               <h3 class="text-center">Actualización de estado</h3>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="" class="control-label">Cambiar estado del servicio:</label>
                                                        <select name="estado_servicio" id="" class="form-control">
                                                            <option value="">Cancelar servicio</option>
                                                            <option value="">Mover a compras</option>
                                                            <option value="">Liberar servicio</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <h3 class="text-center">Actualización de fechas</h3>
                                                <div class="row">
                                                    <div class="col-md-3 form-group">
                                                        <label for="" class="control-label">Fecha de servicio:</label>
                                                        <input type="text" name="fecha_servicio" id="" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="" class="control-label">Hora de servicio:</label>
                                                        <input type="text" name="hora_servicio" id="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="#" id="frmLiberar" method="post" enctype="multipart/form-data">
                                <div id="modal_liberar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                               <h4 class="modal-title">Liberar servicio</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                
                                            </div>
                                            <div class="modal-body">
                                               <input type="hidden" name="id_servicio" id="id_servicio_liberar">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label for="acciones" class="control-label">Acciones realizadas:</label>
                                                        <textarea name="acciones_realizadas" required id="acciones" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="" class="control-label">Fecha de cierre:</label>
                                                        <input type="text" required name="fecha_cierre" id="fecha_cierre" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="" class="control-label">Hora de cierre:</label>
                                                        <input type="time" required name="hora_cierre" id="hora_cierre" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <input type="checkbox" name="fecha_servidor" value="1" class="filled-in" id="cambiar_fechas" onclick="habilitar_fechas(this);">
                                                        <label for="cambiar_fechas">La fecha y la hora se toman al momento de guardar.</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <input type="checkbox" id="bitacora" value="1" class="filled-in" checked="" name="bitacora" onclick="habilitar_check();">
                                                        <label for="bitacora">Subir la información de este servicio en la bitácora del departamento.</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <input type="checkbox" id="bitacora_publica" value="1" class="filled-in" checked="" name="bitacora_publica">
                                                        <label for="bitacora_publica">El registro de la bitácora es público.</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label for="" class="control-label">Subir evidencias:</label>
                                                        <input type="file" name="evidencias[]" multiple id="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-success">Liberar servicio</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
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
    <script type="text/javascript" src="funciones.js"></script>
    <script type="text/javascript">
        listar_registros();
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        $('#fecha_cierre').datepicker({
             autoclose: true,
             todayHighlight: true,
             format: 'yyyy-mm-dd'
        });
        $("#fecha_cierre").datepicker().datepicker("setDate", new Date());
        Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes();
}
        var fecha_actual = new Date();
        var todo = fecha_actual.timeNow();
        $("#hora_cierre").val(todo);
        function habilitar_fechas(campo){
            var estado = $(campo).prop("checked");
            if(estado == true){
                //se desabilitan
                $("#fecha_cierre").prop("disabled",true);
                $("#hora_cierre").prop("disabled",true);
                $("#hora_cierre").prop("required",false);
                $("#fecha_cierre").prop("required",false);
            }
            else{
                $("#fecha_cierre").prop("disabled",false);
                $("#hora_cierre").prop("disabled",false);
                $("#hora_cierre").prop("required",true);
                $("#fecha_cierre").prop("required",true);
            }
        }
        $("#frmLiberar").submit(function(e){
            var frmData = new FormData(document.getElementById("frmLiberar"));
            $.ajax({
                url:"liberar.php",
                type:"POST",
                xhr:function(){
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                data:frmData,
                cache:false,
                contentType:false,
                processData:false,
                dataType:"json",
                success:function(respuesta){
                    alert(respuesta["mensaje"]);
                    $("#modal_liberar").modal("hide");
                },
                error:function(xhr,status){
                    alert("Error");
                }
            });
            e.preventDefault;
            return false;
        });
        function habilitar_check(){
            var estado = $("#bitacora").prop("checked");
            if(estado == true){
                $("#bitacora_publica").prop("disabled",false);
            }
            else{
                $("#bitacora_publica").prop("disabled",true);
            }
        }
        habilitar_check();
        function fechas(id_servicio){
            $("#modal_fechas").modal("show");
        }
        <?php
        if(isset($_GET["resultado"])){
            $resultado = $_GET["resultado"];
            if($resultado == "exito_liberar"){
                ?>
        $.toast({
                        heading: "Exito!",
                        text: "El ticket se ha liberado correctamente!.",
                        position: 'top-right',
                        icon: "success",
                        hideAfter: 4500, 
                        stack: 6
                    });
        <?php
            }
        }
        ?>
    </script>
</body>
</html>