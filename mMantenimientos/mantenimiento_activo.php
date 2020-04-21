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
                                <div class="card-header">
                                <span class="card-title" id="1">Historial de mantenimientos por activo</span>
                                
                                
                                </div>
                                    <div class="card-body">
                                        <form action="" class="form-horizontal">
                                            <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                    <label for="no_activo" class="control-label col-md-3">N° de activo: </label>
                                                    <input type="text" name="no_activo" id="no_activo" class="form-control col-md-5" autofocus>
                                                    <button type="button" onclick="buscar_activo();" style="margin-left:5px;" class="btn btn-success col-md-3" type="button"><i class="fa fa-search"></i> Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                                        <div class="div-datos">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="frecuencia" class="control-label">Frecuencia del mantenimiento: </label>
                                                <input type="text" name="" readonly id="frecuencia" style="font-weight:bold;" class="form-control text-success">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="ultimo" class="control-label">Ultimo mantenimiento: </label>
                                                <input type="text" name="ultimo" style="font-weight:bold;" readonly id="ultimo" class="form-control text-primary">
                                            </div>
                                            <div class="col-md-4 form-grup">
                                                <label for="siguiente" class="control-label">Siguiente mantenimiento: </label>
                                                <input type="text" name="" style="font-weight:bold;" readonly id="siguiente" class="form-control text-primary">
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Marca: </label>
                                                    <input type="text" name="" readonly id="marca" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Modelo: </label>
                                                    <input type="text" name="" readonly id="modelo" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">N° serie: </label>
                                                    <input type="text" name="" readonly id="no_serie" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Memoria RAM: </label>
                                                    <input type="text" name="" readonly id="ram" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Disco duro: </label>
                                                    <input type="text" name="" readonly id="disco_duro" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Sistema operativo: </label>
                                                    <input type="text" name="" readonly id="so" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Dirección IP: </label>
                                                    <input type="text" name="" readonly id="ip" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Dirección MAC: </label>
                                                    <input type="text" name="" readonly id="mac" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Comentarios: </label>
                                                    <textarea name="" readonly id="comentarios" cols="30" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Dirección: </label>
                                                    <input type="text" name="" readonly id="direccion" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Departamento: </label>
                                                    <input type="text" name="" readonly id="departamento" class="form-control">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="marca" class="control-label">Dueño del equipo: </label>
                                                    <input type="text" name="" readonly id="responsable" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-m">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-hover table-bordered table-striped color-table success-table">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">#</th>
                                                                <th class="text-center">Código de mantenimiento</th>
                                                                <th class="text-center">Descripción</th>
                                                                <th class="text-center">Título</th>
                                                                <th class="text-center">Fecha de inicio</th>
                                                                <th class="text-center">Fecha de cierre</th>
                                                                <th class="text-center">Responsable</th>
                                                                <th class="text-center">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="tbody-mantenimientos">
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-10">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
                                            </div>
                                        </div>
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
    $("[data-toggle=tooltip]").tooltip();
    function buscar_activo(){
        var activo = $("#no_activo").val();
        
        $.ajax({
            url:"buscar_activo.php",
            type:"POST",
            dataType:"json",
            data:{'activo':activo}
        }).done(function(success){
            
            console.log(success);
            var marca = success["datos"]["nombre_marca"];
            $("#marca").val(marca);
            $("#modelo").val(success["datos"]["modelo"]);
            $("#no_serie").val(success["datos"]["no_serie"]);
            $("#ram").val(success["datos"]["memoria_ram"]+"GB");
            $("#disco_duro").val(success["datos"]["disco_duro"]+"GB");
            $("#so").val(success["datos"]["sistema_operativo"]);
            $("#ip").val(success["datos"]["direccion_ip"]);
            $("#mac").val(success["datos"]["direccion_mac"]);
            $("#comentarios").val(success["datos"]["comentarios"]);
            $("#direccion").val(success["datos"]["direccion"]);
            $("#departamento").val(success["datos"]["departamento"]);
            $("#responsable").val(success["datos"]["responsable"]);
            $("#frecuencia").val(success["datos"]["tipo_frecuencia"]);
            $("#ultimo").val(success["datos"]["ultimo_mantenimiento"]);
            $("#siguiente").val(success["datos"]["fecha_siguiente"]);
            var cantidad = success["datos"]["cantidad_mantenimientos"];
            $(".tbody-mantenimientos").html("");
            for(var i = 0;i<cantidad;i++){
                var titulo = success["datos"]["mantenimientos_rows"][i]["titulo_plan"];
                var responsable = success["datos"]["mantenimientos_rows"][i]["responsable"];
                var codigo = success["datos"]["mantenimientos_rows"][i]["codigo_mantenimiento"];
                var descripcion = success["datos"]["mantenimientos_rows"][i]["descripcion"];
                var fecha_inicio = success["datos"]["mantenimientos_rows"][i]["fecha_inicio_mantenimiento"];
                var fecha_cierre = success["datos"]["mantenimientos_rows"][i]["fecha_cierre_mantenimiento"];
                $(".tbody-mantenimientos").append('<tr>'+
                                                            '<td class="text-center">'+(i+1)+'</td>'+
                                                            '<td class="text-center">'+codigo+'</td>'+
                                                            '<td class="text-center">'+descripcion+'</td>'+
                                                            '<td class="text-center">'+titulo+'</td>'+
                                                            '<td class="text-center">'+fecha_inicio+'</td>'+
                                                            '<td class="text-center">'+fecha_cierre+'</td>'+
                                                            '<td class="text-center">'+responsable+'</td>'+
                                                            '<td class="text-center"></td>'+
                                                            '</tr>');
            }
        }).fail(function(error){

        });
    }
    </script>
</body>

</html>