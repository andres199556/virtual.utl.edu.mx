<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
//busco la información basica
$id_usuario = $_SESSION["id_usuario"];
$informacion = $conexion->query("SELECT
U.id_usuario,
P.nombre,
P.ap_paterno,
P.ap_materno,
P.fecha_nacimiento,
P.sexo,
P.estado_civil,
P.direccion,
P.colonia,
P.ciudad,
P.estado,
P.curp,
T.id_direccion,
T.id_departamento,
T.id_puesto,
T.correo,
T.no_empleado,
T.fecha_ingreso_trabajo
FROM usuarios as U
INNER JOIN personas as P ON U.id_persona = P.id_persona
INNER JOIN trabajadores as T ON P.id_persona = T.id_persona
WHERE U.id_usuario = $id_usuario AND U.llenar_informacion = 1");
$existe = $informacion->rowCount();
if($existe == 0){
    header("Location:index.php");
}
$row_info = $informacion->fetch(PDO::FETCH_ASSOC);
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Actualizar información</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><?php echo $categoria_actual;?></a></li>
                            <li class="breadcrumb-item active">Actualizar información</li>
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
                               <h4 class="m-b-0 text-white">Actualizar información</h4>
                           </div>
                            <div class="card-body">
                                <form action="actualizar.php" method="post">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="nombre" class="control-label">Nombre: </label>
                                            <input type="text" name="nombre" value="<?php echo $row_info["nombre"];?>" required id="nombre" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="paterno" class="control-label">Apellido paterno: </label>
                                            <input type="text" name="paterno" value="<?php echo $row_info["ap_paterno"];?>" required id="paterno" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="materno" class="control-label">Apellido materno: </label>
                                            <input type="text" name="materno" value="<?php echo $row_info["ap_materno"];?>" required id="materno" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="fecha_nacimiento" class="control-label">Fecha de nacimiento: </label>
                                            <input type="text" value="<?php echo $row_info["fecha_nacimiento"];?>" fechas name="fecha_nacimiento" required id="fecha_nacimiento" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="sexo" class="control-label">Sexo: </label>
                                            <select name="sexo" id="sexo" class="form-control">
                                                <option value="H">Hombre</option>
                                                <option value="M">Mujer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="edo_civil" class="control-label">Estado civil: </label>
                                            <select name="edo_civil" required id="edo_civil" class="form-control">
                                                <option value="Soltero">Soltero</option>
                                                <option value="Casado">Casado</option>
                                                <option value="Viudo">Viudo</option>
                                                <option value="Divorciado">Divorciado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="direccion" class="control-label">Dirección: </label>
                                            <input type="text" value="<?php echo $row_info["direccion"];?>" name="direccion" required id="direccion" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="colonia" class="control-label">Colonia: </label>
                                            <input type="text" name="colonia" value="<?php echo $row_info["colonia"];?>" required id="colonia" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="ciudad" class="control-label">Ciudad: </label>
                                            <input type="text" name="ciudad" required id="ciudad" value="<?php echo $row_info["ciudad"];?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="estado" class="control-label">Estado: </label> 
                                            <select name="estado" id="estado" class="form-control">
                                        <option value="Aguascalientes">Aguascalientes</option>

                                        <option value="Baja California">Baja California</option>

                                        <option value="Baja California Sur">Baja California Sur</option>

                                        <option value="Campeche">Campeche</option>

                                        <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>

                                        <option value="Colima">Colima</option>

                                        <option value="Chiapas">Chiapas</option>

                                        <option value="Chihuahua">Chihuahua</option>

                                        <option value="Distrito Federal">Distrito Federal</option>

                                        <option value="Durango">Durango</option>

                                        <option value="Guanajuato">Guanajuato</option>

                                        <option value="Guerrero">Guerrero</option>

                                        <option value="Hidalgo">Hidalgo</option>

                                        <option value="Jalisco">Jalisco</option>

                                        <option value="México">México</option>

                                        <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>

                                        <option value="Morelos">Morelos</option>

                                        <option value="Nayarit">Nayarit</option>

                                        <option value="Nuevo León">Nuevo León</option>

                                        <option value="Oaxaca">Oaxaca</option>

                                        <option value="Puebla">Puebla</option>

                                        <option value="Querétaro">Querétaro</option>

                                        <option value="Quintana Roo">Quintana Roo</option>

                                        <option value="San Luis Potosí">San Luis Potosí</option>

                                        <option value="Sinaloa">Sinaloa</option>

                                        <option value="Sonora">Sonora</option>

                                        <option value="Tabasco">Tabasco</option>

                                        <option value="Tamaulipas">Tamaulipas</option>

                                        <option value="Tlaxcala">Tlaxcala</option>

                                        <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>

                                        <option value="Yucatán">Yucatán</option>

                                        <option value="Zacatecas">Zacatecas</option>
                                        </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="pais" class="control-label">País: </label>
                                            <input type="text" value="México" name="pais" value="<?php echo $row_info["pais"];?>" required id="pais" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="curp" class="control-label">CURP: </label>
                                            <input type="text" name="curp" required placeholder="CURP" id="curp" value="<?php echo $row_info["curp"];?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3 class="text-center">Datos laborales</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="id_direccion" class="control-label">Dirección: </label>
                                            <select name="id_direccion" id="id_direccion" class="form-control">
                                                <?php
                                                $direcciones = $conexion->query("SELECT id_direccion,direccion
                                                FROM direcciones
                                                WHERE activo = 1");
                                                while($row_direccion = $direcciones->fetch(PDO::FETCH_NUM)){
                                                    echo "<option value=$row_direccion[0]>$row_direccion[1]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="id_departamento" class="control-label">Departamento: </label>
                                            <select name="id_departamento" id="id_departamento" class="form-control">
                                                    <?php
                                                    $data = $conexion->query("SELECT id_departamento,departamento
                                                    FROM departamentos
                                                    WHERE activo = 1");
                                                    while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                        echo "<option value=$row_data[0]>$row_data[1]</option>";
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="id_puesto" class="control-label">Puesto: </label>
                                            <select name="id_puesto" id="id_puesto" class="form-control">
                                                <?php
                                                    $data = $conexion->query("SELECT id_puesto,puesto
                                                    FROM puestos
                                                    WHERE activo = 1");
                                                    while($row_data = $data->fetch(PDO::FETCH_NUM)){
                                                        echo "<option value=$row_data[0]>$row_data[1]</option>";
                                                    }
                                                    ?>        
                                             </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="correo" class="control-label">Correo: </label>
                                                        <input type="email" name="correo" value="<?php echo $row_info['correo'];?>" id="correo" class="form-control">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label for="no_empleado" class="control-label">Nº de empleado: </label>
                                                        <input type="number" name="no_empleado" value="<?php echo $row_info['no_empleado'];?>" min=0 id="no_empleado" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="fecha_ingreso" class="control-label">Fecha de ingreso: </label>
                                                        <input type="text" name="fecha_ingreso" value="<?php echo $row_info['fecha_ingreso_trabajo'];?>" fechas id="fecha_ingreso" class="form-control">
                                                    </div>
                                    </div>
                                    <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 class="text-center">Actualizar contraseña</h3>
                                                    </div>
                                    </div>
                                    <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label for="antigua" class="control-label">Antigua contraseña: </label>
                                                        <input type="password" name="antigua" onchange="validar_password();" id="antigua" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="nueva" class="control-label">Nueva contraseña: </label>
                                                        <input type="password" name="nueva" onchange="validar_password();" id="nueva" class="form-control">
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label for="repetir" class="control-label">Repetir nueva contraseña: </label>
                                                        <input type="password" name="repetir_nueva" onchange="validar_password();" id="repetir" class="form-control">
                                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                        <a href="index.php"  class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-success">Actualizar información</button>
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
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
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
    <script type="text/javascript">
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        function cambiar_titulo(combo){
            //var otro = $(combo).find("option").prop("selected");
            //alert($(otro).html());
            
        }
         $('[fechas]').datepicker({
             autoclose: true,
             todayHighlight: true,
             format: 'yyyy-mm-dd'
        });
                $("#sidebarnav").remove();
                $("#estado").val("<?php echo $row_info['estado'];?>");
                $("#edo_civil").val("<?php echo $row_info['estado_civil'];?>");
                $("#sexo").val("<?php echo $row_info['sexo'];?>");
                $("#id_direccion").val(<?php echo $row_info['id_direccion'];?>);
                $("#id_departamento").val(<?php echo $row_info['id_departamento'];?>);
                $("#id_puesto").val(<?php echo $row_info['id_puesto'];?>);
                $("select").select2({
                    width:'100%'
                });

                function validar_password(){
                    var antigua = $("#antigua").val();
                    var nueva = $("#nueva").val();
                    var repetir = $("#repetir").val();
                    if(antigua != "" || nueva != "" || repetir != ""){
                        $("#antigua").prop("required",true);
                        $("#nueva").prop("required",true);
                        $("#repetir").prop("required",true);
                    }
                    else if(antigua == "" || nueva == "" || repetir == ""){
                        $("#antigua").prop("required",false);
                        $("#nueva").prop("required",false);
                        $("#repetir").prop("required",false);
                    }
                }
                <?php
                $resultado  =$_GET["resultado"];
                if($resultado == "password_invalido"){
                    ?>
                    Swal.fire({
                        type: 'error',
                        title: 'Contraseña incorrecta',
                        text: 'La antigua contraseña es incorrecta, vuelve a intentarlo!',
                        timer:3000
                    })
                    <?php
                }
                else if($resultado == "error_actualizacion"){
                    ?>
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Ha ocurrido un error al actualizar los datos, vuelve a intetarlo mas tarde.!',
                        timer:3000
                    })
                    <?php
                }
                else if($resultado == "existe_persona"){
                    ?>
                    Swal.fire({
                        type: 'warning',
                        title: 'Error',
                        text: 'Ya existe un trabajador con el mismo CURP, verifica los datos.!',
                        timer:3000
                    })
                    <?php
                }
                ?>
    </script>
</body>
</html>