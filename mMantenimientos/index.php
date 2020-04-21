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
                                <span class="card-title" id="1">Planes de mantenimiento</span>
                                <div class="card-actions">
                                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Acciones</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="mantenimiento_activo.php"><i
                                                class="text-primary fa fa-file"></i> Buscar historial de activo</a>
                                        <a class="dropdown-item"
                                            href="futuros_mantenimientos.php"><i
                                                class="text-success fa fa-user"></i> Mostrar futuros mantenimientos</a>
                                        <a class="dropdown-item"
                                            href="generar_informe.php"><i
                                                class="text-primary fa fa-chart-bar"></i> Generar informe de mantenimientos</a>
                                        
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
                                                (YEAR(fecha_inicio)) AS anio,
                                                COUNT(id_plan_mantenimiento) AS cantidad,
                                                GROUP_CONCAT(fecha_inicio) AS fechas_aperturas,
                                                GROUP_CONCAT(MONTH(fecha_inicio)) AS meses_apertura,
                                                GROUP_CONCAT(fecha_final) AS fechas_cierres,
                                                GROUP_CONCAT(MONTH(fecha_final)) AS meses_cierres,
                                                GROUP_CONCAT(activo) AS activos,
                                                GROUP_CONCAT(id_plan_mantenimiento) AS ids,
                                                GROUP_CONCAT(color) as colores,
                                                GROUP_CONCAT(titulo_plan) as titulos
                                            FROM
                                                planes_mantenimientos
                                            GROUP BY
                                                YEAR (fecha_inicio)");
                                                if($anios->rowCount() == 0){
                                                    ?>
                                                            <tr>
                                                                <td class="text-center" colspan=13>No existen mantenimientos programados.</td>
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
                                                    $colores = $row["colores"];
                                                    $titulos  =$row["titulos"];
                                                    $array_aperturas = explode(",",$aperturas);
                                                    $array_cierres = explode(",",$cierres);
                                                    $array_mes_a = explode(",",$meses_aperturas);
                                                    $array_mes_c  =explode(",",$mes_cierres);
                                                    $array_activos = explode(",",$row["activos"]);
                                                    $array_colores = explode(",",$colores);
                                                    $array_titulos = explode(",",$titulos);
                                                    $ids = explode(",",$row["ids"]);
                                                    //busco las auditorias por año
                                                    for($i = 0;$i<$cantidad;$i++){
                                                        $activo = $array_activos[$i];
                                                        $id_plan  =$ids[$i];
                                                        $color = $array_colores[$i];
                                                        $titulo = $array_titulos[$i];
                                                        switch($activo){
                                                            case 1:
                                                                //abierta
                                                                $estado = '<button onclick="plan('.$id_plan.');" class="btn btn-block" style="background:'.$color.'" type="button" title="'.$titulo.'" data-toggle="tooltip"><i class="fa fa-unlock"></i></button>';
                                                            break;
                                                            case 0:
                                                                $estado = '<button onclick="plan('.$id_plan.');" class="btn btn-block" style="background:'.$color.'" type="button" title="'.$titulo.'" data-toggle="tooltip"><i class="fa fa-lock"></i></button>';
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
                                                                <td class="text-center"
                                                                    colspan=<?php echo $diferencia;?>>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card card-outline-info">
                                                    <div class="card-header">
                                                        <span class="text-white">Detalles del plan</span>
                                                        <div class="card-actions">
                                                            <a href="alta_mantenimiento.php"
                                                                id="btn_agregar_mantenimiento"
                                                                class="btn btn-success btn-block text-white"><i
                                                                    class="fas fa-plus"></i> Agregar mantenimiento</a>
                                                        </div>
                                                    </div>
                                                    <div class="card-body" id="">
                                                        <div class="container-fluid" id="content-details">

                                                        </div>
                                                        <div class="container-fluid hide"
                                                            id="datos_planes_individuales">
                                                            <h4 class="text-center">Listado de mantenimientos</h4>
                                                            <div class="">
                                                                <table
                                                                    class="table table-hover table-striped table-condensed table-bordered color-table success-table"
                                                                    id="tabla_registros">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">#</th>
                                                                            <th class="text-center">Usuario</th>
                                                                            <th class="text-center">Departamento</th>
                                                                            <th class="text-center">Fecha inicial</th>
                                                                            <th class="text-center">Fecha de cierre</th>
                                                                            <!-- <th class="text-center">Comentarios</th> -->
                                                                            <th class="text-center">Estado</th>
                                                                            <th class="text-center">Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="body_listado_individuales">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
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
                <div id="modal_fechas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                                            <input type="text" name="fecha_inicio" id="fecha_inicio"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="" class="control-label">Hora de alta servicio:</label>
                                            <input type="text" name="hora_apertura" id="hora_apertura"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect"
                                    data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary waves-effect">Actualizar fechas</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal_configuracion" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
                                <button type="button" class="btn btn-default waves-effect"
                                    data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="#" id="frmLiberar" method="post" enctype="multipart/form-data">
                    <div id="modal_liberar" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Liberar servicio</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>

                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_servicio" id="id_servicio_liberar">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="acciones" class="control-label">Acciones realizadas:</label>
                                            <textarea name="acciones_realizadas" required id="acciones"
                                                class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="" class="control-label">Fecha de cierre:</label>
                                            <input type="text" required name="fecha_final" id="fecha_final"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="" class="control-label">Hora de cierre:</label>
                                            <input type="time" required name="hora_cierre" id="hora_cierre"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" name="fecha_servidor" value="1" class="filled-in"
                                                id="cambiar_fechas" onclick="habilitar_fechas(this);">
                                            <label for="cambiar_fechas">La fecha y la hora se toman al momento de
                                                guardar.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" id="bitacora" value="1" class="filled-in" checked=""
                                                name="bitacora" onclick="habilitar_check();">
                                            <label for="bitacora">Subir la información de este servicio en la bitácora
                                                del departamento.</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="checkbox" id="bitacora_publica" value="1" class="filled-in"
                                                checked="" name="bitacora_publica">
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
                                    <button type="button" class="btn btn-default waves-effect"
                                        data-dismiss="modal">Cerrar</button>
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
    $("[data-toggle=tooltip]").tooltip();
    </script>
</body>

</html>