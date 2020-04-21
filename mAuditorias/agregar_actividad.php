<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
if(!isset($_GET["id"])){
    header("Location:index.php");
}
else{
    $id = $_GET["id"];
    //busco los datos de la accion
    $accion  =$conexion->query("SELECT A.id_accion,DI.direccion,TA.nombre as origen,A.numero as numero,
    A.fecha_alta,
    CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as creacion,A.descripcion,
    A.id_estado,
    EA.estado_accion,
    CONCAT(P2.nombre,' ',P2.ap_paterno,' ',P2.ap_materno) as responsable,
    CONCAT(P3.nombre,' ',P3.ap_paterno,' ',P3.ap_materno) as verificador,
    DA.fecha_asignacion,
    DA.mano_obra,
    DA.medio_ambiente,
    DA.material,
    DA.metodo,
    DA.maquinaria,
    DA.analisis_conformidad,
    DA.pendiente_validar,
    DA.validado,
    DA.fecha_vencimiento,
    DA.id_verificador,
    DA.id_responsable
    FROM acciones as A
    LEFT JOIN direcciones as DI ON A.id_direccion = DI.id_direccion
    LEFT JOIN usuarios as U ON A.id_usuario = U.id_usuario
    INNER JOIN personas as P ON U.id_persona = P.id_persona
    INNER JOIN estado_acciones as EA ON A.id_estado = EA.id_estado
    LEFT JOIN tipo_acciones as TA ON A.id_tipo_accion = TA.id_tipo_accion
    LEFT JOIN detalle_acciones as DA ON a.id_accion = A.id_accion
    LEFT JOIN usuarios as U2 ON DA.id_responsable = U2.id_usuario
    LEFT JOIN personas as P2 ON U2.id_persona = P2.id_persona
    LEFT JOIN usuarios as U3 ON DA.id_verificador = U3.id_usuario
    LEFT JOIN personas as P3 ON U3.id_persona = P3.id_persona
    WHERE A.id_accion = $id");
    $existe = $accion->rowCount();
    if($existe  == 0){
        header("Location:index.php");
    }
    else{
        $row_accion = $accion->fetch(PDO::FETCH_ASSOC);
        if($row_accion["pendiente_validar"] == 1 || $row_accion["validado"] == 1){
            $class = "disabled";
        }
        else{
            $class = "";
        }
        if($row_accion["id_responsable"] == $id_usuario_logueado || $row_accion["id_verificador"] == $id_usuario_logueado){
            //tengo permisos
        }
        else{
            if($permiso_acceso == 1){

            }
            else{
                header("Location:index.php");
            }
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
                <form action="guardar_actividad.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <strong><span class="text-white">Agregar actividad</span></strong>
<input type="hidden" name="id_accion" value="<?php echo $id;?>">
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Actividad:
                                                    </strong></b></label>
                                            <input type="text" name="actividad" required id="actividad"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Responsable:
                                                    </strong></b></label>
                                            <select name="responsable" id="responsable" class="form-control">
                                                <?php
                                        $datos = $conexion->query("SELECT U.id_usuario,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno ) as usuario
                                        FROM trabajadores as T
                                        INNER JOIN personas as P ON T.id_persona = P.id_persona
                                        INNER JOIN usuarios as U ON P.id_persona = U.id_persona
                                        WHERE T.activo = 1 AND U.activo = 1");
                                        while($row_datos = $datos->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row_datos['id_usuario'];?>">
                                                    <?php echo $row_datos["usuario"];?></option>
                                                <?php
                                        }
                                        ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Fecha de inicio:
                                                    </strong></b></label>
                                            <input type="text" name="fecha_inicio" required autocomplete="off" fechas
                                                id="fecha_inicio" class="form-control">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="titulo" class="control-label"><b><strong>Fecha de cierre:
                                                    </strong></b></label>
                                            <input type="text" name="fecha_cierre" required autocomplete="off" fechas
                                                id="fecha_cierre" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="descripcion" class="control-label"><b><strong>Descripción:
                                                    </strong></b></label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="5" required
                                                class="form-control"></textarea>
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
                                            <button type="submit" class="btn btn-success btn-block">Guardar
                                                actividad</button>
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
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
                <!-- Modal -->
                <div id="modal_acciones" class="modal fade" role="dialog">

                </div>
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
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        orientation: "bottom"
    });
    $("select").select2();

    function get_action(type, id) {
        if (type == 1) {
            $.ajax({
                url: "modal_procede.php",
                type: "GET",
                dataType: "html",
                data: {
                    'id': id
                }
            }).done(function(success) {
                $("#modal_acciones").html(success);
                $("#id_responsable").select2({
                    'width': '100%'
                });
                $("#verificador").select2({
                    'width': '100%'
                });
                $("#modal_acciones").modal("show");

            }).fail(function(error) {
                alert("Error");
            });
        }
    }
    $('.frmProcede').submit(function(e) {
        alert("asdasdasd");
        e.preventDefault();
        return false;
    });

    </script>
</body>

</html>