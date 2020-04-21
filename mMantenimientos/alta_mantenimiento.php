<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if(!isset($_GET["id"])){
    header("Location:index.php");
}
else{
    $id_plan_mantenimiento = $_GET["id"];
}
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
                <form action="guardar.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_plan_mantenimiento" value="<?php echo $id_plan_mantenimiento;?>">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                           <div class="card-header">
                               <h4 class="m-b-0 text-white">Agregar mantenimiento al plan</h4>
                           </div>
                            <div class="card-body">
                            <div class="row">
                                            <div class="col-lg-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Usuario: </span>
                                                    </div>
                                                    <select name="id_usuario" id="id_usuario" class="">
                                                <?php
                                                        //enlisto todos los trabajadores
                                                        $trabajadores = $conexion->prepare("SELECT
                                                        T.id_trabajador,
                                                        concat(
                                                            P.nombre,
                                                            ' ',
                                                            P.ap_paterno,
                                                            ' ',
                                                            P.ap_materno
                                                        ) AS trabajador,
                                                        U.id_usuario
                                                    FROM
                                                        trabajadores AS T
                                                    INNER JOIN personas AS P ON T.id_persona = T.id_persona
                                                    INNER JOIN usuarios AS U ON P.id_persona = U.id_persona
                                                    WHERE
                                                        P.activo = 1
                                                    AND T.activo = 1 AND U.id_usuario NOT IN (SELECT id_usuario_mantenimiento FROM planes_individuales_mantenimientos WHERE id_plan_mantenimiento = $id_plan_mantenimiento)
                                                    GROUP BY
                                                        U.id_usuario");
                                                        $trabajadores->execute();
                                                        while($row = $trabajadores->fetch(PDO::FETCH_NUM)){
                                                            echo "<option value=$row[2]>$row[1]</option>";
                                                        }
                                                        $trabajadores->closeCursor();
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="id_usuario_hidden" id="id_usuario_hidden">
                                            
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" onclick="seleccionar();" id="btn_seleccionar">Seleccionar</button>
                                                <button id="btn_cancelar" class="btn btn-danger hide" type="button" onclick="cancelar_seleccion();">Cancelar</button>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                 <br>
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="input-group">
                                               <div class="input-group-prepend">
                                                   <span class="input-group-text" id="label_fecha">Fecha de mantenimiento (tentativa): </span>
                                               </div>
                                               <input type="text" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control" fechas required>
                                           </div>
                                       </div>
                                   </div>
                                   <br>
                                    <div class="row hide" id="row_activos">
                                       <div class="col-lg-12 col-md-12 col-sm-12">
                                           <div class="input-group">
                                               <div class="input-group-prepend">
                                                   <label for="" class="input-group-text" id="label_activos">Activo a realizar mantenimiento: </label>
                                               </div>
                                               <select name="activos[]" id="activos" class="">
                                                <?php
                                                $activos = $conexion->prepare("SELECT
                                                AF.id_activo_fijo,
                                                AF.no_activo_fijo,
                                                CA.consecutivo_activo_fijo,
                                                ME.nombre_marca,
                                                AF.modelo,
                                                AF.no_serie
                                            FROM
                                                activos_fijos AS AF
                                            LEFT JOIN consecutivos_activos_fijos AS CA ON AF.id_consecutivo_activo_fijo = CA.id_consecutivo_activo_fijo
                                            INNER JOIN marcas_equipos as ME ON AF.id_marca = ME.id_marca
                                            WHERE AF.id_activo_fijo NOT IN (SELECT id_activo FROM activos_mantenimientos WHERE id_plan_mantenimiento = $id_plan_mantenimiento)
                                            ");
                                                $activos->execute();
                                                while($row = $activos->fetch(PDO::FETCH_NUM)){
                                                    echo "<option option-activos id='$row[1]' data-id='$row[0]' data-marca='$row[3]' data-model='$row[4]' data-serial='$row[5]' data-type='$row[2]' value=$row[1]>$row[1]</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" onclick="seleccionar_activo();" id="btn_seleccionar">Seleccionar activo</button>
                                            </div>
                                           </div>
                                       </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                                        <input onclick="incluir_activos_ligados(this);" type="checkbox" name="incluir_activos" value="1" class="filled-in" id="incluir_activos" disabled>
                                                        <label for="incluir_activos">Incluir activos ligados al usuario</label>
                                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                                        <input  type="checkbox" name="definir_despues" onclick="definir_despues_a();" value="1" class="filled-in" id="definir_despues">
                                                        <label for="definir_despues">Definir activos despues.</label>
                                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="table-responsive col-md-12">
                                            <table class="table table-striped color-table info-table table-condensed table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Tipo de activo</th>
                                                        <th class="text-center">N° activo</th>
                                                        <th class="text-center">Marca</th>
                                                        <th class="text-center">Modelo</th>
                                                        <th class="text-center">N° serie</th>
                                                        <th class="text-center">Eliminar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="body_activos"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="">Comentarios: </label>
                                            <textarea name="comentarios" id="comentarios" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                                        <input type="checkbox" name="enviar_correo" value="1" class="filled-in" id="enviar_correo">
                                                        <label for="enviar_correo">Enviar correo al usuario notificando del mantenimiento.</label>
                                                    </div>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-7">
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <a href="index.php"  class="btn btn-danger btn-block">Cancelar</a>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-info btn-block" id="btn_agregar" disabled>Agregar mantenimiento</button>
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
    <script src="funciones.js"></script>
    <script type="text/javascript">
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
         $('[fechas]').datepicker({
             autoclose: true,
             todayHighlight: true,
             format: 'yyyy-mm-dd',
             orientation:'bottom'
        });
        $("[fechas]").datepicker().datepicker("setDate", new Date());
        $('#horas').clockpicker({
                    placement: 'bottom',
                    align: 'left',
                    autoclose: true,
                    'default': 'now'
                });
    $("select").select2({
        width:'resolve'
    });
        $(document).ready(function(){
        $('[data-toggle=tooltip]').tooltip({ trigger: "hover" });
    });
    </script>
</body>
</html>