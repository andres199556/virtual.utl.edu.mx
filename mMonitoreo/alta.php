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
                <form action="guardar.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Agregar monitoreo</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="tipo" class="control-label">Tipo de alta: </label>
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value="1">Por equipo</option>
                                                <option value="2">Por grupo de equipos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row grupo">
                                        <div class="col-md-4 form-group">
                                            <label for="grupo" class="control-label">Grupo de computadoras: </label>
                                            <select name="id_grupo" id="grupo" class="form-control">
                                                <?php
                                            $grupos = $conexion->query("SELECT id_grupo_computadoras,grupo_computadora
                                            FROM grupos_computadoras
                                            WHERE activo = 1");
                                            while($row = $grupos->fetch(PDO::FETCH_ASSOC)){
                                                ?>
                                                <option value="<?php echo $row['id_grupo_computadoras'];?>">
                                                    <?php echo $row["grupo_computadora"];?></option>
                                                <?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row por_equipo">
                                        <div class="col-md-3 form-group">
                                            <label for="id_activo" class="control-label">Equipo: </label>
                                            <select name="id_activo" id="id_activo" class="form-control">
                                                <?php
                                                $direcciones = $conexion->query("SELECT
                                                AF.id_activo_fijo,
                                                AF.no_activo_fijo,
                                            
                                            IF (
                                                AF.id_marca = 2,
                                                'Genérica',
                                                CONCAT(
                                                    ME.nombre_marca,
                                                    ' ',
                                                    AF.modelo
                                                )
                                            ) AS equipo
                                            FROM
                                                activos_fijos AS AF
                                            left JOIN marcas_equipos AS ME ON AF.id_marca = ME.id_marca
                                            WHERE
                                                activo = 1
                                            AND id_consecutivo_activo_fijo = 77
                                            AND AF.id_activo_fijo NOT IN (
                                                SELECT
                                                    M.id_activo
                                                FROM
                                                    monitoreos AS M
                                            )");
                                                while($row_direccion = $direcciones->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_direccion[0]>$row_direccion[1] - $row_direccion[2]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row por_equipo">
                                        <div class="col-md-3 form-group">
                                            <label for="marca" class="control-label">Marca: </label>
                                            <input type="text" name="marca" readonly id="marca" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="modelo" class="control-label">Modelo: </label>
                                            <input type="text" name="modelo" readonly id="modelo" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="serie" class="control-label">N° serie: </label>
                                            <input type="text" name="serie" readonly id="serie" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="mac" class="control-label">Dirección MAC: </label>
                                            <input type="text" name="mac" readonly id="mac" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row por_equipo">
                                        <div class="col-md-3 form-group">
                                            <label for="ip" class="control-label">Dirección IP: </label>
                                            <input type="text" name="ip" readonly id="ip" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="extension" class="control-label">Extensión: </label>
                                            <input type="text" name="" readonly id="extension" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="ubicacion" class="control-label">Ubicación: </label>
                                            <input type="text" name="" readonly id="ubicacion" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label">Responsable: </label>
                                            <input type="text" name="" readonly id="responsable" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-8">

                                        </div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-danger btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
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
    $("#tipo").on("change",function(e){
        cambiar_tipo();
        
    });
    function cambiar_tipo(){
        valor = $("#tipo").val();
        if(valor == 1){
            $(".grupo").hide();
            $(".por_equipo").show();
        }
        else{
            $(".grupo").show();
            $(".por_equipo").hide();
        }
    }
    $("#id_activo").select2();
    $("#grupo").select2();

    function buscar_datos() {
        var valor = $("#id_activo").val();
        $.ajax({
            url: "datos.php",
            type: "POST",
            dataType: "json",
            data: {
                'id_activo': valor
            }
        }).done(function(success) {
            $("#marca").val(success["marca"]);
            $("#modelo").val(success["modelo"]);
            $("#serie").val(success["no_serie"]);
            $("#mac").val(success["direccion_mac"]);
            $("#ip").val(success["direccion_ip"]);
            $("#extension").val(success["ubicacion"]);
            $("#ubicacion").val(success["secundaria"]);
            $("#responsable").val(success["responsable"]);
        }).fail(function(error) {
            alert("Error");
        });
    }
    $("#id_activo").on("change", function(e) {
        buscar_datos();
    });
    buscar_datos();
    cambiar_tipo();
    </script>
</body>

</html>