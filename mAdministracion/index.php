<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
/* include "../sesion/validar_permiso.php"; */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
    .btn-toggle {
        color: #fff;
        font-weight: bold;
        font-size: 20px;
    }

    .span-right {
        position: absolute;
        top: 54%;
        right: 15px;
        margin-top: -7px;
    }

    .span-soporte {
        position: absolute;
        top: 61%;
        right: 15px;
        margin-top: -7px;
    }

    .span-puesto {
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a>
                            </li>
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
                                <div id="accordion">
                                    <?php
                                    //busco las categorias
                                    $categorias = $conexion->query("SELECT
                                    id_categoria_modulo,
                                    nombre_categoria,
                                    descripcion,
                                    icono,
                                    color_borde,
                                    (
                                        SELECT
                                            COUNT(M.id_modulo)
                                        FROM
                                            modulos AS M
                                        INNER JOIN permiso_modulos AS PM ON M.id_modulo = PM.id_modulo
                                        WHERE
                                            PM.permiso != 0
                                        AND M.id_categoria_modulo = CM.id_categoria_modulo
                                        AND PM.id_usuario = $id_usuario_logueado
                                    ) AS modulos
                                FROM
                                    categoria_modulos AS CM
                                WHERE
                                    activo = 1
                                AND (
                                    SELECT
                                        COUNT(M.id_modulo)
                                    FROM
                                        modulos AS M
                                    INNER JOIN permiso_modulos AS PM ON M.id_modulo = PM.id_modulo
                                    WHERE
                                        PM.permiso != 0
                                    AND M.id_categoria_modulo = CM.id_categoria_modulo
                                    AND PM.id_usuario = $id_usuario_logueado
                                ) != 0
                                ORDER BY
                                    nombre_categoria ASC");
                                    while($row_categorias = $categorias->fetch(PDO::FETCH_NUM)){
                                        $id_categoria = $row_categorias[0];
                                        $nombre_categoria = $row_categorias[1];
                                        $descripcion  =$row_categorias[2];
                                        $icono = $row_categorias[3];
                                        $color = $row_categorias[4];
                                        ?>
                                    <div class="card card-outline-<?php echo $color;?>">
                                        <div class="card-header card-primary"
                                            id="categoria_<?php echo $id_categoria;?>">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-toggle" data-toggle="collapse"
                                                    data-target="#panel_<?php echo $id_categoria;?>"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="<?php echo $icono;?>"></i> <?php echo $nombre_categoria;?>
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="panel_<?php echo $id_categoria;?>" class="collapse"
                                            aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <?php
                                            //busco los modulos ligados
                                            $modulos = $conexion->query("SELECT
                                            PM.id_modulo,
                                            nombre_modulo,
                                            carpeta_modulo,
                                            descripcion,
                                            icono,
                                            color,
                                            tipo_color
                                        FROM
                                            modulos AS M
                                        INNER JOIN permiso_modulos AS PM ON M.id_modulo = PM.id_modulo
                                        WHERE
                                            id_categoria_modulo = $id_categoria
                                        AND PM.permiso != 0 AND PM.id_usuario = $id_usuario_logueado");
                                            while($row_modulos = $modulos->fetch(PDO::FETCH_NUM)){
                                                $id_modulo = $row_modulos[0];
                                                $modulo  =$row_modulos[1];
                                                $carpeta = $row_modulos[2];
                                                $descripcion_modulo = $row_modulos[3];
                                                $icono_modulo = $row_modulos[4];
                                                $color_modulo = $row_modulos[5];
                                                $tipo_color = $row_modulos[6];
                                                if($tipo_color == "personalizado"){
                                                    //es un color fuera de clase
                                                    $text_color = "";
                                                    $btn = "btn";
                                                    $style = "style='background:$color_modulo;color:#ffffff;border-color:$color_modulo;'";
                                                }
                                                else{
                                                    $text_color = "card-outline-$color_modulo";
                                                    $style = "";
                                                    $btn = "btn btn-$color_modulo";
                                                }
                                                ?>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="card">
                                                            <img class="rounded-top"
                                                                src="../images/generales/wallpaper-module.jpg"
                                                                alt="Card image cap">
                                                            <div class="card-img-overlay" style="height:110px;">
                                                                <div class="d-flex align-items-center">
                                                                    <!-- <h3
                                                                        class="card-title text-white mb-0 d-inline-block">
                                                                        <?php echo $modulo;?></h3> -->
                                                                    <div class="ml-auto">
                                                                        <!-- <small class="card-text text-white font-weight-light">Sunday 15
                                                            march</small> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body weather-small">
                                                                <div class="row">
                                                                    <div class="col-12 border-right align-self-center">
                                                                        <div class="d-flex">
                                                                            <div class="display-6 text-info"><i
                                                                                    class="<?php echo $icono_modulo;?>"></i>
                                                                            </div>
                                                                            <div class="ml-3">
                                                                                <h5
                                                                                    class="font-weight-light text-info mb-0">
                                                                                    <?php echo $modulo;?>
                                                                                </h5>
                                                                                <small><?php echo $descripcion_modulo;?></small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-right">
                                                                    <a href="" class="btn btn-primary"
                                                                            title="Cambiar imagen del módulo" data-toggle="tooltip"><i
                                                                                class="fa fa-image"></i></a>
                                                                            <a href="" class="btn btn-info"
                                                                            title="Historial de accesos" data-toggle="tooltip"><i
                                                                                class="fa fa-file"></i></a>
                                                                        <a href="../<?php echo $carpeta;?>/index.php" class="btn btn-success"
                                                                            title="Ingresar" data-toggle="tooltip"><i
                                                                                class="fa fa-arrow-right"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                            }
                                            ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                ?>
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
    <script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
    <script src="../js/socket.js"></script>
    <script>
    modulo_actual = "<?php echo $menu;?>";
    global_date = '<?php echo date("Y-m-d H:i:s");?>';
    conect_socket('<?php print session_id();?>', < ? php echo $_SESSION["id_usuario"]; ? > , 'reload', 'web');
    </script>

    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno"); <
    ?
    php
    $resultado = $_GET["resultado"];
    if ($resultado == "exito_actualizacion") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'Tu información se ha guardado correctamente.!',
                timer: 3000
            }) <
            ?
            php
    } ?
    >
    </script>

</body>

</html>