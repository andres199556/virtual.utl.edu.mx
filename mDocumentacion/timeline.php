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
    .pull-right{
        float:right;
    }
    .timeline {
        position: relative;
        margin: 0 0 30px 0;
        padding: 0;
        list-style: none
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 4px;
        background: #ddd;
        left: 31px;
        margin: 0;
        border-radius: 2px
    }

    .timeline>li {
        position: relative;
        margin-right: 10px;
        margin-bottom: 15px
    }

    .timeline>li:before,
    .timeline>li:after {
        content: " ";
        display: table
    }

    .timeline>li:after {
        clear: both
    }

    .timeline>li>.timeline-item {
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        margin-top: 0;
        background: #fff;
        color: #444;
        margin-left: 60px;
        margin-right: 15px;
        padding: 0;
        position: relative
    }

    .timeline>li>.timeline-item>.time {
        color: #999;
        float: right;
        padding: 10px;
        font-size: 12px
    }

    .timeline>li>.timeline-item>.timeline-header {
        margin: 0;
        color: #555;
        border-bottom: 1px solid #f4f4f4;
        padding: 10px;
        font-size: 16px;
        line-height: 1.1
    }

    .timeline>li>.timeline-item>.timeline-header>a {
        font-weight: 600
    }

    .timeline>li>.timeline-item>.timeline-body,
    .timeline>li>.timeline-item>.timeline-footer {
        padding: 10px;
        font-size:13px;
    }

    .timeline>li>.fa,
    .timeline>li>.glyphicon,
    .timeline>li>.ion {
        width: 30px;
        height: 30px;
        font-size: 15px;
        line-height: 30px;
        position: absolute;
        color: #666;
        background: #d2d6de;
        border-radius: 50%;
        text-align: center;
        left: 18px;
        top: 0
    }

    .timeline>.time-label>span {
        font-weight: 600;
        padding: 5px;
        display: inline-block;
        background-color: #fff;
        border-radius: 4px
    }

    .timeline-inverse>li>.timeline-item {
        background: #f0f0f0;
        border: 1px solid #ddd;
        -webkit-box-shadow: none;
        box-shadow: none
    }

    .timeline-inverse>li>.timeline-item>.timeline-header {
        border-bottom-color: #ddd
    }

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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">

                            </div>
                            <div class="card-body">
                            <ul class="timeline">
                        <!-- timeline time label -->

                        <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <li class="time-label ">
                            <span class="label-success">
                                Miércoles 05 de Febrero de 2020 </span>
                        </li>
                        <li>
                            <i class="fa fa-check bg-orange"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Evaluación # 1 de informe final, con una calificación total de 96 - Finalizada ,al
                                    alumno Alejandro Alvarez Alvarez <p class="pull-right badge bg-orange"
                                        id="lblFecha1" style="float:right;">12:44 pm</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-user-circle bg-navy"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Evaluación # 1 del asesor académico de proyecto, con un promedio de 98 ,al alumno
                                    Ernesto Alejandro Mejorado Herrera <p class="pull-right badge bg-navy"
                                        id="lblFecha1" style="float:right;">12:33 pm</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-user-circle bg-navy"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Evaluación # 1 del asesor académico de proyecto, con un promedio de 98 ,al alumno
                                    Alejandro Alvarez Alvarez <p class="pull-right badge bg-navy" id="lblFecha1">12:33
                                        pm</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-check bg-orange"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Evaluación # 1 de informe final, con una calificación total de 86 - Finalizada ,al
                                    alumno Ernesto Alejandro Mejorado Herrera <p class="pull-right badge bg-orange"
                                        id="lblFecha1">11:58 am</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-eye bg-olive-active"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Ha otorgado el visto bueno del objetivo general del proyecto <p
                                        class="pull-right badge bg-olive-active" id="lblFecha1">11:38 am</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-eye bg-olive-active"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Ha otorgado el visto bueno del objetivo general del proyecto <p
                                        class="pull-right badge bg-olive-active" id="lblFecha1">11:38 am</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-unlock bg-green"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Asesor de proyecto - Permiso otorgado para modificar los datos del proyecto al
                                    alumno , Alejandro Alvarez Alvarez <p class="pull-right badge bg-green"
                                        id="lblFecha1">11:23 am</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-unlock bg-green"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Asesor de proyecto - Permiso otorgado para modificar los datos del proyecto al
                                    alumno , Alejandro Alvarez Alvarez <p class="pull-right badge bg-green"
                                        id="lblFecha1">11:15 am</p>
                                </div>
                            </div>
                        </li>
                        <li class="time-label">
                            <span class="bg-green">
                                Jueves 30 de Enero de 2020 </span>
                        </li>
                        <li>
                            <i class="fa fa-eye bg-aqua-active"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Ha otorgado el visto bueno al proyecto Desarrollar un Sistema para Automatizar los
                                    Procesos Actuales y Mejorar la Toma de Deciciones en las Areas de Control de
                                    Productividad <p class="pull-right label label-success" id="lblFecha1">12:22 pm</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-eye bg-aqua-active"></i>
                            <div class="timeline-item">
                                <div class="timeline-body">
                                    Ha otorgado el visto bueno al proyecto Desarrollar un Sistema para Automatizar los
                                    Procesos Actuales y Mejorar la Toma de Decisiones en las Áreas de Control de
                                    Producción <p class="pull-right badge bg-aqua-active" id="lblFecha1">12:21 pm</p>
                                </div>
                            </div>
                        </li>
                        <!-- END timeline item -->
                        <li class="time-label">
                            <span class="bg-green">
                                Enero-Abril 2020 </span>
                        </li>
                    </ul>
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
    <!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->

    <script src="funciones.js"></script>


    <script type="text/javascript">
    var div_buscar = false;
    permiso = < ? php echo $permiso_acceso; ? > ;
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno"); <
    ? php
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
            ? php
    } ?
    >
    function buscar() {
        $("#lstBuscar").addClass("active");
        $(".col-buscar").removeClass("hide");
        $(".col-normal").addClass("hide");
        $("#criterio").focus();
    }
    $("#frmBuscar").submit(function(e) {
        $("#btnBuscarFiltro").prop("disabled", true);
        $("#btnBuscarFiltro").removeClass("btn-success");
        $("#btnBuscarFiltro").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        $.ajax({
            url: "buscar_filtro.php",
            type: "POST",
            dataType: "html",
            data: $(this).serialize()
        }).done(function(success) {
            if (div_buscar == false) {
                $('.th-codigo').before(
                    '<th class="text-center">Dirección</th><th class="text-center">Departamento</th><th class="text-center">Tipo de documento</th><th class="text-center">Coincidencia</th>'
                    );
            } else {

            }
            div_buscar = true;
            if ($.fn.dataTable.isDataTable('.tabla_documentos')) {
                $('.tabla_documentos').DataTable().destroy();
                $('.tabla_documentos').DataTable().clear().destroy();
                //crear_tabla();
                $("#registros").html(success);
                var table = $('.tabla_documentos').DataTable({
                    "language": {
                        "url": "../assets/plugins/datatables/media/js/Spanish.json"
                    }
                });
                $(".tabla_documentos").removeClass("dataTable");
                $(table.table().header()).addClass('th-header');
            } else {
                $("#registros").html(success);
                var table = $('.tabla_documentos').DataTable({
                    "language": {
                        "url": "../assets/plugins/datatables/media/js/Spanish.json"
                    }
                });
                $(".tabla_documentos").removeClass("dataTable");
                $(table.table().header()).addClass('th-header');
            }
            $("#btnBuscarFiltro").prop("disabled", false);
            $("#btnBuscarFiltro").addClass("btn-success");
            $("#btnBuscarFiltro").html("<i class='fa fa-search'></i> Buscar");
        });
        e.preventDefault();
        return false;
    });
    </script>

</body>

</html>