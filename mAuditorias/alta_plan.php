<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if($permiso_acceso != 1){
    header("Location:index.php");
}
$id = $_GET["id"];
if($id == "" || $id == null){
    header("Location:index.php");
}
else{
    //la busco
    $auditoria  =$conexion->query("SELECT id_auditoria FROM auditorias WHERE id_auditoria = $id");
    $existe = $auditoria->rowCount();
    if($existe == 0){
        header("Location:index.php");
    }
    else{

    }
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
                <form action="guardar_plan.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <strong><span class="text-white">Agregar plan de auditoría</span></strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    <input type="hidden" name="id" value="<?php echo $id;?>">
                                        <div class="col-md-3 form-group">
                                            <label for="direccion" class="control-label">Dirección: </label>
                                            <select name="direccion" id="direccion" class="form-control">
                                                <?php
                                            $datos = $conexion->query("SELECT id_direccion,direccion FROM direcciones WHERE activo = 1");
                                            while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                echo "<option value=".$row["id_direccion"].">".$row["direccion"]."</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="proceso" class="control-label">Proceso: </label>
                                            <select name="proceso" id="proceso" class="form-control">
                                                <?php
                                            $datos = $conexion->query("SELECT id_proceso,proceso FROM procesos WHERE activo = 1");
                                            while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                echo "<option value=".$row["id_proceso"].">".$row["proceso"]."</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label">Responsables: </label>
                                            <select name="responsables" id="responsable" class="form-control" multiple>
                                            <?php
                                            $datos = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
                                            FROM usuarios as U
                                            INNER JOIN personas as P ON U.id_persona = P.id_persona
                                            WHERE U.activo = 1 AND P.activo = 1");
                                            while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                echo "<option value=".$row["id_usuario"].">".$row["persona"]."</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="elementos" class="control-label">Elementos a auditar: </label>
                                            <input type="text" name="elementos" required id="elementos" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="fecha_hora" class="control-label">Fecha y hora:</label>
                                            <input type="text" name="fecha_hora" fechas required id="fecha_hora" class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="auditores" class="control-lab">Auditores: </label>
                                            <select name="auditores[]" multiple id="auditores" class="form-control">
                                            <?php
                                            $datos = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
                                            FROM usuarios as U
                                            INNER JOIN personas as P ON U.id_persona = P.id_persona
                                            WHERE U.activo = 1 AND P.activo = 1");
                                            while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                echo "<option value=".$row["id_usuario"].">".$row["persona"]."</option>";
                                            }
                                            ?>
                                            </select>
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
                                            <button type="submit" class="btn btn-success btn-block">Crear
                                                auditoria</button>
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
    /* $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        orientation: "bottom"
    }); */
    $('[fechas]').bootstrapMaterialDatePicker({ format: 'YYYY-MM-DD HH:mm:ss' });

    $("#origen").on("change", function(e) {
        var valor = $("#origen").val();
        if (valor == 1 || valor == 2 || valor == 5) {
            //se le asigna un numero
            $("#numero").prop("disabled", false);
            $("#numero").val("");
        } else {
            $("#numero").prop("disabled", true);
            $("#numero").val("N/A");
        }
    });
    $("select").select2(
        {
            width:"100%"
        }
    );
    $("#frmAlta").submit(function(e) {
        var apertura = $("#fecha_apertura").val();
        var cierre = $("#fecha_cierre").val();
        if (cierre < apertura) {
            alert("La fecha de cierre no puede ser menor a la de apertura");
            $("#fecha_cierre").focus();
            e.preventDefault();
            return false;
        } else {

        }
    });
    </script>
</body>

</html>