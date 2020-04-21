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
    $accion  =$conexion->query("SELECT
	A.id_accion,
	DI.direccion,
	TA.nombre AS origen,
	A.numero AS numero,
	A.fecha_alta,
	CONCAT(
		P.nombre,
		' ',
		P.ap_paterno,
		' ',
		P.ap_materno
	) AS creacion,
	A.descripcion,
	A.id_estado,
	EA.estado_accion,
	CONCAT(
		P2.nombre,
		' ',
		P2.ap_paterno,
		' ',
		P2.ap_materno
	) AS responsable,
	CONCAT(
		P3.nombre,
		' ',
		P3.ap_paterno,
		' ',
		P3.ap_materno
	) AS verificador,
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
	DA.id_responsable,
	DA.comentarios_cierre,
	DA.fecha_cierre,
	DA.resultado
FROM
	acciones AS A
LEFT JOIN direcciones AS DI ON A.id_direccion = DI.id_direccion
LEFT JOIN usuarios AS U ON A.id_usuario = U.id_usuario
INNER JOIN personas AS P ON U.id_persona = P.id_persona
INNER JOIN estado_acciones AS EA ON A.id_estado = EA.id_estado
LEFT JOIN tipo_acciones AS TA ON A.id_tipo_accion = TA.id_tipo_accion
LEFT JOIN detalle_acciones AS DA ON A.id_accion = DA.id_accion
LEFT JOIN usuarios AS U2 ON DA.id_responsable = U2.id_usuario
LEFT JOIN personas AS P2 ON U2.id_persona = P2.id_persona
LEFT JOIN usuarios AS U3 ON DA.id_verificador = U3.id_usuario
LEFT JOIN personas AS P3 ON U3.id_persona = P3.id_persona
WHERE
	A.id_accion = $id");
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
                <form action="guardar.php" method="post" id="frmAlta">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-outline-info">
                                <div class="card-header">
                                    <strong><span class="text-white">Accion correctiva #
                                            <?php echo $id;?></span></strong>
                                    <?php
                                            if($row_accion["id_estado"] == 1){
                                                ?>
                                    <div class="card-actions">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ti-settings"></i> Acciones
                                            </button>
                                            <div class="dropdown-menu flipInX" x-placement="bottom-start">
                                                <a class="dropdown-item"
                                                    href="javascript:get_action(1,<?php echo $id;?>);"><i
                                                        class="fa fa-check text-success"></i> Proceder</a>
                                                <a class="dropdown-item"
                                                    href="javascript:get_action(2,<?php echo $id;?>);"><i
                                                        class="fa fa-times text-danger"></i> Rechazar</a>
                                                <a class="dropdown-item"
                                                    href="javascript:get_action(3,<?php echo $id;?>);"><i
                                                        class="fa fa-edit text-warning"></i> Llenado incompleto</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                            else{

                                            }
                                            ?>

                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="direccion"
                                                class="control-label"><b><strong>Dirección:</strong></b> </label>
                                            <input type="text" name="direccion" readonly id="direccion"
                                                class="form-control" value="<?php echo $row_accion['direccion'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>Origen:</strong></b>
                                            </label>
                                            <input type="text" name="origen" readonly id="origen" class="form-control"
                                                value="<?php echo $row_accion['origen'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>N° de auditoria o
                                                        revisión:</strong></b> </label>
                                            <input type="text" name="origen" readonly id="origen" class="form-control"
                                                value="<?php echo $row_accion['numero'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>Fecha de
                                                        creación:</strong></b> </label>
                                            <input type="text" name="origen" readonly id="origen" class="form-control"
                                                value="<?php echo $row_accion['fecha_alta'];?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>Usuario que
                                                        creó:</strong></b> </label>
                                            <input type="text" name="origen" readonly id="origen" class="form-control"
                                                value="<?php echo $row_accion['creacion'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>Descripción u
                                                        observación:</strong></b> </label>
                                            <textarea name="" id="" rows="6" class="form-control"
                                                readonly="readonly"><?php echo $row_accion["descripcion"];?></textarea>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="origen" class="control-label"><b><strong>Estado de la
                                                        acción:</strong></b> </label>
                                            <?php echo  $row_accion['estado_accion'];?>
                                        </div>
                                    </div>
                                    <?php
                                    if($row_accion["id_estado"] == 2 || $row_accion["id_estado"] == 5){
                                        ?>
                                    <div class="row">
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label"><b><strong>Responsable:
                                                    </strong></b></label>
                                            <input type="text" name="" id="" class="form-control" readonly="readonly"
                                                value="<?php echo $row_accion['responsable'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label"><b><strong>Verificador:
                                                    </strong></b></label>
                                            <input type="text" name="" id="" class="form-control" readonly="readonly"
                                                value="<?php echo $row_accion['verificador'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label"><b><strong>Fecha de
                                                        asignación: </strong></b></label>
                                            <input type="text" name="" id="" class="form-control" readonly="readonly"
                                                value="<?php echo $row_accion['fecha_asignacion'];?>">
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="responsable" class="control-label"><b><strong>Fecha de
                                                        vencimiento: </strong></b></label>
                                            <div class="input-group">
                                                <input type="text" name="" fechas id="fecha_vencimiento"
                                                    class="form-control"
                                                    <?php echo ($permiso_acceso == 1 && $row_accion["id_estado"] != 5) ? "":"readonly" ;?>
                                                    value="<?php echo $row_accion['fecha_vencimiento'];?>">
                                                <div class="input-group-append">
                                                    <?php
                                                if($permiso_acceso == 1 && $row_accion["id_estado"] != 5){
                                                    echo '<button class="btn btn-info btnActualizar" type="button">Actualizar</button>';
                                                }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Mano de
                                                    obra</b></label><textarea <?php echo $class;?> name="mano" id=""
                                                cols="30" rows="5" class="form-control"
                                                col="30"><?php echo $row_accion["mano_obra"];?></textarea></div>
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Medio
                                                    ambiente</b></label><textarea <?php echo $class;?>
                                                name="medio_ambiente" id="" cols="30" rows="5" class="form-control"
                                                col="30"><?php echo $row_accion["medio_ambiente"];?></textarea></div>
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Material:
                                                </b></label><textarea <?php echo $class;?> name="material" id=""
                                                cols="30" rows="5" class="form-control"
                                                col="30"><?php echo $row_accion["material"];?></textarea></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Método: </b></label><textarea
                                                <?php echo $class;?> name="metodo" id="" cols="30" rows="5"
                                                class="form-control"
                                                col="30"><?php echo $row_accion["metodo"];?></textarea></div>
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Maquinaria:
                                                </b></label><textarea <?php echo $class;?> name="maquinaria" id=""
                                                cols="30" rows="5" class="form-control"
                                                col="30"><?php echo $row_accion["maquinaria"];?></textarea></div>
                                        <div class="col-md-4 form-group"><label for=""
                                                class="control-label"><strong></strong><b>Análisis de no conformidad:
                                                </b></label><textarea <?php echo $class;?> name="analisis" id=""
                                                cols="30" rows="5" class="form-control"
                                                col="30"><?php echo $row_accion["analisis_conformidad"];?></textarea>
                                        </div>
                                    </div>
                                    <?php
                                    if($row_accion["pendiente_validar"] == 0 && $row_accion["validado"] == 0){
                                        ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-block btnGuardar" type="button"
                                                onclick="guardar_cambios();">Guardar cambios</button>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    else if($row_accion["pendiente_validar"] == 1 && $row_accion["validado"] == 0){
                                        //pendiente de validar
                                        if($row_accion["id_verificador"] == $id_usuario_logueado){
                                            if($row_accion["pendiente_validar"] == 1){
                                                ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a class="btn btn-primary btn-block btnValidar"
                                                href="validar.php?id=<?php echo $id;?>">Validar análisis</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-danger btn-block btnRechazar"
                                                href="javascript:rechazar(<?php echo $id;?>);">Rechazar</a>
                                        </div>
                                    </div>
                                    <?php
                                            }
                                        }
                                        else{
                                            ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn  btn-block btn-disabled" disabled type="button">Pendiente
                                                de validación</button>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="">
                                                <table
                                                    class="table hover table-bordered table-striped color-table success-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th class="text-center">Responsable</th>
                                                            <th class="text-center">Actividad</th>
                                                            <th class="text-center">Descrpición</th>
                                                            <th class="text-center">Fecha de inicio</th>
                                                            <th class="text-center">Fecha de cierre</th>
                                                            <th class="text-center">Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                    $actividades = $conexion->query("SELECT A.id_actividad,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno ) as responsable,
                                                    A.actividad,
                                                    A.descripcion,
                                                    A.fecha_inicio,
                                                    A.fecha_cierre,
                                                    A.activo,
                                                    A.motivo_rechazo,
                                                    A.fecha_rechazo,
                                                    CONCAT(P2.nombre,' ',P2.ap_paterno,' ',P2.ap_materno) as usuario_rechazo
                                                    FROM actividades as A
                                                    INNER JOIN usuarios as U ON A.id_responsable = U.id_usuario
                                                    INNER JOIN personas as P ON U.id_persona = P.id_persona
                                                    LEFT JOIN usuarios as U2 ON A.usuario_rechazo = U2.id_usuario
                                                    LEFT JOIN personas as P2 ON U2.id_persona = P2.id_persona
                                                    WHERE A.id_accion = $id");
                                                    $n = 0;
                                                    $abiertas = 0;
                                                    while($row_actividades = $actividades->fetch(PDO::FETCH_ASSOC)){

                                                        switch($row_actividades["activo"]){
                                                            case 0:
                                                            $estado = "<span class='text-success'>Cerrada</span>";
                                                            break;
                                                            case 1:
                                                            $estado = "Abierta";
                                                            $abiertas++;
                                                            break;
                                                            case 2:
                                                            $estado = "<span class='text-info'>Pendiente de verificación</span>";
                                                            $abiertas++;
                                                            break;
                                                            case 3:
                                                            $estado = "<span class='text-danger'>Rechazada</span>";
                                                            //$abiertas++;
                                                            break;
                                                        }
                                                        //$estado = ($row_actividades["activo"] == 0) ? "Cerrada":"Abierta";
                                                        $n++;
                                                        ?>
                                                        <tr
                                                            class="actividad_<?php echo $row_actividades['id_actividad'];?>">
                                                            <td class="text-center"><?php echo $n;?></td>
                                                            <td class="text-center">
                                                                <?php echo $row_actividades['responsable'];?></td>
                                                            <td class="text-center">
                                                                <?php echo $row_actividades['actividad'];?></td>
                                                            <td class="text-center">
                                                                <?php echo $row_actividades['descripcion'];?></td>
                                                            <td class="text-center">
                                                                <?php echo $row_actividades['fecha_inicio'];?></td>
                                                            <td class="text-center">
                                                                <?php echo $row_actividades['fecha_cierre'];?></td>
                                                            <td class="text-center td-estado">
                                                                <b><strong><?php echo $estado;?></strong></b></td>
                                                            <td class="text-center td-accion">
                                                                <?php
                                                        if($row_accion["id_responsable"] == $id_usuario_logueado && $row_actividades["activo"] == 1){
                                                            //puede editar y cerrar
                                                            ?>
                                                                <button type="button" class="btn btn-warning btn-sm"
                                                                    title="Editar actividad" data-toggle="tooltip"><i
                                                                        class="fa fa-edit"></i></button>
                                                                <button type="button"
                                                                    data-id="<?php echo $row_actividades['id_actividad'];?>"
                                                                    class="btn btn-success btn-sm btnCerrarActividad"
                                                                    title="Cerrar actividad" data-toggle="tooltip"><i
                                                                        class="fa fa-check"></i></button>
                                                                <?php
                                                        }
                                                        else{
                                                            if($row_actividades["activo"] == 2){
                                                                ?>
                                                                <button
                                                                    onclick="mostrar_evidencias(<?php echo $row_actividades['id_actividad'];?>);"
                                                                    type="button"
                                                                    class="btn btn-sm btn-success btnMostrarEvidencia"
                                                                    title="Mostrar evidencia" data-toggle="tooltip"><i
                                                                        class="fa fa-list"></i></button>
                                                                <?php
                                                            }
                                                            else if($row_actividades["activo"] == 3){
                                                                //esta rechazada
                                                                ?>
                                                                <p><b><strong>Motivo: </strong></b>
                                                                    <?php echo $row_actividades["motivo_rechazo"];?></p>
                                                                <p><b><strong>Fecha: </strong></b>
                                                                    <?php echo $row_actividades["fecha_rechazo"];?></p>
                                                                <?php
                                                            }
                                                            else if($row_actividades["activo"] == 0){
                                                                ?>
                                                                <button
                                                                    onclick="mostrar_evidencias(<?php echo $row_actividades['id_actividad'];?>);"
                                                                    type="button"
                                                                    class="btn btn-sm btn-success btnMostrarEvidencia"
                                                                    title="Mostrar evidencia" data-toggle="tooltip"><i
                                                                        class="fa fa-list"></i></button>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <?php
                                                    if($abiertas != 0){
                                                        //existen abiertas todavia
                                                        ?>
                                                        <th class="text-center" colspan=7></th>
                                                        <?php
                                                        if($row_accion["validado"] == 1 && $row_accion["id_estado"] != 5){
                                                            ?>
                                                        <th class="text-center"><a
                                                                href="agregar_actividad.php?id=<?php echo $id;?>"
                                                                class="btn btn-info btn-block">Agregar
                                                                actividad</a></th>
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php
                                                    }
                                                    else{
                                                        //estan todas cerradas
                                                        ?>
                                                        <th class="text-center" colspan=6></th>
                                                        <?php
                                                        if($row_accion["validado"] == 1 && $row_accion["id_estado"] != 5){
                                                            ?>
                                                        <th class="text-center"><a
                                                                href="agregar_actividad.php?id=<?php echo $id;?>"
                                                                class="btn btn-info btn-block">Agregar
                                                                actividad</a></th>
                                                                <?php
                                                                if($id_usuario_logueado == $row_accion["id_verificador"]){
                                                                    //puedo cerrarla
                                                                    ?>
                                                                    <th class="text-center"><button type="button"
                                                                class="btn btn-success btn-block" onclick="cerrar_accion(<?php echo $id;?>);"> Cerrar
                                                                acción</button></th>
                                                                    <?php
                                                                }
                                                                ?>
                                                        
                                                        <?php
                                                        }
                                                        ?>
                                                        <?php
                                                    }
                                                    ?>

                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row">
                                    <div class="col-md-4 form-group">
                                    <label for="comentarios_cierre" class="control-label"><b><strong>Comentarios de conclusión:</strong></b> </label>
                                    <textarea name="" id="cierre" cols="30" rows="5" readonly class="form-control"><?php echo $row_accion["comentarios_cierre"];?></textarea>
                                    </div>
                                    <div class="col-md-4 form-group">
                                    <label for="comentarios_cierre" class="control-label"><strong><b>Fecha de cierre:</b></strong> </label>
                                    <input type="text" name="" value="<?php echo $row_accion['fecha_cierre'];?>" id="" class="form-control" readonly="readonly">
                                    </div>
                                    <div class="col-md-4 form-group">
                                    <label for="comentarios_cierre" class="control-label"><b><strong>Resultado:</strong></b> </label>

                                    <input type="text" name="" value="<?php echo ($row_accion['resultado'] == 1) ? "Efectiva":"No efectiva";?>" id="" class="form-control" readonly="readonly">
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
                <div id="modal_actividad" class="modal fade" role="dialog">
                    <form action="cerrar_actividad.php" id="frmCerrarActividad" enctype="multiplart/form-data">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Cerrar actividad</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <input type="hidden" name="id_actividad" id="id_actividad">
                                            <input type="hidden" name="action_id" value="<?php echo $id;?>"
                                                id="action_id">
                                            <label for="evidencias" class="control-label"><b><strong>Evidencias:
                                                    </strong></b></label>
                                            <input type="file" name="evidencias[]" id="evidencias" multiple
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="comentarios" class="control-label"><b><strong>Comentarios de
                                                        cierre:
                                                    </strong></b></label>
                                            <textarea name="comentarios_cierre" id="comentarios_cierre" cols="30"
                                                rows="5" class="form-control" required="required"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Cerrar actividad</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- evidencias -->
                <div id="modal_evidencias" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content modal-evidencias-body">

                        </div>

                    </div>
                </div>
                <!-- evidencias -->



                <!-- cerrar accion -->
                <!-- Modal -->
<div id="modal_cerrar_accion" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cerrar acción</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      <div class="row">
      <div class="col-md-12">
      <label for="" class="control-label"><b><strong>La acción resultó: </strong></b></label>
      <input type="hidden" name="id_accion" value="<?php echo $id;?>" id="id_accion_cerrar">
      <select name="resultado_accion" id="resultado_accion" class="form-control">
      <option value="1"><i class="fa fa-check"></i> Efectiva</option>
      <option value="2"><i class="fa fa-check"></i>No efectiva</option>
      </select>
      </div>
      </div>
        <div class="row">
        <div class="col-md-12">
        <label for="comentarios" class="control-label"><b><strong>Comentarios de cierre de acción:</strong></b> </label>
        <textarea name="comentarios_cierre_accion" id="comentarios_cierre" cols="30" rows="3" class="form-control"></textarea>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="cerrar_completo();" >Cerrar acción</button>
      </div>
    </div>

  </div>
</div>
                <!-- cerrar accion -->
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
    <div id="modal_acciones" class="modal fade" role="dialog"></div>
    <?php
    include "../template/footer-js.php";
    ?>
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");
    $('[fechas]').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
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

    function guardar_cambios() {
        var mano = $("[name=mano]").val();
        var medio_ambiente = $("[name=medio_ambiente]").val();
        var material = $("[name=material]").val();
        var metodo = $("[name=metodo]").val();
        var maquinaria = $("[name=maquinaria]").val();
        var analisis = $("[name=analisis]").val();
        $.ajax({
            url: "guardar_cambios.php",
            type: "POST",
            dataType: "json",
            data: {
                'mano': mano,
                'medio': medio_ambiente,
                'material': material,
                'metodo': metodo,
                'maquinaria': maquinaria,
                'analisis': analisis,
                'id': <?php echo $id; ?>
            }
        }).done(function(success) {
            var resultado = success["resultado"];
            if (resultado == "exito") {
                $("[name=mano]").prop("disabled", true);
                $("[name=medio_ambiente]").prop("disabled", true);
                $("[name=material]").prop("disabled", true);
                $("[name=metodo]").prop("disabled", true);
                $("[name=maquinaria]").prop("disabled", true);
                $("[name=analisis]").prop("disabled", true);
                $(".btnGuardar").prop("disabled", true);
                $(".btnGuardar").html("Pendiente de validación");
            } else {

            }
        }).fail(function(error) {
            alert("Error");
        });
    }

    $(".btnActualizar").on("click", function(e) {
        var fecha = $("#fecha_vencimiento").val();
        if(fecha == "" || fecha == null){
            alert("Debes de especificar una fecha válida");
        }
        else{
            $.ajax({
            url: "update_date.php",
            type: "POST",
            dataType: "json",
            data: {
                'date': fecha,
                'id': <?php echo $id; ?>
            }
            }).done(function(success) {
                alert(success["mensaje"]);
            }).fail(function(error) {
                alert("Error");
            });
        }
        
    });
    $(".btnCerrarActividad").on("click", function(e) {
        var elemento = e.target;
        var id = $(elemento).attr("data-id");
        $("#id_actividad").val(id);
        $("#modal_actividad").modal("show");
    });
    $("#frmCerrarActividad").submit(function(e) {
        var fd = new FormData(document.getElementById("frmCerrarActividad"));
        $.ajax({
            url: "cerrar_actividad.php",
            type: "POST",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false // tell jQuery not to set contentType
        }).done(function(respuesta) {
            alert(respuesta);
        }).fail(function(error) {

        });
        e.preventDefault();
        return false;
    });

    function mostrar_evidencias(id) {
        $.ajax({
            url: "evidencias.php",
            type: "POST",
            dataType: "html",
            data: {
                'id': id
            }
        }).done(function(respuesta) {
            $(".modal-evidencias-body").html(respuesta);
            $("#modal_evidencias").modal("show");
        }).fail(function(error) {

        });
    }

    function rechazar(id) {
        var motivo_rechazo = "";
        Swal.fire({
            title: 'Escribe el motivo del rechazo',
            type: 'question',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Rechazar',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "rechazar.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'motivo': result.value,
                        'id': id
                    },
                    beforeSend: function(antes) {
                        $("#btnRechazar_" + id).prop("disabled", true);
                        $("#btnRechazar_" + id).removeClass("btn-danger");
                        $("#btnRechazar_" + id).addClass("btn-disabled");
                        $("#btnRechazar_" + id).html(
                            "<i class='fa fa-spin fa-spinner'></i> Actualizando");
                        $(".btnValidarActividad").prop("disabled", true);
                        $(".btnValidarActividad").removeClass("btn-success");
                        $(".btnValidarActividad").addClass("btn-disabled");
                        $(".btnValidarActividad").html(
                            "<i class='fa fa-spin fa-spinner'></i> Actualizando");
                    }
                }).done(function(success) {
                    alert(JSON.stringify(success));
                    var resultado = success["resultado"];
                    if (resultado == "exito") {
                        $("#modal_evidencias").modal("hide");
                        $(".actividad_" + id).find(".td-estado").html(
                            "<span class='text-danger'><b><strong>Rechazada</strong></b></span>");
                        $(".actividad_" + id).find(".td-accion").html(
                            '<p><b><strong>Motivo: </strong></b>' + result.value +
                            '</p><p><b><strong>Fecha: </strong></b>' + success["fecha"] + '</p>');
                    }
                }).fail(function(error) {
                    alert("Error");
                });
            }
        })
    }

    function liberar(id) {
        var comentarios = "";
        Swal.fire({
            title: 'Escribe algún comentario de cierre',
            type: 'question',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Liberar',
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            allowOutsideClick: () => Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "validar_actividad.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'motivo': result.value,
                        'id': id
                    },
                    beforeSend: function(antes) {
                        $("#btnRechazar_" + id).prop("disabled", true);
                        $("#btnRechazar_" + id).removeClass("btn-danger");
                        $("#btnRechazar_" + id).addClass("btn-disabled");
                        $("#btnRechazar_" + id).html(
                            "<i class='fa fa-spin fa-spinner'></i> Actualizando");
                        $(".btnValidarActividad").prop("disabled", true);
                        $(".btnValidarActividad").removeClass("btn-success");
                        $(".btnValidarActividad").addClass("btn-disabled");
                        $(".btnValidarActividad").html(
                            "<i class='fa fa-spin fa-spinner'></i> Actualizando");
                    }
                }).done(function(success) {
                    var resultado = success["resultado"];
                    alert(success["mensaje"]);
                    if (resultado == "exito") {
                        $("#modal_evidencias").modal("hide");
                        $(".actividad_" + id).find(".td-estado").html(
                            "<span class='text-success'><b><strong>Cerrada</strong></b></span>");
                    }
                }).fail(function(error) {
                    alert("Error");
                });
            }
        })
    }
    function cerrar_accion(id){
        $("#id_accion_cerrar").val(id);
        $("#modal_cerrar_accion").modal("show");
    }
    $("#resultado_accion").select2({
        "width":"100%"
    })

    function cerrar_completo(){
        var id = $("#id_accion_cerrar").val();
        var comentarios = $("#comentarios_cierre").val();
        var resultado = $("#resultado_accion").val();
        $.ajax({
            url:"cerrar.php",
            type:"POST",
            dataType:"html",
            data:{'id':id,'comentarios':comentarios,'resultado':resultado}
        }).done(function(success){
            alert(success);
        }).fail(function(error){
            alert("Error");
        });
    }
    </script>
</body>

</html>