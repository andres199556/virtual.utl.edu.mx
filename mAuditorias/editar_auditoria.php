<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_GET["id"];
if($permiso_acceso != 1){
    header("Location:index.php");
}
$buscar = $conexion->query("SELECT id_auditoria,tipo,alcance,fecha_apertura,fecha_cierre,objetivo,criterio FROM auditorias WHERE id_auditoria = $id");
$existe = $buscar->rowCount();
if($existe == 0){
    header("Location:index.php");
}
else{
    $row_datos = $buscar->fetch(PDO::FETCH_ASSOC);
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
                <form action="actualizar_auditoria.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                    <strong><span class="text-white">Editar auditoría</span></strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="tipo" class="control-label" style="font-weight:bold">Tipo de auditoría: </label>
                                            <select name="tipo_auditoria" id="tipo" class="form-control">
                                                <option value="interna">Interna</option>
                                                <option value="externa">Externa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="alcance" class="control-label" style="font-weight:bold">Alcance de auditoría: </label>
                                            <select name="alcance" id="alcance" class="form-control">
                                                <option value="parcial">Parcial</option>
                                                <option value="completa">Completa</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="fecha_apertura" class="control-label" style="font-weight:bold">Fecha de apertura: </label>
                                            <input type="text" name="fecha_apertura" fechas required id="fecha_apertura" autocomplete="off" value="<?php echo $row_datos["fecha_apertura"];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="fecha_cierre" class="control-label" style="font-weight:bold">Fecha de cierre: </label>
                                            <input type="text" name="fecha_cierre" required fechas id="fecha_cierre" autocomplete="off" value="<?php echo $row_datos["fecha_cierre"];?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="objetivo" class="control-label" style="font-weight:bold">Objetivo: </label>
                                            <textarea name="objetivo" id="objetivo" cols="30" rows="5" required class="form-control"><?php echo $row_datos["objetivo"];?></textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="criterio" class="control-label" style="font-weight:bold">Criterio: </label>
                                            <textarea name="criterio" id="criterio" cols="30" rows="5" required class="form-control"><?php echo $row_datos["criterio"];?></textarea>
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
                                            <button type="submit" class="btn btn-success btn-block">Actualizar auditoria</button>
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
    $("#alcance").val("<?php echo $row_datos["alcance"];?>");
    $("#tipo").val("<?php echo $row_datos["tipo"];?>");
        $("select").select2();
        $("#frmAlta").submit(function(e){
           var apertura = $("#fecha_apertura").val();
           var cierre = $("#fecha_cierre").val();
           if(cierre < apertura){
               alert("La fecha de cierre no puede ser menor a la de apertura");
               $("#fecha_cierre").focus();
               e.preventDefault();
               return false;
           }
           else{

           }
        });
    </script>
</body>

</html>