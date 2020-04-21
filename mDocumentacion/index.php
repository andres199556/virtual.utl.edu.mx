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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="list-group"> 
                                        <?php
                                        if($permiso_acceso == 1){
                                            ?>
                                            <a href="alta.php" class="list-group-item"><i class="fa fa-plus"></i> Agregar documento</a> 
                                            <?php
                                        }
                                        ?>
                                        
                                        <a href="javascript:buscar();" class="list-group-item " id="lstBuscar"><i class="fa fa-search"></i> Buscar documento</a> 
                                        <?php
                                        //busco los tipos de documentos
                                        $tipo_documentos = $conexion->query("SELECT id_tipo_documento,tipo_documento
                                        FROM tipo_documentos
                                        WHERE activo = 1");
                                        while($row_data = $tipo_documentos->fetch(PDO::FETCH_NUM)){
                                            $tipo = $row_data[0];
                                            if($tipo != 8){
                                                ?>
                                                <a href="javascript:seleccionar_tipo(<?php echo $row_data[0];?>,'<?php echo $row_data[1];?>');" class="list-group-item lista_<?php echo $row_data[0];?>"><i class="fa fa-file"></i> <?php echo $row_data[1];?></a> 
                                                <?php   
                                            }
                                            else{
                                                if($permiso_acceso == 1){
                                                    ?>
                                            <a href="javascript:seleccionar_tipo(<?php echo $row_data[0];?>,'<?php echo $row_data[1];?>');" class="list-group-item lista_<?php echo $row_data[0];?>"><i class="fa fa-file"></i> <?php echo $row_data[1];?></a> 
                                            <?php
                                                }
                                                else{
                                                    
                                                }
                                            }
                                        }
                                        ?>
                                        <a href="control_documentos.php" class="list-group-item "><i class="fa fa-folder"></i> Solicitudes</a> 
                                    </div>
                                </div>
                                <div class="col-md-9 col-buscar hide">
                                    <form action="" id="frmBuscar">
                                        <div class="card card-outline-info">
                                            <div class="card-header">
                                                <h4 class="m-b-0 text-white"><i class="fa fa-search"></i> Buscar documento</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label for="criterio" class="control-label">Criterio a buscar: </label>
                                                        <input type="text" name="criterio" required id="criterio" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <label for="" class="control-label">Coincidir con los siguientes valores: </label><br>
                                                        <div class="form-control">
                                                            <input type="checkbox" checked name="filtros[]" id="titulo" value="titulo" class="chk-col-teal">
                                                            <label for="titulo">Título</label>
                                                            <input type="checkbox" name="filtros[]" value="comentarios" id="comentarios" class="form-control">
                                                            <label for="comentarios">Comentarios</label>
                                                            <input type="checkbox" name="filtros[]" value="DI.direccion" id="direccion" class="form-control">
                                                            <label for="direccion">Dirección</label>
                                                            <input type="checkbox" name="filtros[]" id="tipo_documento" value="TD.tipo_documento" class="form-control">
                                                            <label for="tipo_documento">Tipo de documento</label>
                                                            <input type="checkbox" name="filtros[]" id="codigo" class="form-control" value="codigo">
                                                            <label for="codigo">Código</label>
                                                            <input type="checkbox" name="filtros[]" id="responsable" class="form-control" value="responsable">
                                                            <label for="responsable">Responsable</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-8">

                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-block btn-danger">Cancelar</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="submit" class="btn btn-block btn-success" id="btnBuscarFiltro"><i class="fa fa-search"></i> Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-9 col-normal">
                                        <div class="card card-outline-inverse">
                                            <div class="card-header">
                                                <h4 class="m-b-0 text-white">Seleccionar dirección</h4></div>
                                            </div>
                                            <div class="card-body">
                                                <form action="" class="form-inline">
                                                <div class="row hide" id="row_buscar_documentos">
                                                    <div class="col-md-12 form-group">
                                                        <label for="direccion" class="control-label">Dirección: </label> &nbsp;
                                                        <select name="" id="id_direccion" disabled class="form-control">
                                                            
                                                        </select>&nbsp;
                                                        <button class="btn btn-success" type="button" id="btnSeleccionarDireccion" onclick="buscar_departamentos();"><i class="fa fa-check"></i> Seleccionar</button>
                                                        <label for="direccion" class="control-label">Depto: </label> &nbsp;
                                                        <select name="" id="id_departamento" disabled class="form-control">
                                                            
                                                        </select>&nbsp;
                                                        <button class="btn btn-success btm-sm hide" id="btnSeleccionarDepartamento" type="button" onclick="buscar_documentos();"><i class="fa fa-search"></i> Buscar</button>
                                                    </div>
                                                </div>
                                                </form>
                                                <div class="row row_error hide">
                                                    <div class="col-md-12">
                                                        <p class="text-center text-danger"><b><strong><span class="texto-error"></span></strong></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                
                                            </div>
                                        </div>
                                
                                
                                
                                
                                
                                </div>
                                <br><br>
                                     <div id="resultado_documentos">
                                     
                                     <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table tabla_documentos table-bordered table-striped table-hover color-table info-table table-condensed">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center th-contador">#</th>
                                                                                <th class="text-center th-codigo">Código</th>
                                                                                <th class="text-center">Título</th>
                                                                                <th class="text-center">Versión</th>
                                                                                <th class="text-center">Comentarios</th>
                                                                                <th class="text-center">Fecha de vigencia</th>
                                                                                <th class="text-center">Responsable</th>
                                                                                <th class="text-center">Acciones</th>
                                                                                <?php 
                                                                                if($permiso_acceso == 1){
                                                                                    ?>
                                                                                    <th class="text-center"></th>
                                                                                    <th class="text-center"></th>
                                                                                    <th class="text-center"></th>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="registros">
                                                                            
                                                                        </tbody>
                                                                        <tfoot></tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                        </div>
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
    <!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->
  
<script src="funciones.js"></script>


    <script type="text/javascript">
    var div_buscar = false;
    permiso = <?php echo $permiso_acceso;?>;
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
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
    function buscar(){
        $("#lstBuscar").addClass("active");
        $(".col-buscar").removeClass("hide");
        $(".col-normal").addClass("hide");
        $("#criterio").focus();
    }
    $("#frmBuscar").submit(function(e){
        $("#btnBuscarFiltro").prop("disabled",true);
        $("#btnBuscarFiltro").removeClass("btn-success");
        $("#btnBuscarFiltro").html("<i class='fa fa-spinner fa-spin'></i> Buscando");
        $.ajax({
            url:"buscar_filtro.php",
            type:"POST",
            dataType:"html",
            data:$(this).serialize()
        }).done(function(success){
            if(div_buscar == false){
                $('.th-codigo').before('<th class="text-center">Dirección</th><th class="text-center">Departamento</th><th class="text-center">Tipo de documento</th><th class="text-center">Coincidencia</th>');
            }
            else{

            }
            div_buscar = true;
            if ( $.fn.dataTable.isDataTable( '.tabla_documentos' ) ) {
                $('.tabla_documentos').DataTable().destroy();
                $('.tabla_documentos').DataTable().clear().destroy();
            //crear_tabla();
            $("#registros").html(success);
            var table = $('.tabla_documentos').DataTable( {
              "language": {
                      "url": "../assets/plugins/datatables/media/js/Spanish.json"
              }
            });
            $(".tabla_documentos").removeClass("dataTable");
            $( table.table().header()).addClass( 'th-header' );    
            }
            else{
                $("#registros").html(success);
                var table = $('.tabla_documentos').DataTable( {
              "language": {
                      "url": "../assets/plugins/datatables/media/js/Spanish.json"
              }
            });
            $(".tabla_documentos").removeClass("dataTable");
            $( table.table().header()).addClass( 'th-header' );    
            }
            $("#btnBuscarFiltro").prop("disabled",false);
        $("#btnBuscarFiltro").addClass("btn-success");
        $("#btnBuscarFiltro").html("<i class='fa fa-search'></i> Buscar");
        });
        e.preventDefault();
        return false;
    });
    </script>
    
</body>
</html>