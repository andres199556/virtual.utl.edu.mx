<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if($permiso_acceso != 1){
    header("Location:index.php");
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">Listado de indicadores</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                                <?php
                                            $array_direcciones = array();
                                            //busco las direcciones
                                            if($permiso_acceso == 1){
                                                $qry = "SELECT D.id_direccion,
                                                D.direccion
                                                FROM indicadores as I
                                                INNER JOIN direcciones as D ON I.id_direccion = D.id_direccion
                                                WHERE I.activo = 0
                                                GROUP BY D.id_direccion";
                                            }
                                            else{
                                                $qry  ="SELECT
                                                D.id_direccion,
                                                D.direccion
                                            FROM
                                                indicadores AS I
                                            INNER JOIN direcciones AS D ON I.id_direccion = D.id_direccion
                                            AND (
                                                SELECT
                                                    T.id_direccion
                                                FROM
                                                    usuarios AS U
                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                INNER JOIN trabajadores AS T ON P.id_persona = T.id_persona
                                                WHERE
                                                    U.id_usuario = $id_usuario_logueado
                                            ) = I.id_direccion
                                            WHERE I.activo = 0
                                            GROUP BY D.id_direccion";
                                            }
                                            $direcciones = $conexion->query($qry);
                                            $n = 0;
                                            while($row = $direcciones->fetch(PDO::FETCH_ASSOC)){
                                                $class = ($n == 0) ? "active":"";
                                                array_push($array_direcciones,$row["id_direccion"]);
                                                ?>
                                                <li class="nav-item"> <a class="nav-link <?php echo $class;?> show"
                                                        data-toggle="tab"
                                                        href="#direccion_<?php echo $row['id_direccion'];?>" role="tab"
                                                        aria-selected="true"><?php echo $row["direccion"];?></a> </li>
                                                <?php
                                                $n++;
                                            }
                                            $n = 0;
                                            ?>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <?php
                                            $contador = 0;
                                            foreach($array_direcciones as $id_direccion){
                                                $class = ($n == 0) ? "active":"";
                                                $show = ($n == 0) ? "show":"";
                                                    ?>
                                                <div class="tab-pane <?php echo $class;?> <?php echo $show;?>"
                                                    id="direccion_<?php echo $id_direccion;?>" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="card">
                                                                <div class="card-header">

                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table
                                                                            class="table table-hover table-striped table-condensed table-bordered color-table info-table"
                                                                            id="tabla_registros">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">#</th>
                                                                                    <th class="text-center">Clave</th>
                                                                                    <th class="text-center">Título</th>
                                                                                    <th class="text-center">Dirección
                                                                                    </th>
                                                                                    <th class="text-center">Frecuencia
                                                                                    </th>
                                                                                    <th class="text-center">Responsable
                                                                                    </th>
                                                                                    <?php
                                                                                        if($permiso_acceso == 1){
                                                                                            ?>
                                                                                    <th class="text-center">Activar
                                                                                    </th>
                                                                                    <?php
                                                                                        }
                                                                                        else{

                                                                                        }
                                                                                        ?>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody
                                                                                id="cuerpo_direccion_<?php echo $id_direccion;?>">
                                                                                <?php
                                                                                //busco los indicadores
                                                                                if($permiso_acceso == 1){
                                                                                    #administrador
                                                                                    $qry = "SELECT
                                                                                    id_indicador,
                                                                                    I.clave,
                                                                                    I.titulo,
                                                                                    D.direccion,
                                                                                    FI.frecuencia,
                                                                                    CONCAT(
                                                                                        P.nombre,
                                                                                        ' ',
                                                                                        P.ap_paterno,
                                                                                        ' ',
                                                                                        P.ap_materno
                                                                                    ) AS responsable
                                                                                FROM
                                                                                    indicadores AS I
                                                                                INNER JOIN direcciones AS D ON I.id_direccion = D.id_direccion
                                                                                INNER JOIN frecuencia_indicadores AS FI ON I.id_frecuencia = FI.id_frecuencia
                                                                                INNER JOIN usuarios AS U ON I.id_responsable = U.id_usuario
                                                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                                                WHERE
                                                                                    I.id_direccion = $id_direccion AND I.activo = 0";
                                                                                }
                                                                                else{
                                                                                    $qry = "SELECT
                                                                                    id_indicador,
                                                                                    I.clave,
                                                                                    I.titulo,
                                                                                    D.direccion,
                                                                                    FI.frecuencia,
                                                                                    CONCAT(
                                                                                        P.nombre,
                                                                                        ' ',
                                                                                        P.ap_paterno,
                                                                                        ' ',
                                                                                        P.ap_materno
                                                                                    ) AS responsable
                                                                                FROM
                                                                                    indicadores AS I
                                                                                INNER JOIN direcciones AS D ON I.id_direccion = D.id_direccion
                                                                                INNER JOIN frecuencia_indicadores AS FI ON I.id_frecuencia = FI.id_frecuencia
                                                                                INNER JOIN usuarios AS U ON I.id_responsable = U.id_usuario
                                                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                                                WHERE
                                                                                    I.id_direccion = $id_direccion AND I.id_responsable = $id_usuario_logueado AND I.activo = 0";
                                                                                }
                                                                                    $indicadores = $conexion->query($qry);
                                                                                    while ($row_i = $indicadores->fetch(PDO::FETCH_NUM)) {
                                                                                        $contador++; ?>
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        <?php echo $contador; ?></td>
                                                                                    <td class="text-center">
                                                                                        <?php echo $row_i[1]; ?></td>
                                                                                    <td class="text-center"><a
                                                                                            href="indicador.php?id=<?php echo $row_i[0];?>"><?php echo $row_i[2]; ?></a>
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        <?php echo $row_i[3]; ?></td>
                                                                                    <td class="text-center">
                                                                                        <?php echo $row_i[4]; ?></td>
                                                                                    <td class="text-center">
                                                                                        <?php echo $row_i[5]; ?></td>
                                                                                    <?php
                                                                                        if($permiso_acceso == 1){
                                                                                            ?>
                                                                                    <td class="text-center">
                                                                                        <a href="#" data-id="<?php echo $row_i[0];?>"
                                                                                            class="btn btn-success btnActivar"
                                                                                            title="Volver a activar indicador"
                                                                                            data-toggle="tooltip"><i
                                                                                                class="fa fa-check"></i></a>
                                                                                    </td>

                                                                                    <?php
                                                                                        }
                                                                                        else{
                                                                                            
                                                                                        }
                                                                                        ?>

                                                                                </tr>
                                                                                <?php
                                                                                    }
                                                                                    $contador = 0;
                                                                                    ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    $n++;
                                                }
                                                
                                            ?>
                                            </div>
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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span>
                        </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark"
                                        class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a>
                                </li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a>
                                </li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark"
                                        class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark"
                                        class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img"
                                            class="img-circle"> <span>Varun Dhavan <small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img"
                                            class="img-circle"> <span>Genelia Deshmukh <small
                                                class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img"
                                            class="img-circle"> <span>Ritesh Deshmukh <small
                                                class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img"
                                            class="img-circle"> <span>Arijit Sinh <small
                                                class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img"
                                            class="img-circle"> <span>Govinda Star <small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img"
                                            class="img-circle"> <span>John Abraham<small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img"
                                            class="img-circle"> <span>Hritik Roshan<small
                                                class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img"
                                            class="img-circle"> <span>Pwandeep rajan <small
                                                class="text-success">online</small></span></a>
                                </li>
                            </ul>
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
                                            <input type="text" required name="fecha_cierre" id="fecha_cierre"
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
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(document).on("click",".btnActivar",function(e){
        var link = e.target;
        id = $(link).attr("data-id");
        activar(id);
    });
    
    </script>
</body>

</html>