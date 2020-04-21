<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_GET["id"];
//busco los datos
$datos = $conexion->query("SELECT
id_solicitud,
folio_solicitud,
TSD.tipo_solicitud,
SD.id_tipo_solicitud,
SD.titulo_documento AS titulo,
CONCAT( P.nombre, ' ', P.ap_paterno, ' ', P.ap_materno ) AS autor,
SD.fecha_vigencia,
SD.comentarios,
SD.codigo,
TD.tipo_documento,
version,
ES.estado_solicitud AS estado,
ES.porcentaje_avance as porcentaje,
ES.color,
D.direccion,
DE.departamento,
PU.puesto,
CONCAT(P2.nombre,' ',P2.ap_paterno,' ',P2.ap_materno ) as responsable_direccion
FROM
solicitudes_documentos AS SD
LEFT JOIN tipo_solicitudes_documentos AS TSD ON SD.id_tipo_solicitud = TSD.id_tipo_solicitud
LEFT JOIN usuarios AS U ON SD.id_usuario_solicitante = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
INNER JOIN direcciones as D ON T.id_direccion = D.id_direccion
INNER JOIN puestos as PU ON T.id_puesto = PU.id_puesto
INNER JOIN departamentos as DE ON T.id_departamento = DE.id_departamento
INNER JOIN usuarios as U2 ON D.id_responsable = U2.id_usuario
INNER JOIN personas as P2 ON U2.id_persona = P2.id_persona
LEFT JOIN estado_solicitudes AS ES ON SD.estado_solicitud = ES.id_estado_solicitud
LEFT JOIN tipo_documentos AS TD ON SD.id_tipo_documento = TD.id_tipo_documento 
WHERE
id_solicitud = $id");
$row_datos = $datos->fetch(PDO::FETCH_ASSOC);
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
                    <div class="col-md-12">
                        <div class="card card-outline-success">
                            <div class="card-header">
                                <h3 class="m-b-0 text-white">Solicitud #<?php echo $row_datos["folio_solicitud"];?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><label for="tipo" class="control-label"><b><strong>Tipo de solicitud:
                                                    </strong></b> <?php echo $row_datos["tipo_solicitud"];?></label></p>
                                        <p><label for="tipo" class="control-label"><b><strong>Tipo de documento:
                                                    </strong></b> <?php echo $row_datos["tipo_documento"];?></label></p>
                                        <?php
                                        $id_tipo_solicitud = $row_datos["id_tipo_solicitud"];
                                        if($id_tipo_solicitud == 1){
                                            //es una alta
                                            ?>
                                        <p><label for="titulo" class="control-label"><b><strong>Título del documento:
                                                    </strong></b> <?php echo $row_datos["titulo"];?></label></p>
                                        <p><label for="titulo" class="control-label"><b><strong>Autor: </strong></b>
                                                <?php echo $row_datos["autor"];?></label></p>
                                        <p><label for="titulo" class="control-label"><b><strong>Código: </strong></b>
                                                <?php echo $row_datos["codigo"];?></label></p>
                                        <p><label for="titulo" class="control-label"><b><strong>Fecha de vigencia:
                                                    </strong></b> <?php echo $row_datos["fecha_vigencia"];?></label></p>
                                        <p><label for="titulo" class="control-label"><b><strong>Revisión: </strong></b>
                                                <?php echo $row_datos["version"];?></label></p>
                                        <?php
                                            //busco el documento
                                            $buscar = $conexion->query("SELECT file,name FROM documentos_solicitudes WHERE id_solicitud_documento = $id");
                                            $row_b = $buscar->fetch(PDO::FETCH_ASSOC);
                                            $file = $row_b["file"];
                                            $name = $row_b["name"];
                                            ?>
                                        <p><label for="" class="control-label"><strong><b>Documento: </b></strong>: <a
                                                    href="download_s.php?file=<?php echo $file;?>"><?php echo $name;?>.</a></label>
                                        </p>
                                        <?php
                                        }
                                        ?>
                                        <p><label for="titulo" class="control-label"><b><strong>Estado de solicitud:
                                                    </strong></b> <?php echo $row_datos["estado"];?></label></p>
                                    </div>
                                    <div class="col-md-6">
                                            <p><label for="direccion" class="control-label"><b><strong>Dirección: </strong></b><?php echo $row_datos["direccion"];?></label></p>
                                            <p><label for="direccion" class="control-label"><b><strong>Departamento: </strong></b><?php echo $row_datos["departamento"];?></label></p>
                                            <p><label for="direccion" class="control-label"><b><strong>Puesto: </strong></b><?php echo $row_datos["puesto"];?></label></p>
                                            <p><label for="direccion" class="control-label"><b><strong>Responsable de dirección: </strong></b><?php echo $row_datos["responsable_direccion"];?></label></p>
                                    </div>
                                </div>
                                <p class="text-center"><b><strong>Progreso</strong></b></p>
                                        <div class="progress">
                                            <div class="progress-bar <?php echo $row_datos["color"];?> progress-bar-striped active"
                                                role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                aria-valuemax="100"
                                                style="width:<?php echo $row_datos["porcentaje"];?>%;height:40px;">
                                                <span class="text-center"><b><strong><?php echo $row_datos["estado"];?>
                                                            (<?php echo $row_datos["porcentaje"];?>%)</strong></b></span>
                                            </div>
                                        </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-10">

                                    </div>
                                    <div class="col-md-2">
                                        <a href="control_documentos.php" class="btn btn-danger btn-block">Regresar</a>
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