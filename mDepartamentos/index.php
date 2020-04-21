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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Listado de departamentos
                                <div class="card-actions">
                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="cuerpo_tabla"
                                        class="table table-hover table-striped table-bordered color-table success-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Departamento</th>
                                                <th class="text-center">Siglas</th>
                                                <th class="text-center">Dirección</th>
                                                <th class="text-center">Descripción</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $n = 0;
                                        $datos = $conexion->query("SELECT id_departamento,departamento,D.siglas,D.descripcion,DI.direccion,D.activo
                                        FROM departamentos as D
                                        INNER JOIN direcciones as DI ON D.id_direccion = DI.id_direccion");
                                        while($row  =$datos->fetch(PDO::FETCH_ASSOC)){
                                            $estado = ($row["activo"] == 1) ? '<a href="estado.php?id='.$row["id_departamento"].'&estado='.$row["activo"].'" class="btn btn-primary btn-sm">Activo</a>':'<a href="estado.php?id='.$row["id_departamento"].'&estado='.$row["activo"].'" class="btn btn-danger btn-sm">Desactivado</a>';
                                            if($row["activo"] == 1){
                                                //si puedo editar
                                                $editar = '<a href="editar.php?id='.$row["id_departamento"].'" class="btn btn-info btn-sm" title="Editar departamento" data-toggle="tooltip"><i class="fa fa-edit"></i> </a>';
                                            }
                                            else{
                                                $editar = '<button class="btn btn-disabled" disabled><i class="fa fa-edit"></i></button>';
                                                
                                            }
                                            $n++;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $n;?></td>
                                                <td class="text-center"><?php echo $row["departamento"];?></td>
                                                <td class="text-center"><?php echo $row["siglas"];?></td>
                                                <td class="text-center"><?php echo $row["direccion"];?></td>
                                                <td class="text-center"><?php echo $row["descripcion"];?></td>
                                                <td class="text-center">
                                                <?php echo $estado;?>
                                                </td>
                                                <td class="text-center"><?php echo $editar;?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="alta.php" class="btn btn-primary">Agregar departamento</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="funciones.js"></script>
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $("[data-toggle=tooltip]").tooltip();

    llenar_tabla();

    <
    ? php
    $resultado = $_GET["resultado"];
    if ($resultado == "exito_imagen") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'La imagen se ha actualizado correctamente.!',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "exito_alta") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'El producto se ha agregado correctamente.!',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "exito_actualizar") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'La información se ha actualizado correctamente.!',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "error_alta") {
        ?
        >
        Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al tratar de agregar el producto, vuelve a intentarlo mas tarde.!',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "error_actualizar") {
        ?
        >
        Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al tratar de actualizar el producto, vuelve a intentarlo mas tarde.!',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "exito_estado") {
        ?
        >
        Swal.fire({
                type: 'success',
                title: 'Exito',
                text: 'Información actualizada correctamente!.',
                timer: 3000
            }) <
            ? php
    } else if ($resultado == "error_estado") {
        ?
        >
        Swal.fire({
                type: 'error',
                title: 'Error',
                text: 'Ha ocurrido un error al tratar de guardar la información, vuelve a intentarlo mas tarde.',
                timer: 3000
            }) <
            ? php
    } ?
    >
    function cambiar_imagen(id) {
        $("#modal_imagen").modal("show");
        $("#id_p_imagen").val(id);
    }
    </script>

</body>

</html>