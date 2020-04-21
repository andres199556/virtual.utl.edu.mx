<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../template/metas.php";
    ?>
    <style>
    .btn-toggle {
        color: #fff;
        font-weight: bold;
        font-size: 20px;
    }

    .span-right {
        position: absolute;
        top: 54%;
        right: 15px;
        margin-top: -7px;
    }

    .span-soporte {
        position: absolute;
        top: 61%;
        right: 15px;
        margin-top: -7px;
    }

    .span-puesto {
        position: absolute;
        top: 67%;
        right: 15px;
        margin-top: -7px;
    }
    </style>
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/fontawesome.css">
    <link rel="stylesheet" href="../material/css/icons/font-awesome2/css/all.css">
    <link rel="stylesheet" href="../assets/plugins/diagramjs/diagram-editor/codebase/diagram-editor.css">
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $categoria_actual;?></a>
                            </li>
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center">Organigramas</h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group lstOrganigramas">

                                    <?php



                                    $buscar = $conexion->query("SELECT id_organigrama,nombre_organigrama FROM organigramas WHERE activo = 1 ORDER BY nombre_organigrama ASC");

                                    while($row = $buscar->fetch(PDO::FETCH_ASSOC)){

                                        
                                        ?>
                                    <a id="lstOrganigrama<?php echo $row['id_organigrama'];?>"
                                        href="javascript:ver(<?php echo $row['id_organigrama'];?>,'<?php echo $row["nombre_organigrama"];?>');"
                                        class="list-group-item "><i class="fa fa-sitemap"></i>
                                        <?php echo $row['nombre_organigrama'];?></a>
                                    <?php
                                    }
                            ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <?php
                            if($permiso_acceso == 1){
                                
                                ?>
                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                    data-target="#modal_agregar_organigrama">Agregar organigrama</button>
                                <?php
                            }
                            ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center lblOrganigrama">Organigrama: </h4>
                            </div>
                            <div class="card-body">

                                <div id="diagram_container">
                                </div>
                                <div id="diagram_editor">

                                </div>
                            </div>
                            <div class="card-footer">
                                <?php
                               if($permiso_acceso == 1){
                                   ?>
                                <div style="float:right;">
                                    <button class="btn btn-info hide" id="btnAddPrimerNodo"><i class="fa fa-plus"></i>
                                        Agregar primer nodo</button>
                                    <button class="btn btn-warning hide" id="btnEditarOrganigrama"><i
                                            class="fa fa-edit"></i>
                                        Editar organigrama</button>
                                    <button class="btn btn-danger hide" id="btnEliminarOrganigrama"><i
                                            class="fa fa-times"></i> Eliminar organigrama</button>
                                </div>
                                <?php
                               }
                               ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================== -->
                <!-- ============================================================== -->

                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- End PAge Content -->
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
    <!-- Trigger the modal with a button -->


    <!-- Modal -->
    <form action="agregar_organigrama.php" method="post" id="altaOrganigrama">
        <div id="modal_agregar_organigrama" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar organigrama</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="nombre_organigrama" class="control-label">Nombre del organigrama: </label>
                                <input type="text" required name="nombre_organigrama" id="nombre_organigrama"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <form action="add_node.php" method="post" id="frmAgregarNodo">
        <div id="modal_agregar_nodo" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar nodo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_organigrama">
                            <input type="hidden" name="id_node_sup">
                            <div class="col-md-12 form-group">
                                <label for="nombre_organigrama" class="control-label">Trabajador: </label>
                                <select name="id_trabajador" id="trabajador" class="form-control">
                                    <?php
                                    $trabajadores = $conexion->query("SELECT id_trabajador,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as trabajador
                                    FROM trabajadores as T
                                    INNER JOIN personas as P ON T.id_persona = P.id_persona
                                    WHERE T.activo = 1 AND P.activo = 1");
                                    while($row_t = $trabajadores->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                    <option value="<?php echo $row_t['id_trabajador'];?>">
                                        <?php echo $row_t['trabajador'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="puesto" class="control-label"><b><strong>Puesto: </strong></b></label>
                                <select name="puesto" id="puesto" class="form-control">
                                    <?php
                                    $puestos = $conexion->query("SELECT id_puesto,puesto FROM puestos WHERE activo = 1");
                                    while($row_p = $puestos->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                    <option value="<?php echo $row_p['id_puesto'];?>"><?php echo $row_p['puesto'];?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Agregar nodo</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <form action="update_node.php" method="post" id="frmActualizarNodo">
        <div id="modal_editar_nodo" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar nodo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_organigrama_edit">
                            <input type="hidden" name="id_node_sup_edit">
                            <div class="col-md-12 form-group">
                                <label for="nombre_organigrama" class="control-label">Trabajador: </label>
                                <select name="id_trabajador" id="trabajador_edit" class="form-control">
                                    <?php
                                    $trabajadores = $conexion->query("SELECT id_trabajador,CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as trabajador
                                    FROM trabajadores as T
                                    INNER JOIN personas as P ON T.id_persona = P.id_persona
                                    WHERE T.activo = 1 AND P.activo = 1");
                                    while($row_t = $trabajadores->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                    <option value="<?php echo $row_t['id_trabajador'];?>">
                                        <?php echo $row_t['trabajador'];?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="puesto" class="control-label"><b><strong>Puesto: </strong></b></label>
                                <select name="puesto" id="puesto_edit" class="form-control">
                                    <?php
                                    $puestos = $conexion->query("SELECT id_puesto,puesto FROM puestos WHERE activo = 1");
                                    while($row_p = $puestos->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                    <option value="<?php echo $row_p['id_puesto'];?>"><?php echo $row_p['puesto'];?>
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="color" class="control-label">Color: </label>
                                <input type="color" name="color_edit" id="color_edit" class="form-control">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="comentarios" class="control-label">Comentarios: </label>
                                <textarea name="comentarios" id="comentarios_edit" cols="30" rows="5"
                                    style="resize:none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Actualizar nodo</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <?php
    include "../template/footer-js.php";
    ?>
    <!-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> -->
    <script src="../assets/plugins/diagramjs/diagram-editor/codebase/diagram-editor.js"></script>
    <script src="funciones.js"></script>
    <script>
    var diagram;
    $("#altaOrganigrama").submit(function(e) {
        $.ajax({
            url: "agregar_organigrama.php",
            type: "POST",
            dataType: "json",
            data: $(this).serialize()
        }).done(function(exito) {
            var resultado = exito["resultado"];
            if (resultado == "exito") {
                var id = exito["id"];
                var nombre = exito["nombre"];
                $(".lstOrganigramas").append('<a id="lstOrganigrama' + id + '" href="javascript:ver(' +
                    id + ',\'' + nombre +
                    '\');" class="list-group-item " ><i class="fa fa-sitemap"></i> ' + nombre +
                    '</a> ');
                //se inserto correctament$("#)
                $("#modal_agregar_organigrama").modal("hide");
                $("#nombre_organigrama").val("");

            }
        }).fail(function(error) {
            alert("Error");
        });
        e.preventDefault();
        return false;
    });

    function ver(id, nombre) {
        $.ajax({
            url: "ver_organigrama.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id
            }
        }).done(function(exito) {

            var resultado = exito["resultado"];
            $(".lblOrganigrama").html("Organigrama: " + nombre);
            $("#btnEditarOrganigrama").removeClass("hide");
            $("#btnEditarOrganigrama").attr("onclick", "editar_organigrama(" + id + ");");
            $("#btnEliminarOrganigrama").attr("onclick", "eliminar_organigrama(" + id + ");");
            $("#btnEliminarOrganigrama").removeClass("hide");
            if (resultado == "primer_nodo") {

                $("#diagram_container").html(
                    "<p class='text-center'>Todavía no existen nodos para este organigrama.</p>")
                $("#btnAddPrimerNodo").removeClass("hide");
                $("#btnAddPrimerNodo").attr("onclick", "agregar_nodo(" + id + ",0);");
            } else if (resultado == "existe") {
                $("#diagram_container").html("");
                $("#btnAddPrimerNodo").addClass("hide");
                diagram = new dhx.Diagram("diagram_container", {
                    type: "org",
                    defaultShapeType: "img-card",
                    select: true,
                    toolbar: [

                        {
                            id: "add",
                            content: "<i class='fa fa-plus-square'></i>"
                        },
                        {
                            id: "edit",
                            content: "<i class='fa fa-edit'></i>"
                        },
                        {
                            id: "delete",
                            content: "<i class='dxi dxi-delete'></i>"
                        },
                        {
                            id: "info",
                            content: "<i class='dxi dxi-information-outline'></i>"
                        }
                    ]
                });
                diagram.events.on("ShapeIconClick", function(icon) {
                    var id_node = diagram.selection.getId();
                    switch (icon) {
                        case "add":
                            agregar_nodo(id, id_node);
                            break;
                        case "delete":
                            eliminar_nodo(id_node);
                            break;
                        case "edit":
                            editar_nodo(id, id_node);
                            break;
                        case "info":
                            info_nodo(id_node);
                            break;
                    }
                });
                diagram.data.parse(exito["data"]);
            }
        }).fail(function(error) {
            alert("Error");
        })
    }

    function agregar_nodo(id, posicion) {
        $("[name=id_organigrama]").val(id);
        $("[name=id_node_sup]").val(posicion);
        $("#modal_agregar_nodo").modal("show");
    }

    function editar_nodo(id, posicion) {
        $.ajax({
            url: "buscar_edit.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': posicion
            }
        }).done(function(exito) {
            var resultado = exito["resultado"];
            var id_trabajador = exito["data"]["id_trabajador"];
            var id_puesto = exito["data"]["id_puesto"];
            var color = exito["data"]["color"];
            var comentarios = exito["data"]["comentarios"];
            /* $("#puesto_edit").select2("destroy"); */
            $("#trabajador_edit").val(id_trabajador);
            $("#puesto_edit").val(id_puesto);
            $("#color_edit").val(color);
            $("#comentarios_edit").val(comentarios);
            $("[name=id_organigrama_edit]").val(id);
            $("[name=id_node_sup_edit]").val(posicion);
            $("#modal_editar_nodo").modal("show");

        }).fail(function(error) {
            alert("Error");
        })

    }
    /* $("select").select2({
        width: "100%"
    }); */
    $("#frmAgregarNodo").submit(function(e) {
        $.ajax({
            url: "add_node.php",
            type: "POST",
            dataType: "json",
            data: $(this).serialize()
        }).done(function(exito) {
            var nodo_sup = $("[name=id_node_sup]").val();
            if (nodo_sup != 0) {
                //es un nodo secundario
                diagram.data.add({
                    id: exito["node"],
                    text: exito["puesto"],
                    title: exito["trabajador"],
                    parent: nodo_sup,
                    img: exito["fotografia"]
                });
                var notification = alertify.notify('Nodo agregado correctamente', 'success', 4,
                    function() {
                        console.log('dismissed');
                    });
                $("#modal_agregar_nodo").modal("hide");
            } else {
                //es el primer nodo
                $("#diagram_container").html("");
                diagram = new dhx.Diagram("diagram_container", {
                    type: "org",
                    defaultShapeType: "img-card",
                    select: true,
                    toolbar: [

                        {
                            id: "add",
                            content: "<i class='fa fa-plus-square'></i>"
                        },
                        {
                            id: "edit",
                            content: "<i class='fa fa-edit'></i>"
                        },
                        {
                            id: "delete",
                            content: "<i class='dxi dxi-delete'></i>"
                        },
                        {
                            id: "info",
                            content: "<i class='dxi dxi-information-outline'></i>"
                        }
                    ]
                });
                diagram.events.on("ShapeIconClick", function(icon) {
                    var id_node = diagram.selection.getId();
                    switch (icon) {
                        case "add":
                            agregar_nodo(id, id_node);
                            break;
                        case "delete":
                            eliminar_nodo(id_node);
                            break;
                        case "edit":
                            editar_nodo(id, id_node);
                            break;
                        case "info":
                            info_nodo(id_node);
                            break;
                    }
                });
                var datos = [{
                    id: exito["node"],
                    text: exito["puesto"],
                    title: exito["trabajador"],
                    img: exito["fotografia"]
                }];
                diagram.data.parse(datos);
                $("#modal_agregar_nodo").modal("hide");
                $("#btnAddPrimerNodo").addClass("hide");
                var notification = alertify.notify('Nodo agregado correctamente', 'success', 4,
                function() {
                    
                });

            }
        }).fail(function(error) {

        });
        e.preventDefault();
        return false;
    });
    $("#frmActualizarNodo").submit(function(e) {
        $.ajax({
            url: "update_node.php",
            type: "POST",
            dataType: "json",
            data: $(this).serialize()
        }).done(function(exito) {
            diagram.data.update(28, {
                text: exito["puesto"],
                title: exito["trabajador"],
                color: exito["color"],
                img: exito["fotografia"]
            });
            var notification = alertify.notify('Nodo actualizado correctamente', 'success', 4,
                function() {
                    console.log('dismissed');
                });
            $("#modal_editar_nodo").modal("hide");
        }).fail(function(error) {

        });
        e.preventDefault();
        return false;
    });

    function eliminar_nodo(id) {
        Swal.fire({
            title: 'Eliminar nodo',
            text: "Haz clic en confirmar para eliminar este nodo del organigrama, de lo contrario haz clic en cancelar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#AAA9A8',
            confirmButtonText: 'Eliminar',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                //elimino el nodo
                $.ajax({
                    url: "delete_node.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'id_node': id
                    }
                }).done(function(exito) {
                    var resultado = exito["resultado"];
                    if (resultado == "exito") {
                        diagram.data.remove(id);
                        var notification = alertify.notify('Nodo eliminado correctamente.', 'error', 4,
                            function() {
                                console.log('dismissed');
                            });
                    }
                }).fail(function(error) {
                    alert("Error");
                })
            }
        })
    }

    function eliminar_organigrama(id) {
        Swal.fire({
            title: '¿Eliminar organigrama?',
            text: "Haz clic en confirmar para eliminar todo el organigrama junto con los nodos, de lo contrario haz clic en cancelar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#AAA9A8',
            confirmButtonText: 'Eliminar',
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.value) {
                //elimino el organigrama
                $.ajax({
                    url: "delete_organigrama.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        'id': id
                    }
                }).done(function(exito) {
                    var resultado = exito["resultado"];
                    if (resultado == "exito") {
                        $(".lblOrganigrama").html("Organigrama");
                        $("#diagram_container").html("");
                        $("#btnEditarOrganigrama").addClass("hide");
                        $("#btnEliminarOrganigrama").addClass("hide");
                        $("#btnAddPrimerNodo").addClass("hide");
                        $("#lstOrganigrama" + id).remove();
                        var notification = alertify.notify('Organigrama eliminado correctamente.',
                            'error', 4,
                            function() {
                                console.log('dismissed');
                            });
                    }
                }).fail(function(error) {
                    alert("Error");
                })
            }
        })
    }
    </script>

</body>

</html>