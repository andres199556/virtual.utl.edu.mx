<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img src="../<?php echo $_SESSION['fotografia'];?>" style="width:50px;height:50px;" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <select name="" id="id_modulo_dashboard" class="form-control    waves-effect waves-dark"
                                onchange="cambiar_modulo(this.value);">
                                <option value="mInicio/index.php">Inicio</option>
                                <?php
                                        //busco los modulos
                                        $modulos = $conexion->query("SELECT
                                        M.id_modulo,
                                        M.nombre_modulo,
                                        M.carpeta_modulo
                                    FROM
                                        permiso_modulos AS PM
                                    INNER JOIN modulos AS M ON PM.id_modulo = M.id_modulo
                                    WHERE
                                        PM.id_usuario = $id_usuario_logueado
                                    AND PM.permiso != 0 
                                    ORDER BY
                                        M.nombre_modulo ASC");
                                        while($row_m = $modulos->fetch(PDO::FETCH_NUM)){
                                            $carpeta = $row_m[2];
                                            $ruta = "../$carpeta/index.php";
                                            ?>
                                <option value="<?php echo $ruta;?>"><?php echo $row_m[1];?></option>
                                <?php
                                        }
                                        ?>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" onclick="window.location = '../mInicio/index.php'"
                                title="Panel de control" data-toggle="tooltip" class="btn btn-success btn-block"><i
                                    class="fa fa-tachometer-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">Menú de navegación</li>
                <!-- <li>
                    <a class=" waves-effect waves-dark" href="../mAdministracion/index.php" aria-expanded="false">
                        <i class="fa fa-wrench" style="color:#000000;"></i><br><span class="" style="font-size:9px;">Administración</span>
                    </a>
                </li> -->
                <li class="">
                    <a class=" text-center" href="../mInicio/index.php">
                        <i class="mdi mdi-gauge text-secondary"></i><br><span class="">Inicio</span>
                    </a>
                </li>
                <li>
                    <a class=" waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-university text-primary"></i><br><span class="">Mis cursos</span>
                    </a>
                </li>
                <li>
                    <a class=" waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-comments text-warning"></i><br><span class="">Mensajes</span>
                    </a>
                </li>
                
                <li>
                    <a class=" waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-cog"></i><br><span class="">Mi perfíl</span>
                    </a>
                </li>
                <li>
                    <a class=" waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="fa fa-graduation-cap text-success"></i><br><span class="" style="font-size:9px;">Calificaciones</span>
                    </a>
                </li>
                <li>
                    <a class=" waves-effect waves-dark" href="../sesion/cerrar_sesion.php" aria-expanded="false">
                        <i class="fa fa-sign-out-alt text-danger"></i><br><span class="">Salir</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <!-- item-->
        <!-- <a href="../mPerfil/index.php" class="link" data-toggle="tooltip" title="Configuración"><i class="ti-settings"></i></a> -->
        <!-- item-->
        <a href="https://mail.google.com" target="_blank" class="link" data-toggle="tooltip" title="Correo"><i
                class="mdi mdi-gmail"></i></a>
        <!-- item-->
        <a href="../sesion/cerrar_sesion.php" class="link" data-toggle="tooltip" title="Cerrar sesión"><i
                class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>