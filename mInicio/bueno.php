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
    <style>
    .btn-toggle {
        color: #fff;
        font-weight: bold;
        font-size: 20px;
    }

    .span-right {
        position: absolute;
        top: 54%;
        right: 15px;
        margin-top: -7px;
    }

    .span-soporte {
        position: absolute;
        top: 61%;
        right: 15px;
        margin-top: -7px;
    }

    .span-puesto {
        position: absolute;
        top: 67%;
        right: 15px;
        margin-top: -7px;
    }
    </style>
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/fontawesome.css">
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/all.css">
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a>
                            </li>
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
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="mb-0 text-white">Mis cursos</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <div class="card">
                                            <img class="rounded-top" src="../assets/images/background/weatherbg.jpg"
                                                alt="Card image cap">
                                            <div class="card-img-overlay" style="height:110px;">
                                                <div class="d-flex align-items-center">
                                                    <h3 class="card-title text-white mb-0 d-inline-block">Interconexión
                                                        de Redes</h3>
                                                    <div class="ml-auto">
                                                        <!-- <small class="card-text text-white font-weight-light">Sunday 15
                                                            march</small> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body weather-small">
                                                <div class="row">
                                                    <div class="col-8 border-right align-self-center">
                                                        <div class="d-flex">
                                                            <div class="display-6 text-info"><i
                                                                    class="fa fa-laptop"></i></div>
                                                            <div class="ml-3">
                                                                <h5 class="font-weight-light text-info mb-0">
                                                                    TIDSM03-AM
                                                                </h5>
                                                                <small>Prof: Ing. Aarón Andrés Rizo Barrera.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <h1 class="font-weight-light mb-0">25</h1>
                                                        <small>Alumnos</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button title="Notificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-bell text-warning"></i>
                                                            </a><sup><b><strong>1</strong></b></sup></button>
                                                            <button title="Información de la clase" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-info"></i>
                                                            </a></button>
                                                            <button title="Calificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-graduation-cap text-danger"></i>
                                                            </a></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="card">
                                            <img class="rounded-top" src="../assets/images/background/weatherbg.jpg"
                                                alt="Card image cap">
                                            <div class="card-img-overlay" style="height:110px;">
                                                <div class="d-flex align-items-center">
                                                    <h3 class="card-title text-white mb-0 d-inline-block">Interconexión
                                                        de Redes</h3>
                                                    <div class="ml-auto">
                                                        <!-- <small class="card-text text-white font-weight-light">Sunday 15
                                                            march</small> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body weather-small">
                                                <div class="row">
                                                    <div class="col-8 border-right align-self-center">
                                                        <div class="d-flex">
                                                            <div class="display-6 text-info"><i
                                                                    class="fa fa-laptop"></i></div>
                                                            <div class="ml-3">
                                                                <h5 class="font-weight-light text-info mb-0">
                                                                    TIDSM03-AM
                                                                </h5>
                                                                <small>Prof: Ing. Aarón Andrés Rizo Barrera.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <h1 class="font-weight-light mb-0">25</h1>
                                                        <small>Alumnos</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button title="Notificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-bell text-warning"></i>
                                                            </a><sup><b><strong>1</strong></b></sup></button>
                                                            <button title="Información de la clase" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-info"></i>
                                                            </a></button>
                                                            <button title="Calificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-graduation-cap text-danger"></i>
                                                            </a></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="card">
                                            <img class="rounded-top" src="../assets/images/background/weatherbg.jpg"
                                                alt="Card image cap">
                                            <div class="card-img-overlay" style="height:110px;">
                                                <div class="d-flex align-items-center">
                                                    <h3 class="card-title text-white mb-0 d-inline-block">Interconexión
                                                        de Redes</h3>
                                                    <div class="ml-auto">
                                                        <!-- <small class="card-text text-white font-weight-light">Sunday 15
                                                            march</small> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body weather-small">
                                                <div class="row">
                                                    <div class="col-8 border-right align-self-center">
                                                        <div class="d-flex">
                                                            <div class="display-6 text-info"><i
                                                                    class="fa fa-laptop"></i></div>
                                                            <div class="ml-3">
                                                                <h5 class="font-weight-light text-info mb-0">
                                                                    TIDSM03-AM
                                                                </h5>
                                                                <small>Prof: Ing. Aarón Andrés Rizo Barrera.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <h1 class="font-weight-light mb-0">25</h1>
                                                        <small>Alumnos</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button title="Notificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-bell text-warning"></i>
                                                            </a><sup><b><strong>1</strong></b></sup></button>
                                                            <button title="Información de la clase" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-info"></i>
                                                            </a></button>
                                                            <button title="Calificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-graduation-cap text-danger"></i>
                                                            </a></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="card">
                                            <img class="rounded-top" src="../assets/images/background/weatherbg.jpg"
                                                alt="Card image cap">
                                            <div class="card-img-overlay" style="height:110px;">
                                                <div class="d-flex align-items-center">
                                                    <h3 class="card-title text-white mb-0 d-inline-block">Interconexión
                                                        de Redes</h3>
                                                    <div class="ml-auto">
                                                        <!-- <small class="card-text text-white font-weight-light">Sunday 15
                                                            march</small> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body weather-small">
                                                <div class="row">
                                                    <div class="col-8 border-right align-self-center">
                                                        <div class="d-flex">
                                                            <div class="display-6 text-info"><i
                                                                    class="fa fa-laptop"></i></div>
                                                            <div class="ml-3">
                                                                <h5 class="font-weight-light text-info mb-0">
                                                                    TIDSM03-AM
                                                                </h5>
                                                                <small>Prof: Ing. Aarón Andrés Rizo Barrera.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-center">
                                                        <h1 class="font-weight-light mb-0">25</h1>
                                                        <small>Alumnos</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-right">
                                                        <button title="Notificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-bell text-warning"></i>
                                                            </a><sup><b><strong>1</strong></b></sup></button>
                                                            <button title="Información de la clase" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-info"></i>
                                                            </a></button>
                                                            <button title="Calificaciones" data-toggle="tooltip"
                                                            class="btn"><a href=""><i
                                                                    class="fa fa-graduation-cap text-danger"></i>
                                                            </a></button>
                                                    </div>
                                                </div>
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
    <script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
    <script src="../js/socket.js"></script>
    <script>
    modulo_actual = "<?php echo $menu;?>";
    global_date = '<?php echo date("Y-m-d H:i:s");?>';
    conect_socket('<?php print session_id();?>', < ? php echo $_SESSION["id_usuario"]; ? > , 'reload', 'web');
    </script>

    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno"); <
    ?
    php
    $resultado = $_GET["resultado"];
    if ($resultado == "exito_actualizacion") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'Tu información se ha guardado correctamente.!',
                timer: 3000
            }) <
            ?
            php
    } ?
    >
    </script>

</body>

</html>