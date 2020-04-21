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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                Listado de periodos escolares
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-12">
                                        <form action="" class="form-inline" id="frmBuscar">
                                            <div class="form-group">
                                                <label for="buscar"
                                                    class="control-label"><b><strong>Buscar:</strong></b> </label>
                                                <input style="margin-left:5px;" autofocus type="search" name="buscar"
                                                    id="buscar" class="form-control" autocomplete="off">
                                                <button style="margin-left:5px;" type="button" onclick="buscar_datos();" class="btn btn-primary"><i
                                                        class="fa fa-search"></i> Buscar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="cuerpo_tabla"
                                                class="table table-hover table-striped table-bordered color-table success-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Periodo</th>
                                                        <th class="text-center">Fecha de inicio</th>
                                                        <th class="text-center">Fecha de cierre</th>
                                                        <th class="text-center">Descripción</th>
                                                        <th class="text-center">Periodos de evaluación</th>
                                                        <th class="text-center">Estado</th>
                                                        <th class="text-center">Editar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_tbody">

                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <nav aria-label="Page navigation example" class="">
                                                    <ul class="pagination justify-content-center pagination-footer">
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="" style="float:right;" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal_alta">Agregar periodo</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    <div id="modal_imagen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="actualizar_imagen.php" method="POST" enctype="multipart/form-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Cambiar imagen del producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id_p_imagen" id="id_p_imagen">
                            <div class="col-md-12">
                                <h4 class="modal-title">Imagen actual</h4>
                                <img class="img img-responsive img-thumbnail" src="../images/productos/2.jpg" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="nueva_imagen" class="control-label">Seleccionar nueva imagen: </label>
                                <input type="file" name="nueva_imagen" id="nueva_imagen" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success waves-effect">Actualizar imagen</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </form>
        <!-- /.modal-dialog -->
    </div>

    <!-- Modal -->
    <div id="modal_alta" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <form action="guardar.php" id="frm_alta">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar periodo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="periodo" class="control-label"><b><strong>Periodo:</strong></b> </label>
                            <input type="text" name="periodo" required id="periodo" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="fecha_inicio" class="control-label"><b><strong>Fecha inicio:</strong></b>
                            </label>
                            <input type="text" name="fecha_inicio" required id="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="fecha_cierre" class="control-label"><b><strong>Fecha de cierre:</strong></b>
                            </label>
                            <input type="text" name="fecha_cierre" required id="fecha_cierre" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="descripcion" class="control-label"><b><strong>Descripción:</strong></b> </label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="4" style="resize:none;"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" type="submit">Agregar periodo</button>
                </div>
            </div>
            </form>

        </div>
    </div>
    <div id="modal_editar" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <form action="guardar.php" id="frm_editar">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar información periodo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="periodo" class="control-label"><b><strong>Periodo:</strong></b> </label>
                            <input type="text" name="periodo" required id="periodo" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="fecha_inicio" class="control-label"><b><strong>Fecha inicio:</strong></b>
                            </label>
                            <input type="text" name="fecha_inicio" required id="fecha_inicio" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="fecha_cierre" class="control-label"><b><strong>Fecha de cierre:</strong></b>
                            </label>
                            <input type="text" name="fecha_cierre" required id="fecha_cierre" class="form-control">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label for="descripcion" class="control-label"><b><strong>Descripción:</strong></b> </label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="4" style="resize:none;"
                                class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" type="submit">Actualizar periodo</button>
                </div>
            </div>
            </form>

        </div>
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
    <script src="funciones.js"></script>
    <script type="text/javascript">
    $(document).attr("title", "<?php echo $modulo_actual;?> - Sistema de Control Interno");

    function cambiar_imagen(id) {
        $("#modal_imagen").modal("show");
        $("#id_p_imagen").val(id);
    }
    function buscar_datos(){
        var criterio = $("#buscar").val();
        fill_table(criterio,1);
    }
    function cambiar_estado(val, id) {
        $.ajax({
            url: "estado.php",
            type: "POST",
            dataType: "json",
            data: {
                'id': id,
                'val': val
            }
        }).done(function(success) {
            var resultado = success["resultado"];
            if (resultado == "exito") {
                $("#row_" + id).find(".estado").removeClass(success["anterior"]);
                $("#row_" + id).find(".estado").html(success["text"]);
                $("#row_" + id).find(".estado").addClass(success["nuevo"]);
                $("#row_" + id).find(".estado").attr("href", "javascript:cambiar_estado(" + success['activo'] +
                    "," + id + ")");
                alertify.success( "Estado actualizado correctamente!.", "success", 4)

            }
        })
    }

    function fill_table(criterio, page) {
        $("#data_tbody").html("");
        $.ajax({
            url: "data.php",
            type: "POST",
            dataType: "json",
            data: {
                'search': criterio,
                'page': page
            }
        }).done(function(success) {
            //creo los registros
            console.log(success);
            var n = 0;
            var paginas = success["num_paginas"];
            for (var i = 0; i < success["count"]; i++) {
                n++;
                var fila = success["data"][i];
                /* console.log(fila); */
                var tr = $("<tr>");
                $(tr).attr("id", "row_" + fila["id_periodo"]);
                var td_1 = $("<td>");
                $(td_1).html(n);
                $(tr).append(td_1);
                $(tr).append("<td>" + fila['periodo'] + "</td>");
                $(tr).append("<td>" + fila['fecha_inicio'] + "</td>");
                $(tr).append("<td>" + fila['fecha_cierre'] + "</td>");
                $(tr).append("<td>" + fila['descripcion'] + "</td>");
                $(tr).append("<td>" + 0 + "</td>");
                if (fila["activo"] == 1) {
                    $(tr).append('<td><a href="javascript:cambiar_estado(' + fila["activo"] + ',' + fila[
                        "id_periodo"] + ');" class="estado btn btn-sm btn-success">Activo</a></td>');
                    $(tr).append('<td><a href="javascript:editar(' + fila["id_periodo"] +
                        ');" class="btn btn-sm btn-info">Editar</a></td>');
                } else {
                    $(tr).append('<td><a href="javascript:cambiar_estado(' + fila["activo"] + ',' + fila[
                        "id_periodo"] + ');" class="estado btn btn-sm btn-danger">Desactivado</a></td>');
                    $(tr).append('<td><button disabled class="btn btn-sm btn-default">Editar</button></td>');
                }
                $(tr).find("td").addClass("text-center");
                $("#data_tbody").append(tr);

            }
            $(".pagination-footer").html("");
            if(page == 1){
                var anterior = "disabled";
                var page_anterior = "#";
            }
            else{
                var anterior = "";
                var nueva = page-1;
                var page_anterior = "javascript:change_page("+nueva+");";
            }
            var page_siguiente = "javascript:change_page("+(page + 1)+");";
            if(success["count"] < 10){
                //no se completa, no hay siguiente
                var siguiente = "disabled";
            }
            $(".pagination-footer").append('<li class="page-item '+anterior+'">' +
                '<a class="page-link" href="'+page_anterior+'" tabindex="-1">Anterior</a>' +
                '</li>');
            for (var j = 1; j <= paginas; j++) {

                $(".pagination-footer").append('<li class="page-item" data-number="'+j+'"><a class="page-link" href="javascript:change_page('+j+');">' + j +
                    '</a></li>');
            }
            $("[data-number="+page+"]").addClass("active");
            $(".pagination-footer").append('<li class="page-item '+siguiente+'">' +
                '<a class="page-link" href="'+page_siguiente+'">Siguiente</a>' +
                '</li>');
        }).fail(function(error) {
            alert("Error");
        })
    }
    $("#frm_alta").submit(function(e){
        $.ajax({
            url:"guardar.php",
            type:"POST",
            dataType:"json",
            data:$(this).serialize()
        }).done(function(success){
            var resultado = success["resultado"];
            if(resultado == "exito"){
                fill_table("",1);
                alertify.success( success["mensaje"], "success", 4)
            }
            $("#modal_alta").modal("hide");
        }).fail(function(error){
            alert(error);
        })
        e.preventDefault();
        return false;
    });
    $('#buscar').keypress(function(event){
	
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		buscar_datos();
	}

});
$("#frmBuscar").submit(function(e){
    e.preventDefault();
    return false;
});
function change_page(page){
    var criterio = $("#buscar").val();
    fill_table(criterio,page);
}
function editar(id){
    $.ajax({
        url:"buscar_data.php",
        type:"POST",
        dataType:"json",
        data:{'id':id}
    }).done(function(success){
        $("#modal_editar").find("#fecha_inicio").val(success["data"]["fecha_inicio"]);
        $("#modal_editar").find("#fecha_cierre").val(success["data"]["fecha_cierre"]);
        $("#modal_editar").find("#periodo").val(success["data"]["periodo"]);
        $("#modal_editar").find("#descripcion").val(success["data"]["descripcion"]);
    $("#modal_editar").modal("show");
    }).fail(function(error){
        alert(error);
    });
    
}
    fill_table("", 1);
    </script>

</body>

</html>