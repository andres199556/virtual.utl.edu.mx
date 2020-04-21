<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/class_data_server.php";
$id = $_GET["id"];
$buscar_info = $conexion->query("SELECT direccion_ip,direccion_mac FROM activos_fijos WHERE no_activo_fijo = '$id'");
$row_datos = $buscar_info->fetch(PDO::FETCH_ASSOC);
$direccion_ip = $row_datos["direccion_ip"];
$direccion_mac  =$row_datos["direccion_mac"];
$data_server = new dataServer();
$datos = $data_server->get_data_host($direccion_ip);
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">Datos del dispositivo</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                                <input type="hidden" name="id_activo" value="<?php echo $id;?>" id="id_activo">
                                                <li class="nav-item"> <a class="nav-link disabled" data-toggle="tab"
                                                        href="#home" role="tab"><i class="fa fa-desktop"></i> Equipo: <?php echo $direccion_ip;?>
                                                    </a> </li>
                                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab"
                                                        href="#profile" role="tab"><i class="fa fa-chart-bar"></i> Estadísticas</a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-toggle="tab"
                                                        href="#settings" role="tab"><i class="fa fa-globe"></i> Sitios
                                                        Bloqueados</a> </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <!--second tab-->
                                                <div class="tab-pane active" id="profile" role="tabpanel">
                                                    <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover table-bordered table-striped">
                                                            <thead></thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center"><strong><b>Dirección
                                                                                MAC:</b></strong> </td>
                                                                    <td class="text-center">
                                                                        <?php echo $datos["mac_address"];?></td>
                                                                    <td class="text-center"><strong><b>Sistema
                                                                                Operativo:</b></strong> </td>
                                                                    <td class="text-center"><?php echo $datos["os"];?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><strong><b>Inicio de
                                                                                captura:</b></strong> </td>
                                                                    <td class="text-center">
                                                                        <?php echo date("d-m-Y H:i:s A",$datos['seen.first']);?>
                                                                    </td>
                                                                    <td class="text-center"><strong><b>Fecha final de
                                                                                captura:</b></strong> </td>
                                                                    <td class="text-center">
                                                                        <?php echo date("d-m-Y H:i:s A",$datos['seen.last']);?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><strong><b>Tráfico
                                                                                enviado:</b></strong> </td>
                                                                    <td class="text-center">
                                                                        <?php echo $data_server->formatSizeUnits($datos["tcp_sent"]["bytes"]);?>
                                                                        <i class="fa fa-arrow-up text-danger"></i></td>
                                                                    <td class="text-center"><strong><b>Tráfico
                                                                                recibido:</b></strong> </td>
                                                                    <td class="text-center">
                                                                        <?php echo $data_server->formatSizeUnits($datos["tcp_rcvd"]["bytes"]);?>
                                                                        <i class="fa fa-arrow-down text-info"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-center"><b><strong>Comparativa de
                                                                                ancho
                                                                                de banda:</strong></b> </td>
                                                                    <td class="text-center" colspan=3>
                                                                        <?php
                                                        $suma = $datos["tcp_sent"]["bytes"] + $datos["tcp_rcvd"]["bytes"];
                                                        $total  =$suma;
                                                        $enviado = ($datos["tcp_sent"]["bytes"] * 100) / $total;
                                                        $enviado = number_format($enviado,2);
                                                        $recibido = ($datos["tcp_rcvd"]["bytes"] * 100) / $total;
                                                        $recibido = number_format($recibido,2);
                                                        ?>
                                                                        <div class="progress">
                                                                            <div class="progress-bar active progress-bar-striped bg-danger"
                                                                                title="Enviados (<?php echo $data_server->formatSizeUnits($datos["tcp_sent"]["bytes"]).", ".$enviado."%";?>)"
                                                                                data-toggle="tooltip"
                                                                                style="width: <?php echo $enviado;?>%; height:25px;"
                                                                                role="progressbar"> <span
                                                                                    class=""><b><strong>Enviados
                                                                                            (<?php echo $data_server->formatSizeUnits($datos["tcp_sent"]["bytes"]).", ".$enviado."%";?>)</strong></b></span>
                                                                            </div>
                                                                            <div class="progress-bar active progress-bar-striped bg-info"
                                                                                title="Recibidos (<?php echo $data_server->formatSizeUnits($datos["tcp_rcvd"]["bytes"]).", ".$recibido."%";?>)"
                                                                                data-toggle="tooltip"
                                                                                style="width: <?php echo $recibido;?>%; height:25px;"
                                                                                role="progressbar"> <span
                                                                                    class=""><b><strong>Recibidos
                                                                                            (<?php echo $data_server->formatSizeUnits($datos["tcp_rcvd"]["bytes"]).", ".$recibido."%";?>)</strong></b></span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="settings" role="tabpanel">
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover color-table primary-table table-striped table-sites">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">#</th>
                                                                        <th class="text-center">Tipo de bloqueo</th>
                                                                        <th class="text-center">Filtrado</th>
                                                                        <th class="text-center">Palabra o dominio</th>
                                                                        <th class="text-center">Fecha de creación de regla</th>
                                                                        <th class="text-center">Acción</th>
                                                                        <th class="text-center">Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    //busco los sitios bloqueados
                                                                    $bloqueos = $conexion->query("SELECT BF.id_bloqueo,TB.tipo_bloqueo,es_dominio,string_bloqueo,BF.fecha_hora,BF.activo
                                                                    FROM bloqueo_firewall as BF
                                                                    INNER JOIN tipo_bloqueos as TB ON BF.id_tipo_bloqueo = TB.id_tipo_bloqueo
                                                                    WHERE id_activo_fijo = '$id'");
                                                                    $n = 0;
                                                                    while($row_b = $bloqueos->fetch(PDO::FETCH_ASSOC)){
                                                                        $string = $row_b["string_bloqueo"];
                                                                        $tipo_f = $row_b["es_dominio"];
                                                                        $activo = $row_b["activo"];
                                                                        $accion = ($activo == 1) ? "DENEGAR":"ACEPTAR";
                                                                        $e_c = ($activo == 1) ? "checked":"";
                                                                        if($tipo_f == 1){
                                                                            $icon = "<img src='http://s2.googleusercontent.com/s2/favicons?domain_url=http://$string'/>";
                                                                        }
                                                                        else{
                                                                            $icon = "<i class='fa fa-globe'></i>";
                                                                        }
                                                                        $tipo_filtro = ($row_b["es_dominio"] == 1) ? "Por dominio":"Por palabra";
                                                                        $n++;
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center"><b><strong><?php echo $n;?></strong></b></td>
                                                                            <td class="text-center"><?php echo $row_b["tipo_bloqueo"];?></td>
                                                                            <td class="text-center"><?php echo $tipo_filtro;?></td>
                                                                            <td class="text-center"><?php echo $icon;?> <?php echo $string;?></td>
                                                                            <td class="text-center"><?php echo $row_b["fecha_hora"];?></td>
                                                                            <td class="text-center"><span class="text-accion-<?php echo $row_b['id_bloqueo'];?>"><strong><b><?php echo $accion;?></b></strong></span></td>
                                                                            <td class="text-center">
                                                                                <!-- <button class="btn btn-sm btn-danger" title="Eliminar" data-toggle="tooltip"><i class="fa fa-times"></i></button> -->
                                                                                <input type="checkbox" rule-id="<?php echo $row_b['id_bloqueo'];?>" <?php echo $e_c;?> class="js-switch" data-color="#d63031" data-secondary-color="#00b894" />
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center"></th>
                                                                    <th class="text-center"></th>
                                                                        <th class="text-center"><button class="btn btn-primary btn-block btn-add-rule">Agregar nueva regla de bloqueo</button></th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2">
                                            <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
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
    $(document).on("keypress","#txtString",function(e) {
    if (e.keyCode == 13) {
        $(".btnAddRow").click();
    }
    else{

    }
    });
    $(document).on("click",".btnAddRow",function(e){
        var formD = new FormData();
        formD.append("no_activo_fijo",$("#id_activo").val());
        formD.append("id_tipo_bloqueo",$("#id_tipo_bloqueo").val());
        formD.append("tipo_filtrado",$("#tipo_filtrado").val());
        formD.append("string",$("#txtString").val());
        $.ajax({
            url:"save_rule.php",
            type:"POST",
            dataType:"html",
            data: formD,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            beforeSend:function(antes){
                $(".btnAddRow").html("<i class='fa fa-spin fa-spinner'></i>");
                $(".btnCancelRow").prop("disabled",true);
                $(".btnCancelRow").removeClass("btn-warning");
            }
        }).done(function(exito){
            alert(exito);
        }).fail(function(error){
            alert("Error");
        });
        
    });
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $(".btn-add-rule").on("click",function(e){
        $(this).prop("disabled",true);
        $(this).removeClass("btn-primary");
        $(this).addClass("btn-disabled");
        $.ajax({
            url:"template-add-row.php",
            type:"GET",
            dataType:"html",
            data:null
        }).done(function(exito){
            $(".table-sites tbody").append(exito);
            $(".btnAddRow").tooltip();
            $(".btnCancelRow").tooltip();
            $("#txtString").focus();
        }).fail(function(error){
            alert("assdasasd");
        })
    });
    $(".js-switch").on("change",function(e){
        var elemento = e.target;
        var rule_id = $(elemento).attr("rule-id");
        $.ajax({
            url:"change_rule.php",
            type:"POST",
            dataType:"json",
            data: {'id':rule_id},
            beforeSend:function(antes){
                $(elemento).attr("disabled",true);
                $(".text-accion-"+rule_id).html('<i class="fa fa-spin fa-spinner"></i> <strong><b>Actualizando</b></strong>');
            }
        }).done(function(exito){
            $(elemento).attr("disabled",false);
            var resultado = exito["resultado"];
            var nuevo = exito["nuevo"];
            $(".text-accion-"+rule_id).html('<strong><b>'+nuevo+'</b></strong>');
        }).fail(function(error){
            alert("Error");
        });
    });
    </script>
</body>

</html>