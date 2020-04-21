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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-globe"></i> Reglas de acceso
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
                                                        <th class="text-center">Tipo de regla</th>
                                                        <th class="text-center">Aplica a</th>
                                                        <th class="text-center">Tipo de filtrado</th>
                                                        <th class="text-center">Palabra o dominio</th>
                                                        <th class="text-center">Acciones</th>
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
                                            <button class="btn btn-success btn_alta">Agregar nueva regla</button>
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
            <!-- Modal -->
            <div id="modal_alta" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nueva regla de acceso</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="tipo_bloqueo" class="control-label">Tipo de bloqueo</label>
                                    <select name="tipo_bloqueo" id="tipo_bloqueo" class="form-control">
                                        <?php
                $tipos = $conexion->query("SELECT id_tipo_bloqueo,tipo_bloqueo
                FROM tipo_bloqueos
                WHERE activo = 1");
                while($row_t  =$tipos->fetch(PDO::FETCH_ASSOC)){
                    ?>
                                        <option value="<?php echo $row_t['id_tipo_bloqueo'];?>">
                                            <?php echo $row_t["tipo_bloqueo"];?></option>
                                        <?php
                }
                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="equipo" class="control-label"><strong><b>Equipo:</b></strong> </label>
                                    <select name="equipo" id="equipo" class="form-control">
                                        <?php
                $datos = $conexion->query("SELECT AF.id_activo_fijo,CONCAT(no_activo_fijo,' - ',ME.nombre_marca,' ',AF.modelo) as modelo
                FROM activos_fijos as AF
                INNER JOIN marcas_equipos as ME ON AF.id_marca = ME.id_marca
                WHERE AF.activo = 1");
                while($row  =$datos->fetch(PDO::FETCH_ASSOC)){
                    ?>
                                        <option value="<?php echo $row['id_activo_fijo'];?>">
                                            <?php echo $row["modelo"];?></option>
                                        <?php
                }
                ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="equipo" class="control-label"><strong><b>Grupo de equipos:</b></strong> </label>
                                    <select name="grupo" id="grupo" class="form-control">
                                        <?php
                $datos = $conexion->query("SELECT id_grupo_computadoras,grupo_computadora
                FROM grupos_computadoras
                WHERE activo = 1");
                while($row  =$datos->fetch(PDO::FETCH_ASSOC)){
                    ?>
                                        <option value="<?php echo $row['id_grupos_computadoras'];?>">
                                            <?php echo $row["grupo_computadora"];?></option>
                                        <?php
                }
                ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Generar regla</button>
                        </div>
                    </div>

                </div>
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
    $(document).ready(function() {
        //listar_registros();
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
    $(".btn_alta").on("click", function(e) {
        $("#modal_alta").modal("show");
    });
    $("#equipo").select2({
        "width":'100%'
    });
    $("#grupo").select2({
        "width":'100%'
    });
    </script>
</body>

</html>