<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
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
                        <div class="card card-outline-info">
                           <div class="card-header">
                               <h4 class="m-b-0 text-white">Agregar activo fijo</h4>
                           </div>
                            <div class="card-body">
                                <form action="guardar.php" method="post">
                                <div class="row">
                                    <div class="col-md-8 form-group">
                                    <label for="no_activo" class="control-label">Nº de activo:</label>
                                        <div class="input-group">
                                            <input type="text" name="no_activo" readonly id="no_activo" class="form-control">   
                                            <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <label class="custom-control custom-checkbox m-b-0">
                                                                <input type="checkbox" name="activo_automatico" value=1 onclick="cambiar_tipo_activo(this);" checked class="custom-control-input">
                                                                <span class="custom-control-label">General automáticamente</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="clase_activo" class="control-label">Grupo de activo: </label>
                                        <select name="id_grupo_activo" onchange="buscar_subgrupos();" id="id_grupo_activo" class="form-control">
                                            <?php
                                            $grupos_activos = $conexion->query("SELECT id_grupo_activo,
                                            grupo_activo_fijo
                                            FROM grupo_activos_fijos");
                                            while($row = $grupos_activos->fetch(PDO::FETCH_NUM)){
                                                ?>
                                                <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="clase_activo" class="control-label">Subgrupo de activo: </label>
                                        <select name="id_subgrupo_activo" onchange="buscar_clases();" id="id_subgrupo_activo" class="form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="clase_activo" class="control-label">Clase de activo: </label>
                                        <select name="id_clase_activo_fijo" onchange="buscar_subclases();" id="id_clase_activo_fijo" class="form-control">
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="clase_activo" class="control-label">Subclase de activo: </label>
                                        <select name="id_subclase_activo_fijo" onchange="buscar_consecutivos();" id="id_subclase_activo_fijo" class="form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="clase_activo" class="control-label">Consecutivo activo fijo: </label>
                                        <select name="id_consecutivo_activo_fijo" onchange="habilitar_campos();" id="id_consecutivo_activo_fijo" class="form-control">
                                            
                                        </select>
                                    </div>
                                </div>
                                    <div class="row">
                                       <div class="col-md-4 form-group">
                                           <label for="">Tipo de activo: </label>
                                           <select name="id_tipo_activo_fijo" id="id_tipo_activo" class="form-control">
                                               <?php
                                               $tipo_activos = $conexion->prepare("SELECT id_tipo_activo_fijo,tipo_activo_fijo FROM tipo_activos");
                                               $tipo_activos->execute();
                                               while($row_tipos = $tipo_activos->fetch(PDO::FETCH_NUM)){
                                                   echo "<option value=$row_tipos[0]>$row_tipos[1]</option>";
                                               }
                                               ?>
                                           </select>
                                       </div>
                                        <div class="col-md-4 form-group">
                                            <label for="">Comentarios:</label>
                                            <textarea name="comentarios" id="" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-b-0">
                                <h4 class="card-title">Datos específicos del activo</h4>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs customtab2" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Datos del activo</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile7" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Responsable</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Ubicación</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Valores</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Datos contables</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home7" role="tabpanel">
                                        <div class="p-20">
                                        <div class="row">
                                        <!-- <div class="col-md-3 form-group">
                                            <label for="id_tipo_dispositivo">Tipo de dispositivo: </label>
                                            <input type="hidden" name="siglas_activo" id="siglas_activo">
                                            <select name="id_tipo_dispositivo" onchange="habilitar_campos();" id="id_tipo_dispositivo" class="form-control">
                                                <?php
                                                $tipos = $conexion->prepare("SELECT id_tipo_equipo,tipo_equipo,siglas FROM tipo_dispositivos");
                                                $tipos->execute();
                                                while($row_t = $tipos->fetch(PDO::FETCH_NUM)){
                                                    echo "<option id='option_tipo_equipo_$row_t[0]' data-value='$row_t[2]' value=$row_t[0]>$row_t[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-3 col-xs-12 col-sm-12 form-group">
                                            <label for="id_marca" class="control-label" id="">Marca:</label>
                                            <select name="id_marca" required id="id_marca" class="form-control">
                                                <?php
                                                $marcas = $conexion->prepare("SELECT id_marca,nombre_marca FROM marcas_equipos");
                                                $marcas->execute();
                                                while($row_m = $marcas->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_m[0]>$row_m[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="modelo" class="control-label">Modelo: </label>
                                            <input type="text" name="modelo" id="modelo" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="no_serie">N° de serie:</label>
                                            <input type="text" name="no_serie" id="no_serie" class="form-control" placeholder="Número de serie">
                                        </div>
                                        <div class="form-group col-md-3" tipo_campo="computadora">
                                        <label for="mac">Dirección MAC:</label>
                                            <input type="text" name="mac" id="mac" class="form-control" placeholder="Mac">
                                        </div>
                                        <div class="form-group col-md-2" tipo_campo="computadora">
                                            <label for="ram">Memoria RAM:</label>
                                            <select name="ram" id="ram" class="form-control">
                                                <option value="512KB">512KB</option>
                                                <option value="1GB">1GB</option>
                                                <option value="2GB">2GB</option>
                                                <option value="3GB">3GB</option>
                                                <option value="4GB">4GB</option>
                                                <option value="4GB">6GB</option>
                                                <option value="8GB">8GB</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2" tipo_campo="computadora">
                                            <label for="disco_duro">Disco Duro:</label>
                                            <input type="number" name="disco_duro" id="disco_duro" class="form-control" placeholder="GB" min="100">
                                        </div>
                                        <div class="col-md-2 form-group" tipo_campo="computadora">
                                            <label for="id_sistema" class="control-label" id="">Sistema Operativo:</label>
                                            <select name="id_sistema" required id="id_sistema" class="form-control">
                                                <?php
                                                $sistemas = $conexion->prepare("SELECT id_sistema_operativo,sistema_operativo FROM sistemas_operativos");
                                                $sistemas->execute();
                                                while($row_s = $sistemas->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_s[0]>$row_s[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group" tipo_campo="computadora">
                                            <label for="procesador">Procesador:</label>
                                            <select name="procesador" id="procesador" class="form-control">
                                                <?php
                                                $data = $conexion->prepare("SELECT id_procesador,procesador FROM procesadores WHERE activo = 1");
                                                $data->execute();
                                                while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_data[0]>$row_data[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="uso_cpu">Uso del dispositivo: </label>
                                            <select name="uso_cpu" id="uso_cpu" class="form-control">
                                                <option value="uso_personal">Asignado a administrativo</option>
                                                <option value="equipo_aula">Equipo en aulas</option>
                                                <option value="equipo_compartido">Equipo compartido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" tipo_campo="computadora">
                                    <div class="col-md-4 form-group">
                                                <label for="ip" class="control-label">Dirección IP: </label>
                                                <input type="text" name="ip" id="ip" class="form-control" placeholder="Dirección IP">
                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="internet">Acceso a internet</label>
                                                        <input type="checkbox" id="bitacora_publica" value="1" class="filled-in" name="internet">
                                                        <label for="bitacora_publica">El equipo cuenta con conexión a internet.</label>
                                                    </div>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="profile7" role="tabpanel">
                                    <div class="col-md-4 form-group">
                                            <label for="id_responsable">Responable del activo:</label>
                                            <select name="id_responsable" id="id_responsable" class="form-control">
                                                <?php
                                                $trabajadores = $conexion->prepare("SELECT id_trabajador,CONCAT(P.ap_paterno,' ',P.ap_materno,' ',P.nombre) as trabajador FROM trabajadores as T INNER JOIN personas as P ON T.id_persona = P.id_persona WHERE T.activo = 1 AND P.activo = 1 ORDER BY P.ap_paterno ASC");
                                                $trabajadores->execute();
                                                while($row_t = $trabajadores->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_t[0]>$row_t[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="messages7" role="tabpanel">
                                        <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="ubicacion" class="control-label">Ubicación: </label>
                                                    <select name="ubicacion" id="ubicacion" class="form-control">
                                                    <?php
                                                    $datos = $conexion->query("SELECT id_ubicacion,
                                                    ubicacion
                                                    FROM ubicaciones
                                                    WHERE activo = 1");
                                                    while($row = $datos->fetch(PDO::FETCH_NUM)){
                                                        ?>
                                                        <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="ubicacion" class="control-label">Ubicación interna: </label>
                                                    <select name="ubicacion_secundaria" id="ubicacion_secundaria" class="form-control">
                                                    <?php
                                                    $datos = $conexion->query("SELECT id_ubicacion_secundaria,
                                                    ubicacion_secundaria
                                                    FROM ubicaciones_secundarias
                                                    WHERE activo = 1");
                                                    while($row = $datos->fetch(PDO::FETCH_NUM)){
                                                        ?>
                                                        <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                    </div>           
                                    <div class="row">
                                        <div class="col-md-4">
                                        <a href="index.php"  class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
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
    <script type="text/javascript" src="funciones.js"></script>
    <script type="text/javascript">

        listar_registros();
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");

        $("#frmLiberar").submit(function(e){
            var frmData = new FormData(document.getElementById("frmLiberar"));
            $.ajax({
                url:"liberar.php",
                type:"POST",
                xhr:function(){
                    var myXhr = $.ajaxSettings.xhr();
                    return myXhr;
                },
                data:frmData,
                cache:false,
                contentType:false,
                processData:false,
                dataType:"json",
                success:function(respuesta){
                    alert(respuesta["mensaje"]);
                    $("#responsive-modal").modal("hide");
                },
                error:function(xhr,status){
                    alert("Error");
                }
            });
            e.preventDefault;
            return false;
        });
        //$("select").select2();
        habilitar_campos();        
        calcular_activo();
        buscar_subgrupos();
        $("#mac").inputmask({
            mask: "**:**:**:**:**:**",
        definitions: {
                "*": {
                    casing: "upper"
                }
            }
        });
        /* $("#ip").inputmask({
            mask: "***.***.***.***",
        definitions: {
                "*": {
                    casing: "upper"
                }
            }
        }); */
    </script>
</body>
</html>
