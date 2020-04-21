<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if(!isset($_GET["id"])){
    header("Location:index.php");
}
else{
    $id_plan_individual = $_GET["id"];
    //busco la información basica
    $info = $conexion->query("SELECT PI.id_plan_individual,
    PI.id_usuario,
    DI.direccion,
    DE.departamento,
    PU.puesto,
    CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona,
    T.no_empleado,
    T.correo,
    PI.fecha_inicio_mantenimiento,
    PI.comentarios,
    PI.fecha_cierre_mantenimiento,
    PI.comentarios_cierre,
    PI.activo,
    IF(PI.id_responsable_mantenimiento is NULL,'Sin especificar',CONCAT(P2.nombre,' ',P2.ap_paterno,' ',P2.ap_materno)) as responsable,
    PI.fecha_liberacion,
    PI.comentarios_liberacion
    FROM planes_individuales_mantenimientos as PI
    INNER JOIN usuarios as U ON PI.id_usuario_mantenimiento = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
    INNER JOIN departamentos as DE ON T.id_departamento = DE.id_departamento
    INNER JOIN direcciones as DI ON T.id_direccion = DI.id_direccion
    INNER JOIN puestos as PU ON T.id_puesto = T.id_puesto
    LEFT JOIN usuarios as U2 ON PI.id_responsable_mantenimiento = U2.id_usuario
    LEFT JOIN personas as P2 ON U2.id_persona = P2.id_persona
    WHERE PI.id_plan_individual = $id_plan_individual
    ");
    $row_datos = $info->fetch(PDO::FETCH_ASSOC);
}
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
                <input type="hidden" name="id_plan_mantenimiento" value="<?php echo $id_plan_mantenimiento;?>">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <span class="text-white">Detalles del mantenimiento</span>
                                <div class="card-actions">
                                    <?php
                               if($row_datos["activo"] == 1){
                                   ?>
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Acciones</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="javascript:cambiar_fechas(<?php echo $id_plan_individual;?>);"><i
                                                class="text-primary fa fa-calendar"></i> Cambiar fecha de
                                            mantenimiento</a>
                                        <a class="dropdown-item"
                                            href="javascript:asignar_responsable_mantenimiento(<?php echo $id_plan_individual;?>);"><i
                                                class="text-success fa fa-user"></i> Asignar responsable</a>
                                        <a class="dropdown-item"
                                            href="javascript:enviar_notificacion(<?php echo $id_plan_individual;?>);"><i
                                                class="text-primary fa fa-envelope"></i> Enviar notificación al
                                            usuario</a>
                                        <a class="dropdown-item"
                                            href="javascript:agregar_nota(<?php echo $id_plan_individual;?>);"><i
                                                class="text-warning fa fa-sticky-note"></i> Agregar nota</a>
                                        <a class="dropdown-item"
                                            href="javascript:agregar_activos(<?php echo $id_plan_individual;?>);"><i
                                                class="text-primary fa fa-desktop"></i> Agregar activos al
                                            mantenimiento</a>
                                        <a class="dropdown-item text-red" href="javascript:void(0)"><i
                                                class="text-danger fa fa-times-circle"></i> Cancelar mantenimiento</a>
                                    </div>
                                    <?php
                               }
                               ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="trabajador" class="control-label"
                                            style="font-weight:bold;">Trabajador: </label>
                                        <?php echo $row_datos["persona"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label"
                                            style="font-weight:bold;">Dirección: </label>
                                        <?php echo $row_datos["direccion"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label"
                                            style="font-weight:bold;">Departamento: </label>
                                        <?php echo $row_datos["departamento"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label" style="font-weight:bold;">Puesto:
                                        </label><?php echo $row_datos["puesto"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label" style="font-weight:bold;">Correo:
                                        </label> <?php echo $row_datos["correo"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label" style="font-weight:bold;">Nº de
                                            empleado: </label> <?php echo $row_datos["no_empleado"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label" style="font-weight:bold;">Fecha de
                                            inicio del mantenimiento: </label>
                                        <?php echo $row_datos["fecha_inicio_mantenimiento"];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="responsable" class="control-label"
                                            style="font-weight:bold;">Responsable del mantenimiento: </label> <span
                                            id="responsable"><?php echo $row_datos["responsable"];?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="direccion" class="control-label"
                                            style="font-weight:bold;">Comentarios: </label>
                                        <?php echo $row_datos["comentarios"];?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-outline-success">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h4 class="m-b-0 text-white">Notas del mantenimiento</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                            //busco las notas
                                            $notas = $conexion->query("SELECT id_nota_mantenimiento,
                                            NM.fecha_hora,
                                            nota,
                                            CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
                                            FROM notas_mantenimientos as NM
                                            INNER JOIN usuarios as U ON NM.id_usuario = U.id_usuario
                                            INNER JOIN personas as P ON U.id_persona = P.id_persona
                                            WHERE id_plan_individual = $id_plan_individual");
                                            while($row_notas = $notas->fetch(PDO::FETCH_NUM)){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <p class="text-justify">Fecha:
                                                            <strong><b><?php echo $row_notas[1];?></b></strong></p>
                                                        <p class="text-justify">Usuario:
                                                            <strong><b><?php echo $row_notas[3];?></b></strong></p>
                                                        <p class="text-justify"><b><strong>Nota: </strong></b></p>
                                                        <p class="text-justify"
                                                            style="font-style:italic;font-size:14px;">
                                                            <?php echo $row_notas[2];?></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <?php
                                            }
                                            ?>
                                            </div>
                                            <div class="card-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Activos dentro del mantenimiento</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-striped table-condensed table-bordered color-table primary-table">
                                                <thead>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Nº de activo</th>
                                                    <th class="text-center">Tipo de activo</th>
                                                    <th class="text-center">Marca</th>
                                                    <th class="text-center">Modelo</th>
                                                    <th class="text-center">Nº serie</th>
                                                    <th class="text-center">Eliminar activo</th>
                                                </thead>
                                                <tbody id="table_activos">
                                                    <?php
                                                    //busco los activos
                                                    $activos = $conexion->query("SELECT
                                                    AM.id_activo_mantenimiento,
                                                    AM.no_activo,
                                                    ME.nombre_marca,
                                                    AF.modelo,
                                                    AF.no_serie,
                                                    IF(CAF.consecutivo_activo_fijo is null,'Sin especificar',CAF.consecutivo_activo_fijo)
                                                FROM
                                                    activos_mantenimientos AS AM
                                                LEFT JOIN activos_fijos AS AF ON AM.id_activo = AF.id_activo_fijo
                                                LEFT JOIN marcas_equipos AS ME ON AF.id_marca = ME.id_marca
                                                LEFT JOIN consecutivos_activos_fijos AS CAF ON AF.id_consecutivo_activo_fijo = CAF.id_consecutivo_activo_fijo
                                                WHERE
                                                    AM.id_plan_individual_mantenimiento = $id_plan_individual");
                                                    $n = 0;
                                                    while($row = $activos->fetch(PDO::FETCH_NUM)){
                                                        ++$n;
                                                        ?>
                                                    <tr id="fila_mantenimiento_<?php echo $row[0];?>">
                                                        <td class="text-center"><?php echo $n;?></td>
                                                        <td class="text-center"><?php echo $row[1];?></td>
                                                        <td class="text-center"><?php echo $row[5];?></td>
                                                        <td class="text-center"><?php echo $row[2];?></td>
                                                        <td class="text-center"><?php echo $row[3];?></td>
                                                        <td class="text-center"><?php echo $row[4];?></td>
                                                        <td class="text-center">
                                                            <button id="btn_eliminar_<?php echo $row[0];?>"
                                                                onclick="eliminar_activo_mantenimiento(<?php echo $row[0];?>);"
                                                                class="btn btn-danger" title="Eliminar activo"
                                                                data-toggle="tooltip"><i
                                                                    class="fa fa-times-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <?php
                                if($row_datos["activo"] == 2){
                                    //esta pendiente la verificación
                                    ?>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="fecha_cierre_a" class="control-label">Fecha de cierre de
                                            mantenimiento: </label>
                                        <input type="text" name="" id=""
                                            value="<?php echo $row_datos["fecha_cierre_mantenimiento"];?>" readonly
                                            class="form-control">
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label for="comentarios_c" class="control-label">Comentarios de cierre: </label>
                                        <textarea name="" id="" cols="30" rows="5" style="resize:none;" readonly
                                            class="form-control"><?php echo $row_datos["comentarios_cierre"];?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="text-center text-primary"><b><strong>Esperando liberación del
                                                    mantenimiento</strong></b></p>
                                    </div>
                                </div>
                                <?php
                                }
                                else{

                                }
                                ?>
                                <form action="#" id="frmCerrarMantenimiento" enctype="multipart/form-data">
                                    <input type="hidden" name="id_plan" id="id_plan"
                                        value="<?php echo $id_plan_individual;?>">
                                    <div id="row_cerrar" class="hide">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-center">Cerrar mantenimiento</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="fecha_cierre" class="control-label">Fecha de cierre:
                                                </label>
                                                <input type="text" name="fecha_cierre" fechas required id="fecha_cierre"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="conclusiones" class="control-label">Conclusiones: </label>
                                                <textarea name="conclusiones" id="conclusiones" style="resize: none;"
                                                    cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="evidencias" class="control-label">Evidencias del
                                                    mantenimiento: </label>
                                                <input type="file" name="evidencias[]" multiple class="form-control"
                                                    id="evidencias">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success btn-block">Guardar y dar
                                                    por finalizado mantenimiento</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <?php
                                if($row_datos["activo"] == 0){
                                    ?>
                                <div id="row_cerrado">
                                <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="fecha_cierre_a" class="control-label">Fecha de cierre de mantenimiento: </label>
                                            <input type="text" name="" id="" value="<?php echo $row_datos["fecha_cierre_mantenimiento"];?>" readonly class="form-control">
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label for="comentarios_c" class="control-label">Comentarios de cierre: </label>
                                            <textarea name="" id="" cols="30" rows="5" style="resize:none;" readonly class="form-control"><?php echo $row_datos["comentarios_cierre"];?></textarea>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="fecha_liberacion" class="control-label">Fecha de liberación: </label>
                                            <input type="text" name="" value="<?php echo $row_datos["fecha_liberacion"];?>" readonly id="fecha_liberacion" class="form-control">
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <label for="comentarios2" class="control-label">Comentarios del usuario: </label>
                                            <textarea name="" id="" cols="30" rows="5" style="resize:none;" readonly class="form-control"><?php echo $row_datos["comentarios_liberacion"];?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Evidencias</h3>
                                        </div>
                                    </div>
                                    <?php
                                    $n = 0;
                                    $evidencias = $conexion->query("SELECT id_evidencia,
                                    name,
                                    type,
                                    name_random
                                    FROM evidencia_mantenimientos
                                    WHERE id_plan_individual = $id_plan_individual");
                                    while($row_e = $evidencias->fetch(PDO::FETCH_NUM)){
                                        ?>
                                    <a href="descargar.php?e=<?php echo $row_e[3];?>"><?php echo $row_e[1];?></a><br>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                }
                                else{
                                    
                                }
                                ?>

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-7">

                                    </div>
                                    <?php
                                    if($row_datos["activo"] == 1){
                                        ?>
                                    <div class="col-md-2">
                                        <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-info btn-block" id="btn_cerrar"
                                            onclick="cerrar_mantenimiento();">Cerrar mantenimiento</button>
                                    </div>
                                    <?php
                                    }
                                    else{
                                        ?>
                                    <div class="col-md-5">
                                        <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal_action" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content" id="modal_body">

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
    <script src="funciones.js"></script>
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });
    $("[fechas]").datepicker().datepicker("setDate", new Date());
    $('#horas').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $("select").select2({
        width: 'resolve'
    });
    $(document).ready(function() {
        $('[data-toggle=tooltip]').tooltip({
            trigger: "hover"
        });
    });
    </script>
</body>

</html>