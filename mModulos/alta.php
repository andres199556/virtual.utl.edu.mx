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
    <style>
        .btn-toggle{
            color:#fff;
            font-weight:bold;
            font-size:20px;
        }
        .span-right{
            position: absolute;
            top: 54%;
            right: 15px;
            margin-top: -7px;
        }
        .span-soporte{
            position: absolute;
            top: 61%;
            right: 15px;
            margin-top: -7px;
        }
        .span-puesto{
            position: absolute;
            top: 67%;
            right: 15px;
            margin-top: -7px;
        }
    </style>
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/fontawesome.css">
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/all.css">
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a></li>
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
                
                <form action="guardar.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                        <div class="card card-outline-inverse">
                                                                    <div class="card-header">
                                                                        <h4 class="m-b-0 text-white"><i class="mdi mdi-cube"></i> Agregar módulo</h4></div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-3 form-group">
                                                                                <label for="nombre" class="control-label">Módulo: </label>
                                                                                <input type="text" name="nombre" required id="nombre" class="form-control">
                                                                            </div>
                                                                            <div class="col-md-3 form-group">
                                                                                <label for="id_categoria" class="control-label">Categoría: </label>
                                                                                <select name="id_categoria" id="id_categoria" class="form-control">
                                                                                    <?php
                                                                                    $data = $conexion->query("SELECT id_categoria_modulo,nombre_categoria
                                                                                    FROM categoria_modulos
                                                                                    WHERE activo = 1");
                                                                                    while($row_d = $data->fetch(PDO::FETCH_NUM)){
                                                                                        ?>
                                                                                        <option value="<?php echo $row_d[0];?>"><?php echo $row_d[1];?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3 form-group">
                                                                                        <label for="icono" class="control-label">Icono: </label>
                                                                                        <input type="text" name="icono" id="icono" class="form-control">
                                                                                    </div>
                                                                            <div class="col-md-3 form-group">
                                                                                <label for="carpeta" class="control-label">Carpeta: </label>
                                                                                <input type="text" name="carpeta" required id="carpeta" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                        <div class="col-md-4 form-group">
                                                                                    <label for="descripcion" class="control-label">Descripción: </label>
                                                                                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                                                                            </div>
                                                                            <div class="col-md-4 form-group">
                                                                                    <label for="color" class="control-label">Selecciona el color: </label>
                                                                                    <select name="color" id="color" class="form-control" onchange="cambiar_color(this.value);">
                                                                                        <option value="inverse">Inverse</option>
                                                                                        <option value="success">Success</option>
                                                                                        <option value="danger">Danger</option>
                                                                                        <option value="warning">Warning</option>
                                                                                        <option value="info">Info</option>
                                                                                        <option value="personalizado">Personalizado</option>
                                                                                    </select>
                                                                            </div>
                                                                            <div class="col-md-4 form-group">
                                                                                    <label for="resultado" class="control-label">Muestra de color: </label>
                                                                                    <input type="color" name="color_real" disabled value="#26c6da" id="color_real" class="form-control">
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
                                                                                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
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
    <script type="text/javascript">
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        $("#clave_cfdi").select2({
            language:"es",
            placeholder:"Selecciona la clave CFDI",
            ajax: {
                url: 'buscar_claves.php',
                dataType: 'json',
                type:"POST",
                data: function (params) {
                    return {
                        criterio:params.term
                    };
                },
                processResults:function(response){
                    return{
                        results: $.map(response, function (item) {
                            return {
                                text: item.clave_cfdi+" - " +item.descripcion,
                                id: item.clave_cfdi
                            }
                        })
                    };
                },
                cache:true
            }
        });
        $("#unidad_cfdi").select2({
            language:"es",
            placeholder:"Selecciona la unidad CFDI",
            ajax: {
                url: 'buscar_unidades.php',
                dataType: 'json',
                type:"POST",
                data: function (params) {
                    return {
                        criterio:params.term
                    };
                },
                processResults:function(response){
                    return{
                        results: $.map(response, function (item) {
                            return {
                                text: item.unidad_cfdi+" - " +item.descripcion,
                                id: item.unidad_cfdi
                            }
                        })
                    };
                },
                cache:true
            }
        });
        <?php
                $resultado  =$_GET["resultado"];
                if($resultado == "exito_actualizacion"){
                    ?>
                    Swal.fire({
                        type: 'success',
                        title: 'Exito',
                        text: 'Tu información se ha guardado correctamente.!',
                        timer:3000
                    })
                    <?php
                }
                ?>
         function cambiar_color(valor){
            $("#color_real").prop("disabled",true);
             switch(valor){
                 case "success":
                     $("#color_real").val("#26c6da");
                     break;
                case "inverse":
                    $("#color_real").val("#2f3d4a");
                    break;
                case "info":
                    $("#color_real").val("#1e88e5");
                    break;
                case "danger":
                    $("#color_real").val("#dc3545");
                    break;
                case "warning":
                    $("#color_real").val("#ffc107");
                    break;
                case "personalizado":
                    $("#color_real").prop("disabled",false);
                    break;

             }
         }    
    </script>
    <script src="funciones.js"></script>
</body>
</html>