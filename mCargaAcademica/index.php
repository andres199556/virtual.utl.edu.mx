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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">Listado cargas académicas</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table
                                                class="table table-hover table-striped table-condensed table-bordered color-table info-table"
                                                id="tabla_registros">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Nombre</th>
                                                        <th class="text-center">Departamento</th>
                                                        <th class="text-center">Dirección</th>
                                                        <th class="text-center">N° empleado</th>
                                                        <th class="text-center">Correo</th>
                                                        <th class="text-center">Estado general</th>
                                                        <th class="text-center">Editar</th>
                                                        <th class="text-center">Cambiar estado</th>
                                                        <th class="text-center">Opciones</th>
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
                                    <div class="col-md-12">
                                        <div class="" style="float:right;">
                                            <button class="btn btn-default" type="button" data-toggle="modal"
                                                data-target="#modal_masivo"><i class="fa fa-upload text-success"></i>
                                                Subir excel masivo</button>
                                            <a href="alta.php" class="btn btn-default"><i
                                                    class="fa fa-plus text-primary"></i> Agregar trabajador</a>
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
    <!-- Modal -->
    <a href="#" style="display:none;" id="lnkDownload">asdasd</a>
    <div id="modal_masivo" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <form action="" id="frmArchivo" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Realizar carga masiva</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="archivo" class="control-label"><b><strong>Archivo:</strong></b> </label>
                                <input type="file" name="archivo" required id="archivo" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                            Cerrar</button>
                        <a href="../files/templates/layout_docentes.xlsx" download class="btn btn-default"><i
                                class="fa fa-download text-warning"></i>
                            Descargar plantilla</a>
                        <button type="submit" class="btn btn-default" id="btnSubir"><i
                                class="fa fa-upload text-success"></i> Subir
                            archivo</button>
                    </div>
                </div>
            </form>

        </div>
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
    listar_registros();
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(document).on('click', '.link-informacion', function(e) {
        var element = e.target;
        var id = $(element).attr("data-id");
        $.ajax({
            url: "solicitar_llenado.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            }
        }).done(function(success) {
            var resultado = success["resultado"];
            switch (resultado) {
                case "exito":
                    $.toast({
                        heading: success["header"],
                        text: success["mensaje"],
                        icon: 'success',
                        position: 'top-right',
                        loader: true, // Change it to false to disable loader
                        loaderBg: '#9EC600' // To change the background
                    });
            }
        }).fail(function(error) {
            alert("error");
        });
    });
    $(document).on("click", ".link-permisos", function(e) {
        var element = e.target;
        var id = $(element).attr("data-id");
        window.location = "permisos.php?id=" + id;
    });
    $(document).on('click', '.link-password', function(e) {
        var element = e.target;
        var id = $(element).attr("data-id");
        $.ajax({
            url: "change_password.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            }
        }).done(function(success) {
            var resultado = success["resultado"];
            switch (resultado) {
                case "exito":
                    $.toast({
                        heading: success["header"],
                        text: success["mensaje"],
                        icon: 'success',
                        position: 'top-right',
                        loader: true, // Change it to false to disable loader
                        loaderBg: '#9EC600' // To change the background
                    });
            }
        }).fail(function(error) {
            alert("error");
        });
    });

    $(document).on('click', '.link-user-add', function(e) {
        var element = e.target;
        var id = $(element).attr("data-id");
        $.ajax({
            url: "create_samba_account.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            },
            beforeSend: function(antes) {
                $(".btn-opciones-" + id).removeClass("btn-info");
                $(".btn-opciones-" + id).addClass("btn-disabled");
                $(".btn-opciones-" + id).prop("disabled", true);
                $(".btn-opciones-" + id).html(
                    "<i class='fa fa-spin fa-spinner'> </i> Generando cambios . . .");
            }
        }).done(function(success) {
            var resultado = success["resultado"];
            alert(JSON.stringify(success));
            switch (resultado) {
                case "exito":
                    $.toast({
                        heading: "Exito!.",
                        text: success["mensaje"],
                        icon: 'success',
                        position: 'top-right',
                        loader: true, // Change it to false to disable loader
                        loaderBg: '#9EC600' // To change the background
                    });
            }
            $(".btn-opciones-" + id).removeClass("btn-disabled");
            $(".btn-opciones-" + id).addClass("btn-info");
            $(".btn-opciones-" + id).prop("disabled", false);
            $(".btn-opciones-" + id).html("<i class='fa fa-cog'> </i> Opciones");
        }).fail(function(error) {
            alert("error");
        });
    });
    $("#frmArchivo").submit(function(e) {
        var fd = new FormData(document.getElementById("frmArchivo"));
        $.ajax({
            url: "upload_file.php",
            type: "POST",
            dataType: "json",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            beforeSend: function(resultado) {
                $("#btnSubir").prop("disabled", true);
                $("#btnSubir").html("<i class='fa fa-spin fa-spinner'> </i> Subiendo archivo . . ");
            }
        }).done(function(success) {
            console.log(success);
            if (success["resultado"] == "exito_subir") {
                $("#lnkDownload").attr("href", success["link"]);
                $("#lnkDownload").prop("download", true);
                $("#btnSubir").prop("disabled", false);
                var link = document.getElementById("lnkDownload");
                link.download = "Logs de subida";
                link.click();
                $("#modal_masivo").modal("hide");
                $("#btnSubir").html("<i class='fa fa-upload'> </i> Subir archivo");
                listar_registros();
            }
            
        }).fail(function(error) {
            alert("Error");
        });
        e.preventDefault();
        return false;
    })
    </script>
</body>

</html>