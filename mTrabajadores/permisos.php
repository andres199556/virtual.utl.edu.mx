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
    if($id == null || $id == ""){
        header("Location:index.php");
    }
    else{
        //busco los datos
        $datos = $conexion->prepare("SELECT id_trabajador,concat(P.nombre,' ',P.ap_paterno,' ',P.ap_materno),U.id_usuario
        FROM trabajadores as T  
        inner join personas P ON T.id_persona = P.id_persona 
        inner join usuarios as U ON P.id_persona = U.id_persona
        WHERE T.id_trabajador = $id");
        $datos->execute();
        $existe = $datos->rowCount();
        if($existe != 1){
            header("Location:index.php");
        }
        else{
            $row_datos = $datos->fetch(PDO::FETCH_NUM);
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
                            <li class="breadcrumb-item active"><?php echo $modulo_actual;?> > Asignar permisos</li>
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
                       <form action="guardar_permisos.php" method="post">
                       <input type="hidden" name="id_usuario_permisos" value="<?php echo $row_datos[2];?>">
                        <div class="card card-outline-info">
                           <div class="card-header">
                               <h4 class="m-b-0 text-white">Asignar permisos</h4>
                           </div>
                            <div class="card-body">
                                   <div class="row">
                                       <div class="col-md-12">
                                           <label for="">Trabajador: <?php echo $row_datos[1];?></label>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="table-responsive">
                                               <table class="table table-hover table-bordered table-condensed table-striped">
                                                   <thead>
                                                       <tr>
                                                           <th class="text-center">#</th>
                                                           <th class="text-center">Módulo</th>
                                                           <th class="text-center">Permiso</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       <?php
                                                       $mod = $conexion->prepare("SELECT
                                                       M.id_modulo,
                                                       nombre_modulo,
                                                   
                                                   IF (
                                                       (
                                                           SELECT
                                                               PM.permiso
                                                           FROM
                                                               permiso_modulos AS PM
                                                           WHERE
                                                               PM.id_modulo = M.id_modulo
                                                           AND PM.id_usuario = $row_datos[2]
                                                       ) IS NULL,
                                                       0,
                                                       (
                                                           SELECT
                                                               PM.permiso
                                                           FROM
                                                               permiso_modulos AS PM
                                                           WHERE
                                                               PM.id_modulo = M.id_modulo
                                                           AND PM.id_usuario = $row_datos[2]
                                                       )
                                                   ) AS permiso_modulo
                                                   FROM
                                                       modulos AS M
                                                   ORDER BY
                                                       nombre_modulo");
                                                       $mod->execute();
                                                       $n = 0;
                                                       while($row = $mod->fetch(PDO::FETCH_NUM)){
                                                           $permiso_tra = $row[2];
                                                           $sel_0 = "";
                                                           $sel_1 = "";
                                                           $sel_2 = "";
                                                           switch($permiso_tra){
                                                               case 0:
                                                                   $sel_0 = "selected";
                                                                   break;
                                                               case 1:
                                                                   $sel_1 = "selected";
                                                                   break;
                                                               case 2:
                                                                   $sel_2 = "selected";
                                                                   break;
                                                           }
                                                           ++$n;
                                                           ?>
                                                           <tr>
                                                               <td class="text-center"><?php echo $n;?></td>
                                                               <td class="text-center"><?php echo $row[1];?></td>
                                                               <td class="text-center">
                                                                  <input type="hidden" name="id_modulos[]" value="<?php echo $row[0];?>">
                                                                   <select name="permisos[]" id="permiso" class="form-control">
                                                                       <option value="0" <?php echo $sel_0;?>>Sin acceso</option>
                                                                       <option value="2" <?php echo $sel_2;?>>Acceso</option>
                                                                       <option value="1" <?php echo $sel_1;?>>Administración</option>
                                                                   </select>
                                                               </td>
                                                           </tr>
                                                           <?php
                                                       }
                                                       ?>
                                                   </tbody>
                                               </table>
                                           </div>
                                       </div>
                                   </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                       <div class="col-md-8">
                                           
                                       </div>
                                        <div class="col-md-2">
                                        <a href="index.php"  class="btn btn-danger btn-block">Cancelar</a>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-block">Guardar</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        </form>
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
    <script type="text/javascript">
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        // For the time now
Date.prototype.timeNow = function () {
     return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
}
        var fecha_actual = new Date();
        var todo = fecha_actual.timeNow();
        $("#horas").val(todo);
        function cambiar_titulo(combo){
            //var otro = $(combo).find("option").prop("selected");
            //alert($(otro).html());
            
        }
         $('#fechas').datepicker({
             autoclose: true,
             todayHighlight: true,
             format: 'yyyy-mm-dd'
        });
        $("#fechas").datepicker().datepicker("setDate", new Date());
        $('#horas').clockpicker({
                    placement: 'bottom',
                    align: 'left',
                    autoclose: true,
                    'default': 'now'
                });
    </script>
</body>
</html>