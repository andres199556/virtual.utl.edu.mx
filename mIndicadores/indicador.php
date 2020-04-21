<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
include "../funciones/strings.php";
$array_data = array();
if($permiso_acceso != 1){
    header("Location:index.php");
}
if(!isset($_GET["id"])){
    header("Location:index.php");
}
else{
    $id_indicador  =$_GET["id"];
    if($id_indicador == "" || $id_indicador == null){

    }
    else{
        //buscar datos
        $indicador = $conexion->query("SELECT I.id_indicador,
        DI.direccion,
        DE.departamento,
        P.proceso,
        I.clave,
        I.titulo,
        I.meta,
        UI.unidad,
        FI.frecuencia,
        I.fecha_inicio,
        CONCAT(PE.nombre,' ',PE.ap_paterno,' ',PE.ap_materno) as responsable,
        YEAR(I.fecha_inicio) as anio_inicio
        FROM indicadores as I
        INNER JOIN direcciones as DI ON I.id_direccion = DI.id_direccion
        INNER JOIN departamentos as DE ON I.id_departamento = DE.id_departamento
        INNER JOIN procesos as P ON I.id_proceso = P.id_proceso
        INNER JOIN usuarios as U ON I.id_responsable = U.id_usuario
        INNER JOIN personas as PE ON U.id_persona = PE.id_persona
        INNER JOIN frecuencia_indicadores as FI ON I.id_frecuencia = FI.id_frecuencia
        INNER JOIN unidades_indicador as UI ON I.id_unidad = UI.id_unidad
        WHERE I.id_indicador = $id_indicador");
        $existe = $indicador->rowCount();
        if($existe == 0){
            //no existe
            header("Location:index.php");
        }
        else{
            $row_indicador = $indicador->fetch(PDO::FETCH_ASSOC);
            $meta = $row_indicador["meta"];
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
    <link href="../assets/plugins/morrisjs/morris.css" rel="stylesheet">
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
                                    <h4 class="m-b-0 text-white"><i class="fa fa-chart-bar"></i> Detalle del indicador</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="direccion" class="control-label"><strong>Dirección:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['direccion'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="departamento" class="control-label"><strong>Departamento:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['departamento'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="proceso" class="control-label"><strong>Proceso:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['proceso'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><strong>Título del indicador:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['titulo'];?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="clave" class="control-label"><strong>Clave:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['clave'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="frecuencia" class="control-label"><strong>Frecuencia del indicador:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['frecuencia'];?>" class="form-control">
                                        </div>
                                            <div class="col-md-3 form-group">
                                                <label for="autor" class="control-label"><strong>Responsable del indicador:</strong> </label>
                                                <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['responsable'];?>" class="form-control">
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label for="fecha_inicio" class="control-label"><strong>Fecha de inicio del indicador:</strong> </label>
                                                <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['fecha_inicio'];?>" class="form-control">
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="unidades" class="control-label"><strong>Tipo de unidad: </strong></label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['unidad'];?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="meta" class="control-label"><strong>Meta:</strong> </label>
                                            <input type="text" name="direccion" id="direccion" disabled value="<?php echo $row_indicador['meta'];?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                            <!-- fechas -->
                                            <?php
                                            $anio_inicio = $row_indicador["anio_inicio"];
                                            $anio_ciclo = $anio_inicio;
                                            $anio_actual = date("Y");
                                            $n = 0;
                                            while($anio_ciclo <=$anio_actual){
                                                $class = ($n == 0) ? "active":"";
                                                ?>
                                                <li class="nav-item"> <a class="nav-link <?php echo $class;?>" data-toggle="tab" data-year="<?php echo $anio_ciclo;?>" href="#anio_<?php echo $anio_ciclo;?>" role="tab" aria-selected="true"><?php echo $anio_ciclo;?></a> </li>
                                                <?php
                                                $n++;
                                                $anio_ciclo++;
                                            }
                                            $fecha_inicio_indicador = $row_indicador["fecha_inicio"];
                                            $fecha_ciclo = $fecha_inicio_indicador;
                                            $fecha_actual = date("Y-m-d");
                                            ?>
                                            </ul>
                                            <div class="tab-content">
                                                <?php
                                                $n = 0;
                                                $anio_ciclo = $anio_inicio;
                                                $c = 0;
                                                while($anio_ciclo <=$anio_actual){
                                                    $array_data[$anio_ciclo] = array();
                                                    $array_data[$anio_ciclo]["month_number"] = array();
                                                    $array_data[$anio_ciclo]["month_name"] = array();
                                                    $array_data[$anio_ciclo]["dates"] = array();
                                                    $array_data[$anio_ciclo]["values"] = array();
                                                    $array_data[$anio_ciclo]["comments"] = array();
                                                    $array_data[$anio_ciclo]["anio"] = $anio_ciclo;
                                                    $class = ($n == 0) ? "active":"";
                                                    $show = ($n == 0) ? "show":"";
                                                    $fecha = "$anio_ciclo-12-31";
                                                    $string_fecha = date_create_from_format('Y-m-d', $fecha);
                                                    $valor_real_fecha_ciclo = strtotime($fecha);
                                                    ?>
                                                    <div ></div>
                                                    <div class="tab-pane <?php echo $class;?> <?php echo $show;?>" id="anio_<?php echo $anio_ciclo;?>" role="tabpanel">
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card card-outline-info">
                                                                    <div class="card-header">
                                                                    <h4 class="m-b-0 text-white text-center"><i class="fa fa-chart-bar"></i> Indicadores <?php echo $anio_ciclo;?></h4>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="bar-chart-<?php echo $anio_ciclo;?>">
                                                                                </div>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="">
                                                                                    <table class="table table-hover table-striped table-bordered color-table info-table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="text-center">#</th>
                                                                                                <th class="text-center">Mes</th>
                                                                                                <th class="text-center">Fecha del indicador</th>
                                                                                                <th class="text-center">Resultados</th>
                                                                                                <th class="text-center">Comentarios</th>
                                                                                                <th class="text-center">Ultima modificación</th>
                                                                                                <th class="text-center">Acciones</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php
                                                                                            $fecha = strtotime($fecha_ciclo);
                                                                                            while($fecha <=$valor_real_fecha_ciclo){
                                                                                                if($c == 0 && $anio_ciclo != $anio_inicio){
                                                                                                    $fecha = strtotime(date("Y-m-d",strtotime($fecha_ciclo."+ 3 month")));     
                                                                                                }
                                                                                                $fecha_ciclo = date("Y-m-d",$fecha);
                                                                                                $month = date("m",$fecha);
                                                                                                $month_name = obtener_nombre_mes($month);
                                                                                                array_push($array_data[$anio_ciclo]["month_number"],$month);
                                                                                                array_push($array_data[$anio_ciclo]["month_name"],$month_name);
                                                                                                array_push($array_data[$anio_ciclo]["dates"],$fecha_ciclo);
                                                                                                //busco si existe un registro guardado
                                                                                                $buscar_valor = $conexion->query("SELECT valor,comentarios,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as modificacion,DI.id_valor
                                                                                                FROM detalle_indicadores as DI
                                                                                                INNER JOIN usuarios as U ON DI.id_usuario = U.id_usuario
                                                                                                INNER JOIN personas as P ON U.id_persona = P.id_persona
                                                                                                WHERE DI.id_indicador = $id_indicador AND anio = $anio_ciclo AND mes = $month");
                                                                                                $existe = $buscar_valor->rowCount();
                                                                                                if($existe == 0){
                                                                                                    $id_detalle = 0;
                                                                                                    //todavia no se captura
                                                                                                    $valor = "NA";
                                                                                                    $comentarios = "NA";
                                                                                                    $modificacion = "NA";
                                                                                                    $resultados = 0;
                                                                                                }
                                                                                                else{
                                                                                                    $row_valor = $buscar_valor->fetch(PDO::FETCH_NUM);
                                                                                                    $valor = $row_valor[0];
                                                                                                    $comentarios  =$row_valor[1];
                                                                                                    $modificacion = $row_valor[2];
                                                                                                    $id_detalle = $row_valor[3];
                                                                                                    $resultados = $valor;
                                                                                                }
                                                                                                array_push($array_data[$anio_ciclo]["values"],$valor);
                                                                                                array_push($array_data[$anio_ciclo]["comments"],$comentarios);
                                                                                                $fecha = strtotime(date("Y-m-d",strtotime($fecha_ciclo."+ 3 month"))); 
                                                                                                $c++;
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td class="text-center"><?php echo $c;?></td>
                                                                                                    <td class="text-center"><?php echo $month_name;?></td>
                                                                                                    <td class="text-center"><?php echo $fecha_ciclo;?></td>
                                                                                                    <td class="text-center"><?php echo $valor;?></td>
                                                                                                    <td class="text-center"><?php echo $comentarios;?></td>
                                                                                                    <td class="text-center"><?php echo $modificacion;?></td>
                                                                                                    <td class="text-center">
                                                                                                        <button type="button" data-results="<?php echo $resultados;?>" data-comments="<?php echo $comentarios;?>" data-id2="<?php echo $id_indicador;?>"  data-year="<?php echo $anio_ciclo;?>" data-id="<?php echo $id_detalle;?>" data-month="<?php echo $month;?>" class="btn btn-success abrirModal" title="Editar resultado" data-toggle="toolstrip"><i class="fa fa-edit"></i></button>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                            $c = 0;
                                                                                            ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $n++;
                                                    $anio_ciclo++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                                    <div class="row">
                                                                                        <div class="col-md-10">
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <a href="index.php" class="btn btn-danger btn-block">Regresar</a>
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
    <!-- Modal -->
<div id="modal_resultados" class="modal fade" role="dialog">
    <form action="guardar_r.php" method="POST">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Guardar resultado</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <input type="hidden" name="id_detalle" id="id_detalle">
                        <input type="hidden" name="mes" id="mes">
                        <input type="hidden" name="anio" id="anio">
                        <input type="hidden" name="id" id="id">
                        <label for="resultado" class="control-label">Resultado: </label>
                        <input type="number" name="resultado" id="resultado" class="form-control">
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="comentarios" class="control-label">Comentarios: </label>
                        <textarea name="comentarios" id="comentarios" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-success">Guardar</button>
            </div>
            </div>

        </div>
    </form>
</div>
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
    <script src="../assets/plugins/raphael/raphael-min.js"></script>
    <script src="../assets/plugins/morrisjs/morris.js"></script>
    <script>
        <?php
        $cantidad = count($array_data);
        foreach($array_data as $key => $array_datos){
            $color = generar_color(6);
            $falta = 0;
            $anio = $array_datos["anio"];
            $meses = $array_datos["month_number"];
            $nombres = $array_datos["month_name"];
            $valores = $array_datos["values"];
            $comentarios = $array_datos["comments"];
            $fechas = $array_datos["dates"];
            ?>
            var grafico_<?php echo $anio;?> = Morris.Bar({
                element: 'bar-chart-<?php echo $anio;?>',
                data:[
                    <?php
                    $cantidad = count($nombres);
                    for($i = 0;$i<$cantidad;$i++){
                        $falta = $i + 1;
                        $nombre = $nombres[$i];
                        $valor = $valores[$i];
                        $valor = ($valor == "NA") ? 0:$valor;
                        if($falta == $cantidad){
                            ?>
                            {
                                periodo:'<?php echo $nombre;?>',
                                a:<?php echo $valor;?>
                            }
                            <?php
                        }
                        else{
                            ?>
                            {
                                periodo:'<?php echo $nombre;?>',
                                a:<?php echo $valor;?>
                            },
                            <?php
                        }
                        ?>
                        <?php
                    }
                    ?>
                ],
                hoverCallback: function(index, options, content, row) {
                    console.log(row);
                     var hover = "<div class='morris-hover-row-label'>"+row.periodo+" <?php echo $anio;?></div><div class='morris-hover-point' style='color: #A4ADD3'><p color:black>Meta: <?php echo $meta;?></p><p color:black>Cargado: "+row.a+"</p></div>";
                      return hover;
                    /* return(content); */
                },
                xkey: ['periodo'],
                ykeys: ['a'],
                labels: ['Meta '],
                barColors:['<?php echo $color;?>'],
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize:true
            });
            <?php
        }
        ?>
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr("data-year") // activated tab
            var objeto = eval("grafico_"+target);
            objeto.redraw();
            $(window).trigger('resize');
            });

            $('.abrirModal').on('click', function(e) {
            var year = $(e.target).attr("data-year") // activated tab
            var month = $(e.target).attr("data-month") // activated tab
            var id = $(e.target).attr("data-id") // activated tab
            var id2 = $(e.target).attr("data-id2") // activated tab
            var resultado = $(e.target).attr("data-results") // activated tab
            var comentarios = $(e.target).attr("data-comments") // activated tab
            $("#anio").val(year);
            $("#comentarios").val(comentarios);
            $("#resultado").val(resultado);
            $("#mes").val(month);
            $("#id_detalle").val(id);
            $("#id").val(id2);
            $("#modal_resultados").modal("show");
            });
    </script>
</body>
</html>