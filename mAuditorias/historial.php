<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_GET["id"];
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
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
        padding: 10px
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

    .bg-red,
    .bg-yellow,
    .bg-aqua,
    .bg-blue,
    .bg-light-blue,
    .bg-green,
    .bg-navy,
    .bg-teal,
    .bg-olive,
    .bg-lime,
    .bg-orange,
    .bg-fuchsia,
    .bg-purple,
    .bg-maroon,
    .bg-black,
    .bg-red-active,
    .bg-yellow-active,
    .bg-aqua-active,
    .bg-blue-active,
    .bg-light-blue-active,
    .bg-green-active,
    .bg-navy-active,
    .bg-teal-active,
    .bg-olive-active,
    .bg-lime-active,
    .bg-orange-active,
    .bg-fuchsia-active,
    .bg-purple-active,
    .bg-maroon-active,
    .bg-black-active,
    .callout.callout-danger,
    .callout.callout-warning,
    .callout.callout-info,
    .callout.callout-success,
    .alert-success,
    .alert-danger,
    .alert-error,
    .alert-warning,
    .alert-info,
    .label-danger,
    .label-info,
    .label-warning,
    .label-primary,
    .label-success,
    .modal-primary .modal-body,
    .modal-primary .modal-header,
    .modal-primary .modal-footer,
    .modal-warning .modal-body,
    .modal-warning .modal-header,
    .modal-warning .modal-footer,
    .modal-info .modal-body,
    .modal-info .modal-header,
    .modal-info .modal-footer,
    .modal-success .modal-body,
    .modal-success .modal-header,
    .modal-success .modal-footer,
    .modal-danger .modal-body,
    .modal-danger .modal-header,
    .modal-danger .modal-footer {
        color: #fff !important
    }

    .bg-gray {
        color: #000;
        background-color: #d2d6de !important
    }

    .bg-gray-light {
        background-color: #f7f7f7
    }

    .bg-black {
        background-color: #111 !important
    }

    .bg-red,
    .callout.callout-danger,
    .alert-danger,
    .alert-error,
    .label-danger,
    .modal-danger .modal-body {
        background-color: #dd4b39 !important
    }

    .bg-yellow,
    .callout.callout-warning,
    .alert-warning,
    .label-warning,
    .modal-warning .modal-body {
        background-color: #f39c12 !important
    }

    .bg-aqua,
    .callout.callout-info,
    .alert-info,
    .label-info,
    .modal-info .modal-body {
        background-color: #00c0ef !important
    }

    .bg-blue {
        background-color: #0073b7 !important
    }

    .bg-light-blue,
    .label-primary,
    .modal-primary .modal-body {
        background-color: #3c8dbc !important
    }

    .bg-green,
    .callout.callout-success,
    .alert-success,
    .label-success,
    .modal-success .modal-body {
        background-color: #00a65a !important
    }

    .bg-navy {
        background-color: #001f3f !important
    }

    .bg-teal {
        background-color: #39cccc !important
    }

    .bg-olive {
        background-color: #3d9970 !important
    }

    .bg-lime {
        background-color: #01ff70 !important
    }

    .bg-orange {
        background-color: #ff851b !important
    }

    .bg-fuchsia {
        background-color: #f012be !important
    }

    .bg-purple {
        background-color: #605ca8 !important
    }

    .bg-maroon {
        background-color: #d81b60 !important
    }

    .bg-gray-active {
        color: #000;
        background-color: #b5bbc8 !important
    }

    .bg-black-active {
        background-color: #000 !important
    }

    .bg-red-active,
    .modal-danger .modal-header,
    .modal-danger .modal-footer {
        background-color: #d33724 !important
    }

    .bg-yellow-active,
    .modal-warning .modal-header,
    .modal-warning .modal-footer {
        background-color: #db8b0b !important
    }

    .bg-aqua-active,
    .modal-info .modal-header,
    .modal-info .modal-footer {
        background-color: #00a7d0 !important
    }

    .bg-blue-active {
        background-color: #005384 !important
    }

    .bg-light-blue-active,
    .modal-primary .modal-header,
    .modal-primary .modal-footer {
        background-color: #357ca5 !important
    }

    .bg-green-active,
    .modal-success .modal-header,
    .modal-success .modal-footer {
        background-color: #008d4c !important
    }

    .bg-navy-active {
        background-color: #001a35 !important
    }

    .bg-teal-active {
        background-color: #30bbbb !important
    }

    .bg-olive-active {
        background-color: #368763 !important
    }

    .bg-lime-active {
        background-color: #00e765 !important
    }

    .bg-orange-active {
        background-color: #ff7701 !important
    }

    .bg-fuchsia-active {
        background-color: #db0ead !important
    }

    .bg-purple-active {
        background-color: #555299 !important
    }

    .bg-maroon-active {
        background-color: #ca195a !important
    }

    [class^="bg-"].disabled {
        opacity: .65;
        filter: alpha(opacity=65)
    }

    .text-red {
        color: #dd4b39 !important
    }

    .text-yellow {
        color: #f39c12 !important
    }

    .text-aqua {
        color: #00c0ef !important
    }

    .text-blue {
        color: #0073b7 !important
    }

    .text-black {
        color: #111 !important
    }

    .text-light-blue {
        color: #3c8dbc !important
    }

    .text-green {
        color: #00a65a !important
    }

    .text-gray {
        color: #d2d6de !important
    }

    .text-navy {
        color: #001f3f !important
    }

    .text-teal {
        color: #39cccc !important
    }

    .text-olive {
        color: #3d9970 !important
    }

    .text-lime {
        color: #01ff70 !important
    }

    .text-orange {
        color: #ff851b !important
    }

    .text-fuchsia {
        color: #f012be !important
    }

    .text-purple {
        color: #605ca8 !important
    }

    .text-maroon {
        color: #d81b60 !important
    }

    .link-muted {
        color: #7a869d
    }

    .link-muted:hover,
    .link-muted:focus {
        color: #606c84
    }

    .link-black {
        color: #666
    }

    .link-black:hover,
    .link-black:focus {
        color: #999
    }
    </style>
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
                        <div class="card">
                            <div class="card-header">
                                <span class="" id="1">Historial de actividades</span>
                                <div class="card-actions">
                                    <button onclick="window.location='index.php';"
                                        class="btn btn-danger btn-sm">Regresar</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    <?php
                            $fechas = $conexion->query("
                            SELECT DISTINCT
                                (
                                DATE_FORMAT( DATE( fecha_hora ), '%W %e de %M %Y' )) AS fecha,DATE(fecha_hora) as formato_real
                            FROM
                                registros_auditorias 
                            WHERE
                                id_auditoria = $id");
                                while($row = $fechas->fetch(PDO::FETCH_ASSOC)){
                                    $fecha = $row["fecha"];
                                    $solo  =$row["formato_real"];
                                    ?>
                                    <li class="time-label">
                                        <span class="bg-green">
                                            <?php echo $fecha;?> </span>
                                    </li>
                                    <?php
                                    //busco los registros
                                    $registros = $conexion->query("SELECT id_registro,registro,icono,color,TIME_FORMAT(TIME(fecha_hora),'%h:%i %p') as hora FROM registros_auditorias
                                    WHERE id_auditoria = $id AND DATE(fecha_hora) = '$solo' ORDER BY id_registro DESC");
                                    while($re = $registros->fetch(PDO::FETCH_ASSOC)){
                                        $registro = $re["registro"];
                                        $icono = $re["icono"];
                                        $color = $re["color"];
                                        $hora = $re["hora"];
                                        ?>
                                        <li>
                                        <i class="<?php echo $icono.' '.$color;?>  "></i>
                                        <div class="timeline-item">
                                            <div class="timeline-body">
                                                <?php echo $registro;?> <p
                                                    class="pull-right badge <?php echo $color;?>" id="lblFecha1"><?php echo $hora;?></p>
                                            </div>
                                        </div>
                                    </li>
                                        <?php
                                    }
                                }
                            ?>
                                    
                                </ul>
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
    <!-- <script type="text/javascript" src="funciones.js"></script> -->
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(document).ready(function(e) {
        var celdas = $(".td-count");
        var cantidad = $(celdas).length;
        for (var i = 0; i < cantidad; i++) {
            var celda = $(celdas).eq(i).closest("td");
            var cell_index = celda[0].cellIndex;
            var fila = $(celda).closest("tr");
            var row_index = fila[0].rowIndex;

            var valor_celda = parseInt($(celda).find(".number-td").html());
            var anio = parseInt($(celda).attr("data-year"));
            if (valor_celda != 0 && cell_index != 0) {
                //tiene acciones correctivas y esta fuera de los años
                var link = "<a href='javascript:ver_acciones(" + anio + "," + cell_index + ");'  data-year=" +
                    anio + " data-month=" + cell_index +
                    " class='btn btn-success btn-sm btn-ver-acciones' title='Ver acciones' data-toggle='tooltip'><b><strong>" +
                    valor_celda + "</strong></b></a>";
                $(celda).html(link);
            }

        }
    })

    function ver_auditoria(id) {
        $("#link_plan").attr("href", "alta_plan.php?id=" + id);
        $.ajax({
            url: "ver.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            }
        }).done(function(success) {
            $("#tipo").val(success["tipo"]);
            $("#alcance").val(success["alcance"]);
            $("#fecha_apertura").val(success["fecha_apertura"]);
            $("#fecha_cierre").val(success["fecha_cierre"]);
            $("#objetivo").val(success["objetivo"]);
            $("#criterio").val(success["criterio"]);
            var planes = success["planes"];
            var contador = 0;
            $(".body-planes").html('');
            for (var i = 0; i < planes.length; i++) {
                var plan = planes[i];
                contador++;
                var id_plan = plan["id_plan"];
                var direccion = plan["direccion"];
                var proceso = plan["proceso"];
                var responsable = plan["responsable"];
                var fecha = plan["fecha_hora_plan"];
                var elementos = plan["elementos"];
                var activo = plan["activo"];
                var auditores = plan["auditores"];
                var estado = (activo == 1) ?
                    "<span class='text-center text-danger'><b><strong>Abierta</strong></b></span>" :
                    "<span class='text-center text-success'><b><strong>Cerrada</strong></b></span>";
                var fila = '<tr>' +
                    '<td class="text-center">' + contador + '</td>' +
                    '<td class="text-center">' + direccion + '</td>' +
                    '<td class="text-center">' + proceso + '</td>' +
                    '<td class="text-center">' + responsable + '</td>' +
                    '<td class="text-center">' + fecha + '</td>' +
                    '<td class="text-center">' + auditores + '</td>' +
                    '<td class="text-center">' + elementos + '</td>' +
                    '<td class="text-center">' + estado + '</td>' +
                    '<td class="text-center">' +
                    '<a href="cerrar_plan.php?id=' + id_plan +
                    '" style="margin-right:5px;" title="Cargar evidencia" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a></td>' +
                    '<td><a href="editar_plan.php?id=' + id_plan +
                    '" style="margin-right:5px;"  title="Editar plan" data-toggle="tooltip" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a></td>' +
                    '<td><a href="eliminar_plan.php?id=' + id_plan +
                    '" style="margin-right:5px;"  title="Eliminar" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>' +
                    '</td></tr>';
                $(".body-planes").append(fila);
            }
        }).fail(function(error) {
            alert(error);
        });
    }

    function listar_planes(id) {
        alert(id);
    }
    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    }); <
    ? php
    if (isset($_GET["id"])) {
        ?
        >
        ver_auditoria( < ? php echo $_GET["id"]; ? > ); <
        ? php
    } ?
    >
    </script>
</body>

</html>