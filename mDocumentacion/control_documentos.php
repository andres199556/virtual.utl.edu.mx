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
        .btn-toggle{
            color:#fff;
            font-weight:bold;
            font-size:20px;
        }
        .span-right{
            position: absolute;
            top: 54%;
            right: 15px;
            margin-top: -7px;
        }
        .span-soporte{
            position: absolute;
            top: 61%;
            right: 15px;
            margin-top: -7px;
        }
        .span-puesto{
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a></li>
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
                                <h3 class="m-b-0 text-white">Control de documentos - Solicitudes</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-bordered color-table info-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">folio</th>
                                                        <th class="text-center">Tipo de solicitud</th>
                                                        <th class="text-center">Tipo de documento</th>
                                                        <th class="text-center">Fecha de generación de solicitud</th>
                                                        <th class="text-center">Usuario que solicitó</th>
                                                        <th class="text-center">Estado de la solicitud</th>
                                                        <th class="text-center">Ver</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if($permiso_acceso != 1){
                                                    //es un usuario normal
                                                    $qry = "SELECT SD.id_solicitud,
                                                    SD.id_tipo_solicitud,
                                                    SD.id_documento,
                                                    SD.comentarios,
                                                    SD.fecha_hora,
                                                    SD.id_usuario_solicitante,
                                                    SD.activo,
                                                    SD.estado_solicitud,
                                                    TSD.tipo_solicitud,
                                                    TD.tipo_documento,
                                                    SD.folio_solicitud
                                                    FROM solicitudes_documentos as SD
                                                    INNER JOIN tipo_solicitudes_documentos as TSD ON SD.id_tipo_solicitud = TSD.id_tipo_solicitud
                                                    INNER JOIN documentos as D ON SD.id_documento = D.id_documento
                                                    INNER JOIN tipo_documentos as TD ON D.id_tipo_documento = TD.id_tipo_documento
                                                    WHERE SD.id_usuario_solicitante = $id_usuario_logueado";
                                                }
                                                else{
                                                    //es administrador
                                                    $qry = "SELECT SD.id_solicitud,
                                                    SD.id_tipo_solicitud,
                                                    SD.id_documento,
                                                    SD.comentarios,
                                                    SD.fecha_hora,
                                                    SD.id_usuario_solicitante,
                                                    SD.activo,
                                                    SD.estado_solicitud,
                                                    TSD.tipo_solicitud,
                                                    TD.tipo_documento,
                                                    CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable,
                                                    SD.folio_solicitud
                                                    FROM solicitudes_documentos as SD
                                                    INNER JOIN tipo_solicitudes_documentos as TSD ON SD.id_tipo_solicitud = TSD.id_tipo_solicitud
                                                    LEFT JOIN documentos as D ON SD.id_documento = D.id_documento
                                                    LEFT JOIN usuarios as U ON SD.id_usuario_solicitante = U.id_usuario
                                                    LEFT JOIN personas as P ON U.id_persona = P.id_persona
                                                    LEFT JOIN tipo_documentos as TD ON SD.id_tipo_documento = TD.id_tipo_documento";
                                                }
                                                $solicitudes = $conexion->query($qry);
                                                $n = 1;
                                                while($row = $solicitudes->fetch(PDO::FETCH_ASSOC)){
                                                    $tipo_solicitud = $row["tipo_solicitud"];
                                                    $estado = $row["estado_solicitud"];
                                                    $id_solicitud  = $row["id_solicitud"];
                                                    $folio = $row["folio_solicitud"];
                                                    switch($estado){
                                                        case 0: //esperando validación
                                                        $text_estado = "Esperando validación de dirección";
                                                    }
                                                    ?>
                                                    <tr>
                                                    <td class="text-center"><?php echo $n;?></td>
                                                    <td class="text-center"><strong><b><?php echo $folio;?></b></strong></td>
                                                    <td class="text-center"><strong><b><?php echo $tipo_solicitud;?></b></strong></td>
                                                    <td class="text-center"><strong><b><?php echo $row["tipo_documento"];?></b></strong></td>
                                                    <td class="text-center"><?php echo $row["fecha_hora"];?></td>
                                                    <td class="text-center"><?php echo $row["responsable"];?></td>
                                                    <td class="text-center"><?php echo $text_estado;?></td>
                                                    <td class="text-center"><a href="solicitud.php?id=<?php echo $id_solicitud;?>" class="btn btn-success btn-sm" title="Ver detalles" data-toggle="tooltip"><i class="fa fa-eye" ></i></a></td>
                                                    </tr>
                                                    <?php
                                                    $n++;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-8">
                                    
                                    </div>
                                    <div class="col-md-2">
                                        <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="nueva_solicitud.php" class="btn btn-success btn-block">Generar nueva solicitud</a>
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
    permiso = <?php echo $permiso_acceso;?>;
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        <?php
                $resultado  =$_GET["resultado"];
                if($resultado == "exito_actualizacion"){
                    ?>
                    Swal.fire({
                        type: 'success',
                        title: 'Exito',
                        text: 'Tu información se ha guardado correctamente.!',
                        timer:3000
                    })
                    <?php
                }
                ?>
    function buscar(){
        $("#lstBuscar").addClass("active");
        $(".col-buscar").removeClass("hide");
        $(".col-normal").addClass("hide");
        $("#criterio").focus();
    }
    $("#frmBuscar").submit(function(e){
        $("#btnBuscarFiltro").prop("disabled",true);
        $("#btnBuscarFiltro").removeClass("btn-success");
        $("#btnBuscarFiltro").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        $.ajax({
            url:"buscar_filtro.php",
            type:"POST",
            dataType:"html",
            data:$(this).serialize()
        }).done(function(success){
            if(div_buscar == false){
                $('.th-codigo').before('<th class="text-center">Dirección</th><th class="text-center">Departamento</th><th class="text-center">Tipo de documento</th><th class="text-center">Coincidencia</th>');
            }
            else{

            }
            div_buscar = true;
            if ( $.fn.dataTable.isDataTable( '.tabla_documentos' ) ) {
                $('.tabla_documentos').DataTable().destroy();
                $('.tabla_documentos').DataTable().clear().destroy();
            //crear_tabla();
            $("#registros").html(success);
            var table = $('.tabla_documentos').DataTable( {
              "language": {
                      "url": "../assets/plugins/datatables/media/js/Spanish.json"
              }
            });
            $(".tabla_documentos").removeClass("dataTable");
            $( table.table().header()).addClass( 'th-header' );    
            }
            else{
                $("#registros").html(success);
                var table = $('.tabla_documentos').DataTable( {
              "language": {
                      "url": "../assets/plugins/datatables/media/js/Spanish.json"
              }
            });
            $(".tabla_documentos").removeClass("dataTable");
            $( table.table().header()).addClass( 'th-header' );    
            }
            $("#btnBuscarFiltro").prop("disabled",false);
        $("#btnBuscarFiltro").addClass("btn-success");
        $("#btnBuscarFiltro").html("<i class='fa fa-search'></i> Buscar");
        });
        e.preventDefault();
        return false;
    });
   
    </script>
    
</body>
</html>