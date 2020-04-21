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
                            <li class="breadcrumb-item active"><i class="<?php echo $icono_modulo;?>"></i>
                                <?php echo $modulo_actual;?></li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row m-t-40">
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-inverse card-info">
                                            <div class="box bg-inverse text-center">
                                                <h1 class="font-light text-white"><span class="equipos-totales"></span></h1>
                                                <h6 class="text-white">Equipos en total</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card  card-success">
                                            <div class="box text-center">
                                            <h1 class="font-light text-white"><i class="fa fa-desktop"></i> <span class="encendidos"></span></h1>
                                                <h6 class="text-white">Encendidos</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-2 col-xlg-2">
                                        <div class="card card-inverse card-danger">
                                            <div class="box text-center">
                                                <h1 class="font-light text-white"><i class="fa fa-desktop"></i> <span class="apagados"></span></h1>
                                                <h6 class="text-white">Apagados</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column -->
                                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header">
                        Listado de monitoreos
                        <div class="card-actions">
                        <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-settings"></i> Acciones
                                    </button>
                                    <div class="dropdown-menu flipInX" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="javascript:actualizar_estados();"><i class="fa fa-sync text-success"></i> Actualizar estados</a>
                                        <a class="dropdown-item" href="sitios.php"><i class="fa fa-globe text-danger"></i> Controles de acceso</a>
                                    </div>
                                </div>
                        </div>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-striped table-condensed table-bordered color-table info-table"
                                                id="tabla_registros">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">N° de activo</th>
                                                        <th class="text-center">Equipo</th>
                                                        <th class="text-center">Dirección MAC</th>
                                                        <th class="text-center">Dirección IP</th>
                                                        <th class="text-center">Ubicación</th>
                                                        <th class="text-center">Descripción</th>
                                                        <th class="text-center">Estado</th>
                                                        <th class="text-center">Estado del equipo</th>
                                                        <th class="text-center">Accesos</th>
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
                                            <a href="alta.php" class="btn btn-success">Monitorear un nuevo equipo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

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
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(document).ready(function(){
        listar_registros();
    });
/* 
    function wake(numero) {
        $.ajax({
            url: "wake.php",
            type: "POST",
            dataType: "html",
            data: {
                'no': numero
            },
            beforeSend: function(antes) {
                $(".texto-estado-" + numero).removeClass("label-success");
                $(".icon-" + numero).removeClass("text-success");
                $(".icon-" + numero).addClass("text-default");
                $(".texto-estado-" + numero).addClass("label-default");
                $(".texto-estado-" + numero).html("<i class='fa fa-spinner fa-spin'></i> Encendiendo");
            }
        }).done(function(success) {
            alert(success);
        }).fail(function(error) {
            alert("Error");
        });
    } */
    </script>
</body>

</html>