<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if($permiso_acceso != 1){
    header("Location:index.php");
}
if(!isset($_GET["id"])){
    header("Location:index.php");
}
else{
    $id = $_GET["id"];
    if($id == "" || $id == null){
        header("Location:index.php");
    }
    else{
        $documento = $conexion->query("SELECT
        D.codigo,
        DI.direccion,
        DE.departamento,
        P.proceso,
        TD.tipo_documento,
        (
            SELECT
                DD.version
            FROM
                detalle_documentos AS DD
            WHERE
                DD.id_documento = $id
            AND DD.activo = 1
        ) AS version
    FROM
        documentos AS D
    INNER JOIN direcciones AS DI ON D.id_direccion = DI.id_direccion
    INNER JOIN departamentos AS DE ON D.id_departamento = DE.id_departamento
    INNER JOIN procesos AS P ON P.id_proceso = D.id_proceso
    INNER JOIN tipo_documentos AS TD ON D.id_tipo_documento = TD.id_tipo_documento
    WHERE
        D.id_documento = $id");
        $existe = $documento->rowCount();
        if($existe == 0){

        }
        else{
            $row_d = $documento->fetch(PDO::FETCH_ASSOC);
            $version = $row_d["version"] + 1;
        }
    }
}
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
                
                <form action="actualizar_version.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_documento" value="<?php echo $id;?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-inverse">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white"><i class="mdi mdi-cube"></i> Actualizar versión</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="direccion" class="control-label">Dirección: </label>
                                            <input type="text" name="direccion" readonly value="<?php echo $row_d['direccion'];?>" id="direccion" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="departamento" class="control-label">Departamento: </label>
                                            <input type="text" name="departamento" readonly value="<?php echo $row_d['departamento'];?>" id="departamento" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="proceso" class="control-label">Proceso: </label>
                                            <input type="text" name="proceso" readonly value="<?php echo $row_d['proceso'];?>" id="proceso" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                                <label for="tipo_documento" class="control-label">Tipo de documento: </label>
                                                <input type="text" name="tipo_documento" readonly value="<?php echo $row_d['tipo_documento'];?>" id="tipo_documento" class="form-control">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="autor" class="control-label">Autor: </label>
                                                <select name="id_responsable" id="autor" class="form-control">
                                                    <?php
                                                    $data = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as responsable
                                                    FROM usuarios as U
                                                    INNER JOIN trabajadores as T ON U.id_persona = T.id_persona
                                                    INNER JOIN personas as P ON T.id_persona = P.id_persona
                                                    WHERE T.activo = 1 AND U.activo = 1");
                                                    while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                        ?>
                                                        <option value="<?php echo $row_data[0];?>"><?php echo $row_data[1];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                    <label for="codigo" class="control-label">Código: </label>
                                                    <input type="text" name="codigo" value="<?php echo $row_d['codigo'];?>" readonly required id="codigo" class="form-control">
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                                    <label for="titulo" class="control-label">Título: </label>
                                                    <input type="text" name="titulo" required id="titulo" autofocus class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                                    <label for="vigencia" class="control-label">Fecha de vigencia: </label>
                                                    <input type="text" name="fecha_vigencia" required id="vigencia" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                                    <label for="version" class="control-label">Nº de versión: </label>
                                                    <input type="number" min=0 name="version" readonly required id="version" value=<?php echo $version;?> class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6 form-group">
                                                        <label for="documento" class="control-label">Documento: </label>
                                                        <input type="file" required name="documento" id="documento" class="dropify">
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="comentarios" class="control-label">Comentarios: </label>
                                                        <textarea name="comentarios" id="comentarios" cols="30" rows="5" class="form-control"></textarea>
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
                                                                                            <button type="submit" class="btn btn-primary btn-block">Actualizar versión</button>
                                                                                        </div>
                                                                                    </div>
                                </div>
                            </div>                                                                                                </div>
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
    <script>
         // Basic

// Translated
$('.dropify').dropify({
    messages: {
        default: 'Arrastra o haz clic para seleccionar el documento.',
        replace: 'Arrastra o haz clic para seleccionar para remplazar.',
        remove: 'Eliminar',
        error: 'Ha ocurrido un error al seleccionar el archivo.'
    },
    tpl: {
        wrap:            '<div class="dropify-wrapper"></div>',
        loader:          '<div class="dropify-loader"></div>',
        message:         '<div class="dropify-message"><span class="fa fa-cloud-upload-alt fa-5x text-success" /> <p class="text-center text-success"><b><strong>{{ default }}</strong></b></p></div>',
        preview:         '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
        filename:        '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
        clearButton:     '<button type="button" class="dropify-clear">{{ remove }}</button>',
        errorLine:       '<p class="dropify-error">{{ error }}</p>',
        errorsContainer: '<div class="dropify-errors-container"><ul></ul></div>'
    }
});

// Used events
var drEvent = $('#input-file-events').dropify();

drEvent.on('dropify.beforeClear', function(event, element) {
    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
});

drEvent.on('dropify.afterClear', function(event, element) {
    alert('File deleted');
});

drEvent.on('dropify.errors', function(event, element) {
    console.log('Has Errors');
});

var drDestroy = $('#input-file-to-destroy').dropify();
drDestroy = drDestroy.data('dropify')
$('#toggleDropify').on('click', function(e) {
    e.preventDefault();
    if (drDestroy.isDropified()) {
        drDestroy.destroy();
    } else {
        drDestroy.init();
    }
})

    </script>
</body>
</html>