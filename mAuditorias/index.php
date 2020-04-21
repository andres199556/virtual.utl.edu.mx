<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
        .btn-option{
            padding-top:5px;padding-bottom:5px;margin-left:8px;margin-right:8px;width:91%; color:#fff;
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
                                <span class="" id="1">Control de auditorias</span>
                                <div class="card-actions">
                                    <button onclick="window.location='alta.php';" class="btn btn-success btn-sm">Agregar
                                        auditoría</button>
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
                                                        <th class="text-center">Año</th>
                                                        <th class="text-center">Enero</th>
                                                        <th class="text-center">Febrero</th>
                                                        <th class="text-center">Marzo</th>
                                                        <th class="text-center">Abril</th>
                                                        <th class="text-center">Mayo</th>
                                                        <th class="text-center">Junio</th>
                                                        <th class="text-center">Julio</th>
                                                        <th class="text-center">Agosto</th>
                                                        <th class="text-center">Septiembre</th>
                                                        <th class="text-center">Octubre</th>
                                                        <th class="text-center">Noviembre</th>
                                                        <th class="text-center">Diciembre</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                $anios = $conexion->query("SELECT DISTINCT
                                                (YEAR(fecha_apertura)) AS anio,
                                                COUNT(id_auditoria) AS cantidad,
                                                GROUP_CONCAT(fecha_apertura) AS fechas_aperturas,
                                                GROUP_CONCAT(MONTH(fecha_apertura)) AS meses_apertura,
                                                GROUP_CONCAT(fecha_cierre) AS fechas_cierres,
                                                GROUP_CONCAT(MONTH(fecha_cierre)) AS meses_cierres,
                                                GROUP_CONCAT(activo) AS activos,
                                                GROUP_CONCAT(id_auditoria) AS ids
                                            FROM
                                                auditorias
                                            GROUP BY
                                                YEAR (fecha_apertura)");
                                                if($anios->rowCount() == 0){
                                                    ?>
                                                    <tr>
                                                        <td class="text-center" colspan=13>No existen auditorías en el
                                                            sistema.</td>
                                                    </tr>
                                                    <?php
                                                }
                                                while($row = $anios->fetch(PDO::FETCH_ASSOC)){
                                                    $anio  =$row["anio"];
                                                    $cantidad = $row["cantidad"];
                                                    $meses_aperturas = $row["meses_apertura"];
                                                    $aperturas = $row["fechas_aperturas"];
                                                    $cierres = $row["fechas_cierres"];
                                                    $mes_cierres = $row["meses_cierres"];
                                                    $array_aperturas = explode(",",$aperturas);
                                                    $array_cierres = explode(",",$cierres);
                                                    $array_mes_a = explode(",",$meses_aperturas);
                                                    $array_mes_c  =explode(",",$mes_cierres);
                                                    $array_activos = explode(",",$row["activos"]);
                                                    $ids = explode(",",$row["ids"]);
                                                    //busco las auditorias por año
                                                    for($i = 0;$i<$cantidad;$i++){
                                                        $activo = $array_activos[$i];
                                                        $id_auditoria  =$ids[$i];
                                                        switch($activo){
                                                            case 1:
                                                                //abierta
                                                                $estado = '<button onclick="ver_auditoria('.$id_auditoria.');" class="btn btn-warning btn-block" type="button" title="Auditoría abierta" data-toggle="tooltip"><i class="fa fa-unlock"></i></button>';
                                                            break;
                                                            case 0:
                                                                $estado = '<button onclick="ver_auditoria('.$id_auditoria.');" class="btn btn-success btn-block" type="button" title="Auditoría cerrada" data-toggle="tooltip"><i class="fa fa-lock"></i></button>';
                                                            break;

                                                        }
                                                        ?>
                                                    <tr>
                                                        <?php echo ($i == 0) ? '<td class="text-center" rowspan='.$cantidad.' style="vertical-align:middle"><b><strong>'.$anio.'</strong></b></td>':'';  ?>
                                                        <?php
                                                            for($j = 1;$j<($array_mes_a[$i]);$j++){
                                                                echo "<td class='text-center'></td>";
                                                            }
                                                            //combino las celdas
                                                            $diferencia = 0;
                                                            for($k = $array_mes_a[$i];$k<=$array_mes_c[$i];$k++){
                                                                $diferencia++;
                                                            }
                                                            ?>
                                                        <td class="text-center" colspan=<?php echo $diferencia;?>>
                                                            <?php echo $estado;?></td>
                                                        <?php
                                                            for($j = $array_mes_c[$i] + 1;$j<=12;$j++){
                                                                echo "<td class='text-center'></td>";
                                                            }
                                                            ?>

                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row hide" id="rowDatosAuditoria">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-actions">
                                                    <div class="btn-group" style="width:200px;">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm btn-block dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"><i class="fa fa-cog"></i>
                                                            Opciones
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                            <a class="dropdown-item btn btn-success btn-option" style="color:#fff;" id="link_plan"
                                                                href="#"><i class="fa fa-edit"></i> Agregar plan de
                                                                auditoría</a>
                                                                <div class="dropdown-divider"></div>
                                                            <!-- <a class="dropdown-item btn btn-danger btn-option" style="color:#fff;" href="eliminar_auditoria.php"><i
                                                                    class="fa fa-times"></i> Eliminar auditoría</a>
                                                                    <div class="dropdown-divider"></div> -->
                                                            <a id="link_historial" class="dropdown-item btn btn-info btn-option" style="color:#fff;"
                                                                href="historial.php"><i class="fa fa-file"></i> Ver
                                                                historial de
                                                                actividades</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item btn btn-option btn-warning" style="color:#fff;"
                                                                id="link_editar_auditoria" href="#"><i
                                                                    class="fa fa-edit"></i> Editar auditoría</a>
                                                                    <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item btn btn-primary btn-option" style="color:#fff;"
                                                                id="link_cerrar_auditoria" href="#"><i
                                                                    class="fa fa-check"></i> Cerrar auditoría</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 form-group">
                                                        <label for="tipo" class="control-label"
                                                            style="font-weight:bold">Tipo de
                                                            auditoría: </label>
                                                        <input type="text" name="tipo" readonly id="tipo"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="alcance" class="control-label"
                                                            style="font-weight:bold">Alcance de
                                                            auditoría: </label>
                                                        <input type="text" name="" id="alcance" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="fecha_apertura" class="control-label"
                                                            style="font-weight:bold">Fecha
                                                            de apertura: </label>
                                                        <input type="text" name="fecha_apertura" fechas required
                                                            id="fecha_apertura" autocomplete="off" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="fecha_cierre" class="control-label"
                                                            style="font-weight:bold">Fecha
                                                            de cierre: </label>
                                                        <input type="text" name="fecha_cierre" required fechas
                                                            id="fecha_cierre" autocomplete="off" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label for="objetivo" class="control-label"
                                                            style="font-weight:bold">Objetivo:
                                                        </label>
                                                        <textarea name="objetivo" id="objetivo" cols="30" rows="5"
                                                            required class="form-control" readonly></textarea>
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="criterio" class="control-label"
                                                            style="font-weight:bold">Criterio:
                                                        </label>
                                                        <textarea name="criterio" id="criterio" cols="30" rows="5"
                                                            required class="form-control" readonly></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="">
                                                            <table
                                                                class="table table-hover table-bordered color-table success-table tabla-acciones">
                                                                <thead>
                                                                    <th class="text-center">#</th>
                                                                    <th class="text-center">Dirección</th>
                                                                    <th class="text-center">Proceso</th>
                                                                    <th class="text-center">Responsable</th>
                                                                    <th class="text-center">Fecha y hora</th>
                                                                    <th class="text-center">Auditor(es)</th>
                                                                    <th class="text-center">Elementos a auditar</th>
                                                                    <th class="text-center">Estado</th>
                                                                    <th class="text-center" colspan=3>Acciones</th>

                                                                </thead>
                                                                <tbody class="body-planes">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row hide" id="divFinalAuditoria">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="conclusiones" class="control-label"><b><strong>Conclusiones:</strong></b> </label>
                                                            <textarea name="" readonly id="conclusiones_finales" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h3 class="text-center">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table class="table table-hover table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">Evidencias</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="evidencias_cierre">
                                                                            <tr>
                                                                                <td class="text-center">hola</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </h3>
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
    <div id="modal_cierre" class="modal fade" role="dialog">
    </div>
    <form action="cerrar_auditoria.php" id="frmCerrarAuditoria">
    <div id="modal_cerrar_auditoria" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cerrar auditoria</h4>
                    <input type="hidden" name="id_auditoria" id="id_auditoria_cerrar">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="evidencia" class="control-label">Evidencia: </label>
                            <input type="file" name="evidencias[]" required multiple id="evidencias"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="comentarios" class="control-label">Conclusiones: </label>
                            <textarea name="conclusiones" id="conclusiones" cols="30" rows="5" style="resize:none;"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cerrar auditoria</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>

        </div>
    </div>
    </form>
    <!-- Modal -->
    <form action="cerrar_plan.php" method="post" id="frmCerrarPlan">
        <div id="modal_cerrar_plan" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cerrar plan de auditoría</h4>
                        <input type="hidden" name="id_plan" id="id_plan">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="puntuacion" class="control-label">Puntuación: </label>
                                <input type="number" min=0 max=100 name="puntuacion" required id="puntuacion"
                                    class="form-control">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="evidencia" class="control-label">Evidencia: </label>
                                <input type="file" name="evidencias[]" required multiple id="evidencias"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="comentarios" class="control-label">Comentarios: </label>
                                <textarea name="comentarios" id="comentarios" cols="30" rows="5" style="resize:none;"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar y cerrar plan</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
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
        $("#link_historial").attr("href", "historial.php?id=" + id);
        $("#link_editar_auditoria").attr("href","editar_auditoria.php?id="+id);
        $("#rowDatosAuditoria").removeClass("hide");
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
            var estado_auditoria = success["activo"];
            var conclusiones = success["conclusiones"];
            if(estado_auditoria == 0){
                //ya esta cerrada
                $("#divFinalAuditoria").removeClass("hide");
                $("#conclusiones_finales").val(conclusiones);
                $("#link_plan").addClass("hide");
                $("#link_editar_auditoria").addClass("hide");
                $("#link_cerrar_auditoria").addClass("hide");
                var names = success["nombres"];
                var array_nombres = names.split(",");
                var files = success["file_strings"];
                var array_files = files.split(",");
                $("#evidencias_cierre").html("");
                for(var i = 0;i<array_nombres.length;i++){
                    var nombre = array_nombres[i];
                    var file = array_files[i];
                    $("#evidencias_cierre").append("<tr><td><a href='download.php?f="+file+"&tipo=cierre'>"+nombre+"</a></td></tr>");

                }
                $("#evidencias_cierre");
            }
            else{
                $("#link_plan").removeClass("hide");
                $("#link_editar_auditoria").removeClass("hide");
                $("#link_cerrar_auditoria").removeClass("hide");
            }
            var planes = success["planes"];
            var contador = 0;
            var contador_abiertos = 0;
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
                var fila;
                if (activo == 1) {
                    contador_abiertos++;
                    fila = '<tr>' +
                        '<td class="text-center">' + contador + '</td>' +
                        '<td class="text-center">' + direccion + '</td>' +
                        '<td class="text-center">' + proceso + '</td>' +
                        '<td class="text-center">' + responsable + '</td>' +
                        '<td class="text-center">' + fecha + '</td>' +
                        '<td class="text-center">' + auditores + '</td>' +
                        '<td class="text-center">' + elementos + '</td>' +
                        '<td class="text-center">' + estado + '</td>' +
                        '<td class="text-center">' +
                        '<a href="javascript:cerrar_plan(' + id_plan +
                        ');" style="margin-right:5px;" title="Cargar evidencia" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a></td>' +
                        '<td><a href="editar_plan.php?id=' + id_plan +
                        '" style="margin-right:5px;"  title="Editar plan" data-toggle="tooltip" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a></td>' +
                        '<td><a href="javascript:eliminar_plan(' + id_plan +
                        ');" style="margin-right:5px;"  title="Eliminar" data-toggle="tooltip" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>' +
                        '</td></tr>';
                } else if (activo == 0) {
                    fila = '<tr>' +
                        '<td class="text-center">' + contador + '</td>' +
                        '<td class="text-center">' + direccion + '</td>' +
                        '<td class="text-center">' + proceso + '</td>' +
                        '<td class="text-center">' + responsable + '</td>' +
                        '<td class="text-center">' + fecha + '</td>' +
                        '<td class="text-center">' + auditores + '</td>' +
                        '<td class="text-center">' + elementos + '</td>' +
                        '<td class="text-center">' + estado + '</td>' +
                        '<td class="text-center" colspan=3>' +
                        '<a href="javascript:ver_cierre(' + id_plan +
                        ');" style="margin-right:5px;" title="Ver cierre de plan" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-folder"></i></a>' +
                        '</td></tr>';
                }

                $(".body-planes").append(fila);
            }
            if (contador_abiertos != 0 || contador == 0) {
                $("#link_cerrar_auditoria").remove();
            } else {
                $("#link_cerrar_auditoria").attr("href", "javascript:cerrar_auditoria(" + id + ");");
            }
        }).fail(function(error) {
            alert(error);
        });
    }

    <?php
    if (isset($_GET["id"])) {
        ?>
        ver_auditoria( <?php echo $_GET["id"]; ?> ); 
        <?php
    } 
    ?>

    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    });

    function eliminar_plan(id) {
        Swal.fire({
            title: '¿Eliminar plan de auditoria?',
            text: "Si eliminas el plan, la evidencia y la información que hayas generado se borrará del sistema completamente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#c0c0c0',
            confirmButtonText: 'Eliminar',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                window.location = "eliminar_plan.php?id=" + id
            }
        })
    }

    function cerrar_plan(id) {
        $("#id_plan").val(id);
        $("#modal_cerrar_plan").modal("show");
    }
    $("#frmCerrarPlan").submit(function(e) {
        var id_plan = $("#id_plan").val();
        $("#frmCerrarPlan").find("button[type=submit]").html(
            "<i class='fa fa-spinner fa-spin'></i> Guardando...");
        $("#frmCerrarPlan").find("button[type=submit]").prop("disabled", true);
        var fd = new FormData(document.getElementById("frmCerrarPlan"));
        $.ajax({
            url: "cerrar_plan.php",
            type: "POST",
            dataType:"json",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false // tell jQuery not to set contentType
        }).done(function(exito) {
            var resultado = exito["resultado"];
            window.location = "index.php?id="+id_plan;
            //$("#frmCerrarPlan").find("button[type=submit]").prop("disabled", false);
        });
        e.preventDefault();
        return false;
    });

    function ver_cierre(id) {
        $.ajax({
            url: "ver_cierre.php",
            type: "POST",
            dataType: "html",
            data: {
                'id': id
            }
        }).done(function(exito) {
            $("#modal_cierre").html(exito);
            $("#modal_cierre").modal("show");
        })
    }

    function cerrar() {
        $("#modal_cierre").modal("hide");
    }

    function cerrar_auditoria(id) {
        $("#id_auditoria_cerrar").val(id);
        $("#modal_cerrar_auditoria").modal("show");
    }
    $("#frmCerrarAuditoria").submit(function(e){
        $("#frmCerrarAuditoria").find("button[type=submit]").html(
            "<i class='fa fa-spinner fa-spin'></i> Guardando...");
        $("#frmCerrarAuditoria").find("button[type=submit]").prop("disabled", true);
        var fd = new FormData(document.getElementById("frmCerrarAuditoria"));
        $.ajax({
            url: "cerrar_auditoria.php",
            type: "POST",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false // tell jQuery not to set contentType
        }).done(function(exito) {
            alert(exito);
            $("#frmCerrarPlan").find("button[type=submit]").prop("disabled", false);
        });
        e.preventDefault();
        return false;
    })
    </script>
</body>

</html>