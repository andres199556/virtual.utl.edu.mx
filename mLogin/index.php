<?php
include "../conexion/conexion.php";
$datos = $conexion->query("SELECT nombre_empresa,path_logo  FROM datos_empresa WHERE id_empresa = 1");
$row_datos = $datos->fetch(PDO::FETCH_ASSOC);
$nombre =$row_datos["nombre_empresa"];
$logo = $row_datos["path_logo"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.ico">
    <title><?php echo $nombre;?> - Acceso</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../material/css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
<script src="../js/socket.js"></script>
</head>

<body>
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
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(../assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" action="#">
                    <a href="javascript:void(0)" class="text-center db"><img src="../<?php echo $logo;?>" alt="Home" width="150px;"><br/><?php echo $nombre;?></a>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="usuario" autofocus required="" placeholder="Correo electrónico">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required="" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex no-block align-items-center">
                            <!-- <div class="checkbox checkbox-primary p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div> -->
                            <div class="ml-auto">
                                <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock m-r-5"></i> Recuperar contraseña</a> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Iniciar sesión</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            Don't have an account? <a href="pages-register2.html" class="text-primary m-l-5"><b>Sign Up</b></a>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" id="recoverform" action="https://wrappixel.com/demos/admin-templates/material-pro/material/index.html">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recuperar contraseña</h3>
                            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/popper/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../material/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../material/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../material/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../material/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>
<script>
    $("#loginform").submit(function(e){
        e.preventDefault();
        $.ajax({
            url:"iniciar.php",
            type:"POST",
            dataType:"json",
            data:$(this).serialize()
        }).done(function(s){
            var resultado = s["resultado"];
            alert(resultado);
            if(resultado == "primer_acceso"){
                var id = s["id"];
                window.location = "../mPerfil/primer_acceso.php?id="+id;
            }
            else if(resultado == "error_usuario"){

            }
            else if(resultado == "llenar_informacion"){

            }
            else if(resultado == "cambiar_contra"){

            }
            else if(resultado == "exito"){
                //envio la sesión al socket
                modulo_actual = "mLogin";
                var s_id = s["s_id"];
                var user_id = s["user_id"];
                var date = s["date"];
                global_date = date;
                conect_socket(s_id,user_id,'login','web');    
                window.location = "../mInicio/index.php";
            }
        }).fail(function(Error){

        });
        return false;
    })
</script>
</html>