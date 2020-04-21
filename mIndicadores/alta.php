<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if($permiso_acceso != 1){
    header("Location:index.php");
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
                
                <form action="guardar.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white"><i class="fa fa-chart-bar"></i> Agregar indicador</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="direccion" class="control-label">Dirección: </label>
                                            <select name="id_direccion" id="direccion" class="form-control">
                                                <?php
                                                $data = $conexion->query("SELECT id_direccion,direccion
                                                FROM direcciones
                                                WHERE activo = 1");
                                                while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <option value="<?php echo $row_data[0];?>"><?php echo $row_data[1];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="departamento" class="control-label">Departamento: </label>
                                            <select name="id_departamento" id="departamento" class="form-control">
                                                <?php
                                                $data = $conexion->query("SELECT id_departamento,departamento
                                                FROM departamentos
                                                WHERE activo = 1");
                                                while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <option value="<?php echo $row_data[0];?>"><?php echo $row_data[1];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="proceso" class="control-label">Proceso: </label>
                                            <select name="id_proceso" id="proceso" class="form-control">
                                                <?php
                                                $data = $conexion->query("SELECT id_proceso,proceso
                                                FROM procesos
                                                WHERE activo = 1");
                                                while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <option value="<?php echo $row_data[0];?>"><?php echo $row_data[1];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label">Título del indicador: </label>
                                            <input type="text" name="titulo" required id="titulo" class="form-control" placeholder="Título">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="clave" class="control-label">Clave: </label>
                                            <input type="text" name="clave" placeholder="Clave" required id="clave" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="frecuencia" class="control-label">Frecuencia del indicador: </label>
                                            <select name="id_frecuencia" id="frecuencia" class="form-control">
                                                <?php
                                                $frecuencias = $conexion->query("SELECT id_frecuencia,frecuencia,meses
                                                FROM frecuencia_indicadores
                                                WHERE activo = 1");
                                                while($row_f = $frecuencias->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <option value="<?php echo $row_f[0];?>"><?php echo $row_f[1];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                            <div class="col-md-3 form-group">
                                                <label for="autor" class="control-label">Responsable del indicador: </label>
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
                                            <div class="col-md-3 form-group">
                                                <label for="fecha_inicio" class="control-label">Fecha de inicio del indicador: </label>
                                                <input type="text" name="fecha_inicio" required fechas id="fecha_inicio" class="form-control">
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="unidades" class="control-label">Tipo de unidad</label>
                                            <select name="id_unidad" id="unidades" class="form-control">
                                                <?php
                                                $unidades = $conexion->query("SELECT id_unidad,unidad,simbolo
                                                FROM unidades_indicador
                                                WHERE activo = 1");
                                                while($row_f = $unidades->fetch(PDO::FETCH_NUM)){
                                                    ?>
                                                    <option value="<?php echo $row_f[0];?>"><?php echo $row_f[1];?> (<?php echo $row_f[2];?>)</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="meta" class="control-label">Meta: </label>
                                            <input type="number" name="meta" required id="meta" class="form-control">
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
   $("select").select2();
   $("[fechas]").datepicker({
       format:"yyyy-mm-dd",
       autoclose:true,
       clearBtn:true,
       language:'es'
   });
    </script>
</body>
</html>