<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url(../assets/images/background/user-info.jpg) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="../assets/images/users/profile.png" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $_SESSION["nombre_corto"];?></a>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">Menú de navegación</li>
                        <li class="text-center">
                              <label for="" class="label label-rounded label-success">Tiempo de sesión: 60 minutos </label>
                        </li>
                        <li> 
                        <a class=" waves-effect waves-dark" href="../mInicio/index.php" aria-expanded="false">
                            <i class="mdi mdi-gauge"></i><span class="hide-menu">Inicio</span>
                        </a>
                        </li>
                        <?php
                        $categorias = $conexion->prepare("CALL llamar_categorias_modulos(".$_SESSION["id_usuario"].")");
                        $categorias->execute();
                        $array_categorias = $categorias->fetchAll();
                        $categorias->closeCursor();
                        for($i = 0;$i<count($array_categorias);$i++){
                            
                            $id_categoria = $array_categorias[$i][0];
                            $categoria = $array_categorias[$i][1];
                            $desc = $array_categorias[$i][2];
                            $icono = $array_categorias[$i][3];
                            ?>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="<?php echo $icono;?>"></i><span class="hide-menu"><?php echo $categoria;?> </span></a>
                                <ul aria-expanded="false" class="collapse">
                                   <?php
                             //busco los modulos
                             $modulos = $conexion->prepare("CALL llenar_modulos(".$id_categoria.",".$_SESSION["id_usuario"].")");
                             $modulos->execute();
                            $array_modulos = $modulos->fetchAll();
                            $modulos->closeCursor();
                            for($j = 0;$j<count($array_modulos);$j++){
                                $id_modulo = $array_modulos[$j][0];
                                $modulo = $array_modulos[$j][1];
                                $carpeta = $array_modulos[$j][2];
                                $icono_modulo = $array_modulos[$j][3];
                                $cantidad_catalogos = $array_modulos[$j][4];
                                if($cantidad_catalogos == 0){
                                    //es un módulo normal
                                    ?>
                                    <li><a href="../<?php echo $carpeta;?>/index.php"><i class="<?php echo $icono_modulo;?>"></i> <?php echo $modulo;?></a></li>
                                    <?php
                                }
                                else{
                                    //tiene catalogos por lo tanto es un menu de lista
                                    ?>
                                <li><a href="#" class="has-arrow"><?php echo $modulo;?> <!-- <span class="label label-rounded label-success">6</span> --></a>
                                   <ul aria-expanded="false" class="collapse">
                                        <?php
                                    //busco los catalogos
                                    $buscar_catalogos = $conexion->prepare("SELECT id_catalogo,ruta_catalogo,catalogo,icono FROM catalogo_modulos WHERE id_modulo = $id_modulo");
                                    $buscar_catalogos->execute();
                                    $array_catalogos = $buscar_catalogos->fetchAll();
                                    $buscar_catalogos->closeCursor();
                                    for($k = 0;$k<count($array_catalogos);$k++){
                                        $id_catalogo = $array_catalogos[$k][0];
                                        $ruta_catalogo = $array_catalogos[$k][1];
                                        $catalogo = $array_catalogos[$k][2];
                                        $icono_catalogo  =$array_catalogos[$k][3];
                                        ?>
                                        <li><a href="../<?php echo $carpeta;?>/<?php echo $ruta_catalogo;?>"><i class="<?php echo $icono_catalogo;?>"></i> <?php echo $catalogo;?></a></li>
                                        <?php
                                    }
                                    ?>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                             ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
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
                <a href="https://mail.google.com" target="_blank" class="link" data-toggle="tooltip" title="Correo"><i class="mdi mdi-gmail"></i></a>
                <!-- item-->
                <a href="../sesion/cerrar_sesion.php" class="link" data-toggle="tooltip" title="Cerrar sesión"><i class="mdi mdi-power"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>