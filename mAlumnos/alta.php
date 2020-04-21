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
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Agregar alumno</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="nombre" class="control-label">Nombre: </label>
                                            <input type="text" name="nombre" autofocus required id="nombre"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="paterno" class="control-label">Apellido paterno: </label>
                                            <input type="text" name="paterno" required id="paterno"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="materno" class="control-label">Apellido materno: </label>
                                            <input type="text" name="materno" required id="materno"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento:
                                            </label>
                                            <input type="text" fechas name="fecha_nacimiento" required
                                                id="fecha_nacimiento" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="sexo" class="control-label">Sexo: </label>
                                            <select name="sexo" id="sexo" class="form-control">
                                                <option value="H">Hombre</option>
                                                <option value="M">Mujer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="edo_civil" class="control-label">Estado civil: </label>
                                            <select name="edo_civil" required id="edo_civil" class="form-control">
                                                <option value="Soltero">Soltero</option>
                                                <option value="Casado">Casado</option>
                                                <option value="Viudo">Viudo</option>
                                                <option value="Divorciado">Divorciado</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="direccion" class="control-label">Dirección: </label>
                                            <input type="text" name="direccion" required id="direccion"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="colonia" class="control-label">Colonia: </label>
                                            <input type="text" name="colonia" required id="colonia"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="ciudad" class="control-label">Ciudad: </label>
                                            <input type="text" name="ciudad" required id="ciudad" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="estado" class="control-label">Estado: </label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="Aguascalientes">Aguascalientes</option>

                                                <option value="Baja California">Baja California</option>

                                                <option value="Baja California Sur">Baja California Sur</option>

                                                <option value="Campeche">Campeche</option>

                                                <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>

                                                <option value="Colima">Colima</option>

                                                <option value="Chiapas">Chiapas</option>

                                                <option value="Chihuahua">Chihuahua</option>

                                                <option value="Distrito Federal">Distrito Federal</option>

                                                <option value="Durango">Durango</option>

                                                <option value="Guanajuato">Guanajuato</option>

                                                <option value="Guerrero">Guerrero</option>

                                                <option value="Hidalgo">Hidalgo</option>

                                                <option value="Jalisco">Jalisco</option>

                                                <option value="México">México</option>

                                                <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>

                                                <option value="Morelos">Morelos</option>

                                                <option value="Nayarit">Nayarit</option>

                                                <option value="Nuevo León">Nuevo León</option>

                                                <option value="Oaxaca">Oaxaca</option>

                                                <option value="Puebla">Puebla</option>

                                                <option value="Querétaro">Querétaro</option>

                                                <option value="Quintana Roo">Quintana Roo</option>

                                                <option value="San Luis Potosí">San Luis Potosí</option>

                                                <option value="Sinaloa">Sinaloa</option>

                                                <option value="Sonora">Sonora</option>

                                                <option value="Tabasco">Tabasco</option>

                                                <option value="Tamaulipas">Tamaulipas</option>

                                                <option value="Tlaxcala">Tlaxcala</option>

                                                <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de
                                                    la Llave</option>

                                                <option value="Yucatán">Yucatán</option>

                                                <option value="Zacatecas">Zacatecas</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="pais" class="control-label">País: </label>
                                            <input type="text" value="México" name="pais" required id="pais"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group" id="div_curp">
                                            <label for="curp" class="control-label">CURP: </label>
                                            <input type="text" name="curp" required placeholder="CURP" id="curp"
                                                class="form-control">
                                            <div class="form-control-feedback existe-curp hide"><b><i
                                                        class="fa fa-times-circle"></i> El curp especificado ya
                                                    existe.</b></div>

                                        </div>
                                        <div class="col-md-3 form-group" id="div_rfc">
                                            <label for="rfc" class="control-label">RFC: </label>
                                            <input type="text" name="rfc" id="rfc" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="telefono" class="control-label">Teléfono: </label>
                                            <input type="tel" name="telefono" id="telefono" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="correo" class="control-label">Correo personal: </label>
                                            <input type="email" name="correo" id="correo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Datos escolares</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="matricula" class="control-label">Matricula: </label>
                                            <input type="text" name="matricula" required id="matricula"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="sede" class="control-label">Sede: </label>
                                            <select name="sede" id="sede" class="form-contorl">
                                                <?php
                                                $datos = $conexion->query("SELECT id_sede,sede FROM sedes WHERE activo = 1");
                                                while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                <option value="<?php echo $row["id_sede"];?>"><?php echo $row["sede"];?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="carrera" class="control-label">Carrera: </label>
                                            <select name="carrera" required id="carrera" class="form-control">
                                                <?php
                                                $datos = $conexion->query("SELECT id_carrera,carrera,siglas FROM carreras WHERE activo = 1");
                                                while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                    $id_carrera = $row["id_carrera"];
                                                    $carrera = $row["carrera"];
                                                    $siglas = $row["siglas"];
                                                    ?>
                                                <option value="<?php echo $id_carrera;?>"><?php echo $siglas;?> -
                                                    <?php echo $carrera;?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="correo_i" class="control-label">Correo institucional: </label>
                                            <input type="email" name="correo_i" id="correo_i" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="grupo" class="control-label">Grupo: </label>
                                            <select name="grupo" id="grupo" class="form-control">
                                                <?php
                                                $datos = $conexion->query("SELECT id_grupo,grupo FROM grupos WHERE activo = 1");
                                                while($row = $datos->fetch(PDO::FETCH_ASSOC)){
                                                    ?>
                                                <option value="<?php echo $row["id_grupo"];?>">
                                                    <?php echo $row["grupo"];?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="seguro" class="control-label">Seguro facultativo: </label>
                                            <input type="text" name="seguro" id="seguro" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="tutor" class="control-label">Nombre del padre o tutor: </label>
                                            <input type="text" name="tutor" id="tutor" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="demo-checkbox">
                                                <input type="checkbox" id="md_checkbox_27"
                                                    class="filled-in chk-col-purple" name="crear_correo" value="1"
                                                    onchange="generar_correo(this);" />
                                                <label for="md_checkbox_27">Generar correo institucional</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="demo-checkbox">
                                                <input type="checkbox" id="md_checkbox_28" name="sin_grupo"
                                                    class="filled-in chk-col-cyan" value="1"
                                                    onchange="cambiar_grupo(this);" />
                                                <label for="md_checkbox_28">El alumno todavía no tiene grupo
                                                    asignado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="float:right;">
                                                <a href="index.php" class="btn btn-default"><i
                                                        class="fa fa-times text-danger"></i> Cancelar</a>
                                                <button type="submit" class="btn btn-default"><i
                                                        class="fa fa-save text-primary"></i> Guardar alumno</button>
                                            </div>
                                        </div>
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