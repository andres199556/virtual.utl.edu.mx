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
    .span-cancelar{
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
    }
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
                        <div class="card m-b-0">
                            <!-- .chat-row -->
                            <div class="chat-main-box">
                                <!-- .chat-left-panel -->
                                <div class="chat-left-aside">
                                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                                    <div class="chat-left-inner">
                                        <div class="form-material">
                                        <div class="input-group">
                                            <input type="search" class="form-control p-20" placeholder="Buscar" id="criterio_buscar">
                                            <div class="input-group-append hide" id="cancelar-busqueda">
                                                <span class="span-cancelar" id="">
                                                    <i class="fa fa-times times-cancelar" style="cursor:pointer;" title="Cancelar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        </div>
                                        <ul class="chatonline style-none chat-normal">
                                            <li>
                                                <a href="javascript:void(0)" class="active"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Aarón Barrera <small class="text-success">Conectado</small></span></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class=""><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Xochitl Rodriguez <small class="text-warning">Away</small></span></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Victor Perez <small class="text-danger">Ocupado</small></span></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Roberto Cruz <small class="text-muted">Desconectado</small></span></a>
                                            </li>
                                            <li class="p-20"></li>
                                        </ul>
                                        <ul class="chatonline style-none chat-buscar hide">
                                            <li class="indicador" style="    background-color: rgba(0, 0, 0, .03);
                                                color: rgba(0, 0, 0, .40);
                                                font-size: 13px;
                                                line-height: 24px;
                                                padding: 0 12px;
                                                position: relative;">
                                                <span>Contactos</span>
                                            </li>
                                            <div class="chat-buscar-contactos">
                                                
                                            </div>
                                            
                                            <li class="indicador" style="    background-color: rgba(0, 0, 0, .03);
                                                color: rgba(0, 0, 0, .40);
                                                font-size: 13px;
                                                line-height: 24px;
                                                padding: 0 12px;
                                                position: relative;">
                                                <span>Conversaciones de grupo</span>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class=""><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Xochitl Rodriguez <small class="text-warning">Away</small></span></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Victor Perez <small class="text-danger">Ocupado</small></span></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Roberto Cruz <small class="text-muted">Desconectado</small></span></a>
                                            </li>
                                            <li class="p-20"></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- .chat-left-panel -->
                                <!-- .chat-right-panel -->
                                <div class="chat-right-aside">
                                    <div class="chat-main-header bg-primary">
                                        <div class="p-20 b-b">
                                            <h3 class="box-title text-white label-conversacion">Mensajes</h3>
                                        </div>
                                    </div>
                                    <div class="chat-rbox">
                                        <ul class="chat-list p-20">
                                            <!--chat Row -->
                                            <li>
                                                <div class="chat-img"><img src="../assets/images/users/1.jpg" alt="user" /></div>
                                                <div class="chat-content">
                                                    <h5>James Anderson</h5>
                                                    <div class="box bg-light-info">Lorem Ipsum is simply dummy text of the printing & type setting industry.</div>
                                                </div>
                                                <div class="chat-time">10:56 am</div>
                                            </li>
                                            <!--chat Row -->
                                            <li>
                                                <div class="chat-img"><img src="../assets/images/users/2.jpg" alt="user" /></div>
                                                <div class="chat-content">
                                                    <h5>Bianca Doe</h5>
                                                    <div class="box bg-light-success">It’s Great opportunity to work.</div>
                                                </div>
                                                <div class="chat-time">10:57 am</div>
                                            </li>
                                            <!--chat Row -->
                                            <li class="reverse">
                                                <div class="chat-time">10:57 am</div>
                                                <div class="chat-content">
                                                    <h5>Steave Doe</h5>
                                                    <div class="box bg-light-inverse">It’s Great opportunity to work.</div>
                                                </div>
                                                <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>
                                            </li>
                                            <!--chat Row -->
                                            <li class="reverse">
                                                <div class="chat-time">10:57 am</div>
                                                <div class="chat-content">
                                                    <h5>Steave Doe</h5>
                                                    <div class="box bg-light-inverse">It’s Great opportunity to work.</div>
                                                </div>
                                                <div class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>
                                            </li>
                                            <!--chat Row -->
                                            <li>
                                                <div class="chat-img"><img src="../assets/images/users/3.jpg" alt="user" /></div>
                                                <div class="chat-content">
                                                    <h5>Angelina Rhodes</h5>
                                                    <div class="box bg-light-primary">Well we have good budget for the project</div>
                                                </div>
                                                <div class="chat-time">11:00 am</div>
                                            </li>
                                            <!--chat Row -->
                                        </ul>
                                    </div>
                                    <div class="card-body b-t">
                                        <div class="row">
                                            <div class="col-8">
                                                <textarea placeholder="Escribe tu mensaje" class="form-control b-0"></textarea>
                                            </div>
                                            <div class="col-4 text-right">
                                                <button type="button" class="btn btn-info btn-circle btn-lg"><i class="fas fa-paper-plane"></i> </button>
                                                <button type="button" class="btn btn-success btn-circle btn-lg"  title="Adjuntar archivos" data-toggle="tooltip"><i class="fas fa-paperclip"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- .chat-right-panel -->
                            </div>
                            <!-- /.chat-row -->
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
    $("#criterio_buscar").on('keyup', function (e) {
    if (e.keyCode === 13) {
        buscar_c();
    }
});
    function buscar_c(){
        $("#cancelar-busqueda").removeClass("hide");
        $(".chat-normal").addClass("hide");
        $(".chat-buscar").removeClass("hide");
        var valor = $("#criterio_buscar").val();
        $.ajax({
            url:"buscar_c.php",
            type:"POST",
            dataType:"json",
            data:{'criterio':valor}
        }).done(function(success){
            var c_u = success["cantidad_usuarios"];
            if(c_u != 0){
                $(".chat-buscar-contactos").html("");
                //los voy agregando
                var array_usuarios = success["array_usuarios"];
                for(var i = 0;i<c_u;i++){
                    $id = array_usuarios[i]["id_usuario"];
                    $name = array_usuarios[i]["trabajador"];
                    $id_t = array_usuarios[i]["id_trabajador"];
                    $picture = array_usuarios[i]["fotografia"];
                    var contacto = '<li>'+
                                        '<a href="javascript:ver_conversacion('+$id+');" class=""><img src="../'+$picture+'" alt="user-img" class="img-circle"> <span>'+$name+' <small class="text-success">Conectado</small></span></a>'+
                                    '</li>';
                    $(".chat-buscar-contactos").append(contacto);
                }
            }
        }).fail(function(error){
            alert(error);
        });
    }
    function ver_conversacion(id){
        $.ajax({
            url:"buscar_conversacion.php",
            type:"POST",
            dataType:"json",
            data:{'id_integrante':id}
        }).done(function(success){
            var resultado = success["resultado"];
            if(resultado == "no_existe"){
                var nombre = success["apodo"];
                alert(nombre);
                $(".label-conversacion").html(nombre);
            }
            alert(success);
        }).fail(function(error){
            alert("error");
        });
    }
    $(".times-cancelar").tooltip();
    </script>
    
</body>
</html>