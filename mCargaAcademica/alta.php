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
                <form action="guardar.php" method="post" id="frmAlta">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="card-title text-white">Agregar carga académica</h4>
                    </div>
                    <div class="card-body">
                        
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="docente" class="control-label">Docente: </label>
                                    <select name="docente" id="docente" class="form-control">
                                        <?php
                            $docentes = $conexion->query("SELECT T.id_trabajador, CONCAT(P.ap_paterno,' ',P.ap_materno,' ',P.nombre) as docente FROM trabajadores as T
                            INNER JOIN personas as P ON T.id_persona = P.id_persona
                            WHERE T.activo = 1 AND P.activo = 1 AND T.id_tipo_trabajador = 2
                            ORDER BY P.ap_paterno ASC");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                        <option value="<?php echo $row['id_trabajador'];?>">
                                            <?php echo $row['docente'];?>
                                        </option>
                                        <?php
                            }
                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="docente" class="control-label">Materia: </label>
                                    <select name="materia" id="materia" class="form-control">
                                        <?php
                                $docentes = $conexion->query("SELECT M.id_materia,CONCAT(C.siglas,' - ',M.materia) as materia
                            FROM materias as M
                            INNER JOIN carreras as C ON M.id_carrera = C.id_carrera
                            WHERE M.activo = 1");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                        <option value="<?php echo $row['id_materia'];?>"><?php echo $row['materia'];?>
                                        </option>
                                        <?php
                            }
                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="docente" class="control-label">Carrera: </label>
                                    <select name="carrera" id="carrera" class="form-control">
                                        <?php
                            $docentes = $conexion->query("SELECT id_carrera,carrera FROM carreras WHERE activo = 1");
                            while($row = $docentes->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                        <option value="<?php echo $row['id_carrera'];?>"><?php echo $row['carrera'];?>
                                        </option>
                                        <?php
                            }
                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="grupo" class="control-label">Grupo: </label>
                                    <select name="grupo" id="grupo" class="form-control">
                                        <?php
                                        $data = $conexion->query("SELECT id_grupo,grupo FROM grupos WHERE activo = 1");
                                        while($row = $data->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?php echo $row['id_grupo'];?>"><?php echo $row["grupo"];?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="turno" class="control-label">Turno: </label>
                                    <select name="turno" id="turno" class="form-control">
                                        <option value="M">Matutino</option>
                                        <option value="V">Vespertino</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="float:right;">
                                <a href="index.php" class="btn btn-default"><i class="fa fa-times text-danger"></i> Regresar</a>
                                <button type="button" class="btn btn-default"><i class="fa fa-save text-info"></i> Generar carga</button>
                            </div>
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
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");

    $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });
    $("[fechas]").datepicker().datepicker("setDate", new Date());
    $("select").select2({
        width: "100%"
    });
    $("#frmAlta").submit(function(e) {
        $.ajax({
            url: "guardar.php",
            type: "POST",
            dataType: "html",
            data: $(this).serialize()
        }).done(function(success) {
            alert(success);
            var resultado = success["resultado"];
            if (resultado == "existe_curp") {
                //el curp ya existe
                $("#div_curp").addClass("has-danger");
                $(".existe-curp").removeClass("hide");
                $("#curp").focus();
            } else if (resultado == "existe_correo") {
                //el curp ya existe
                $("#div_correo").addClass("has-danger");
                $(".existe-correo").removeClass("hide");
                $("#correo").focus();
            } else if (resultado == "existe_numero") {
                //el curp ya existe
                $("#div_numero").addClass("has-danger");
                $(".existe-numero").removeClass("hide");
                $("#no_empleado").focus();
            } else if (resultado == "exito_alta") {
                //si se registro
                alert("asdasd");
            }
        }).fail(function(error) {
            alert(error);
        });
        e.preventDefault();
        return false;
    });

    function generar_correo(elemento) {
        var estado = $(elemento).prop("checked");
        (estado == true) ? $("#correo_i").prop("readonly", true): $("#correo_i").prop("readonly", false);
    }

    function cambiar_grupo(elemento) {
        var estado = $(elemento).prop("checked");
        (estado == true) ? $("#grupo").prop("disabled", true): $("#grupo").prop("disabled", false);
    }
    </script>
</body>

</html>