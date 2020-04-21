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
                <form action="guardar.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <strong><span class="text-white">Agregar acción correctiva</span></strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Dirección
                                                    </strong></b></label>
                                            <select name="id_direccion" id="id_direccion" class="form-control">
                                                <?php
                                                $direcciones = $conexion->query("SELECT id_direccion,direccion
                                                FROM direcciones
                                                WHERE activo = 1");
                                                while($row = $direcciones->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                    <option value="<?php echo $row['id_direccion'];?>"><?php echo $row["direccion"];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Origen:
                                                    </strong></b></label>
                                            <select name="origen" id="origen" required class="form-control">
                                                <?php
                                        $datos = $conexion->query("SELECT id_tipo_accion,nombre
                                        FROM tipo_acciones
                                        WHERE activo = 1");
                                        while($row_datos = $datos->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row_datos['id_tipo_accion'];?>">
                                                    <?php echo $row_datos["nombre"];?></option>
                                                <?php
                                        }
                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>N° de auditoria o revisión:
                                                    </strong></b></label>
                                            <input type="text" name="numero" id="numero" class="form-control" required="">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Fecha de creación:
                                                    </strong></b></label>
                                            <input type="text" name="fecha_creacion" required autocomplete="off" fechas
                                                id="fecha_cierre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="descripcion" class="control-label"><b><strong>Descripción u observación:
                                                    </strong></b></label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="5" required
                                                class="form-control"></textarea>
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
                                            <button type="submit" class="btn btn-success btn-block">Guardar
                                                acción</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
                <!-- Modal -->
                <div id="modal_acciones" class="modal fade" role="dialog">

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
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
        $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        orientation: "bottom"
    });
    $("#origen").on("change",function(e){
       var valor = $("#origen").val();
        if(valor == 1 || valor == 2 || valor == 5){
            //se le asigna un numero
            $("#numero").prop("disabled",false);
            $("#numero").val("");
        }
        else{
            $("#numero").prop("disabled",true);
            $("#numero").val("N/A");
        }
    });
        $("select").select2();
    </script>
</body>

</html>