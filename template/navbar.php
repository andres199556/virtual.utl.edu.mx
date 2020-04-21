<header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="../assets/images/logo.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="../assets/images/logo.png" style="width:60px;height:59px;" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="text-logo">Control Interno</span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                   <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notificaciones</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            Message
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            Message
                                            <a href="#">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            Message
                                            <a href="#">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            Message
                                            <a href="#">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify hide notify-mensaje"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title text-center">Mensajes</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <?php
                                            /* $conversaciones = $conexion->query("SELECT
                                            C.id_conversacion,
                                            C.tipo_conversacion,
                                        
                                        IF (
                                            C.tipo_conversacion = 'normal',
                                            (
                                                SELECT
                                                    P.fotografia
                                                FROM
                                                    integrantes_conversaciones AS ICO
                                                INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                WHERE
                                                    ICO.id_conversacion = C.id_conversacion
                                                AND ICO.id_usuario != $id_usuario_logueado
                                            ),
                                            C.imagen_conversacion
                                        ) AS imagen_conversacion,
                                        
                                        IF (
                                            C.tipo_conversacion = 'normal',
                                            (
                                                SELECT
                                                    ICO.apodo
                                                FROM
                                                    integrantes_conversaciones AS ICO
                                                INNER JOIN usuarios AS U ON ICO.id_usuario = U.id_usuario
                                                INNER JOIN personas AS P ON U.id_persona = P.id_persona
                                                WHERE
                                                    ICO.id_conversacion = C.id_conversacion
                                                AND ICO.id_usuario != $id_usuario_logueado
                                            ),
                                            C.nombre_conversacion
                                        ) AS nombre_conversacion,
                                         (
                                            SELECT
                                                M.mensaje
                                            FROM
                                                mensajes AS M
                                            WHERE
                                                M.id_conversacion = C.id_conversacion AND M.activo = 1
                                            ORDER BY
                                                M.id_mensaje DESC
                                            LIMIT 1
                                        ) AS mensaje,
                                        (
	SELECT
		DATE(M.fecha_hora)
	FROM
		mensajes AS M
	WHERE
		M.id_conversacion = C.id_conversacion
	ORDER BY
		M.id_mensaje DESC
	LIMIT 1
) AS fecha,
 (
	SELECT
		TIME_FORMAT(
			TIME(M.fecha_hora),
			'%h:%i %p'
		)
	FROM
		mensajes AS M
	WHERE
		M.id_conversacion = C.id_conversacion
	ORDER BY
		M.id_mensaje DESC
	LIMIT 1
) AS hora
                                        FROM
                                            conversaciones AS C
                                        INNER JOIN integrantes_conversaciones AS IC ON C.id_conversacion = IC.id_conversacion
                                        WHERE
                                            IC.id_usuario = $id_usuario_logueado
                                        GROUP BY
                                            C.id_conversacion
                                            ORDER BY
	fecha DESC,
	hora DESC"); */
                                            /* while($row_c = $conversaciones->fetch(PDO::FETCH_NUM)){
                                                ?>
                                                <a href="#" id="conversacion_<?php echo $row_c[0];?>" data-conversacion="<?php echo $row_c[0];?>">
                                                    <div class="user-img"> <img src="../<?php echo $row_c[2];?>" alt="user" class="img-circle"> </div>
                                                    <div class="mail-contnet">
                                                        <h5><?php echo $row_c[3];?></h5> <span class="mail-desc"><?php echo $row_c[4];?></span> <span class="time"><?php echo $row_c[6];?></span> </div>
                                                </a>
                                                <?php
                                            } */
                                            ?>

                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="../mMensajes/index.php"> <strong>Ver todos</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../<?php echo $_SESSION['fotografia'];?>" alt="user" class="profile-pic" /> <?php echo $_SESSION["nombre_corto"];?></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            
                                            <div class="u-text">
                                                <h4 class="text-center"><?php echo $_SESSION["nombre_corto"];?></h4>
                                                <?php
                                                if($_SESSION["correo"] == "" || $_SESSION["correo"] == null){
                                                    //no lo muestro
                                                }
                                                else{
                                                    ?>
                                                    <p class="text-muted text-center"><?php echo $_SESSION["correo"];?></p></div>
                                                    <?php
                                                }
                                                ?>
                                                
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#" class="">Dpto: <span class="label label-danger" style="float:right;">Soporte Técnico</span></a></li>
                                    <li><a href="#">Puesto: <span class="label label-info" style="float:right">Coordinador de área</span></a></li>
                                    <li><a href="#">Sesión: <span class="label label-warning" style="float:right"><i class="fa fa-clock"></i> 60 min</span></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Configuración</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="fa fa-power-off"></i> Cerrar sesión</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown" title="Cambiar idioma">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-mx"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"> 
                            <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-us"></i> English</a> 
                            </div>
                        </li>
                    </ul>
                </div>
                
            </nav>
        </header>