<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
    <?php
    include "../template/metas.php";
    ?>
    <style>
    .nombre-producto{
        font-weight:bold;
        color:#ff0000;
    }
    #iva_total{
        font-weight:bold;
        color:#16781B;
        font-size:20px;
    }
    #subtotal_global{
        font-weight:bold;
        font-size:20px;
        color:#163678;
    }
    #total_global{
        font-weight:bold;
        font-size:20px;
        color:#ff0000;
    }
    .td-referencia{
        vertical-align:middle;
        font-weight:bold;
    }
        .btn-toggle{
            color:#fff;
            font-weight:bold;
            font-size:20px;
        }
        .span-right{
            position: absolute;
            top: 54%;
            right: 15px;
            margin-top: -7px;
        }
        .span-soporte{
            position: absolute;
            top: 61%;
            right: 15px;
            margin-top: -7px;
        }
        .span-puesto{
            position: absolute;
            top: 67%;
            right: 15px;
            margin-top: -7px;
        }

        .border-danger{
            border:2px solid #fc4b6c;
        }
        .border-success{
            border:2px solid #26c6da;
        }
        .txt_saldado{
            font-weight:bold;
            font-size:30px;
            color:#28a745;
            text-align:center;
        }
        .txt_sin_pagar{
            font-weight:bold;
            font-size:30px;
            color:#ff0000;
            text-align:center;
        }
        .cantidad_productos{
            font-weight:bold;
            font-size:20px;
            color:#000000;
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
        
        <div class="">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <br>
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block"><i class="fa fa-search"></i> Buscar producto</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-warning btn-block"><i class="fa fa-money-bill"></i> Sálida de efectivo</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-twitter btn-block"><i class="fa fa-money-bill"></i> Entrada de efectivo</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-facebook btn-block"><i class="fa fa-cash-register"></i> Cobrar</button>
                    </div>
                </div>
                <br>
                <h3 class="text-justify hide nombre-producto">Esperando producto . . . </h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline-success">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Productos
                                </h4>
                                
                            </div>
                            <div class="card-body">
                            <br>
                            <form action="#" id="frmListadoProductos">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped color-table info-table">
                                        <thead>
                                            <tr>
                                                <!-- <th class="text-center">#</th> -->
                                                <th class="text-center">Código</th>
                                                <th class="text-center">Producto</th>
                                                <th class="text-center">Precio de venta</th>
                                                <th class="text-center" style="width:  12%">Precio</th>
                                                <th class="text-center" style="width:  8%">Cantidad</th>
                                                <th class="text-center" style="width:  12%">Total</th>
                                                
                                            </tr>
                                        </thead>
                                        <input type="hidden" name="total_pagar_global">
                                        <tbody id="listado_productos"></tbody>
                                    </table>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                        <div class="card">
                        <div class="card-header">
                                <b><strong>Datos de la venta</strong></b>
                            </div>
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover table-condensed">
                                    <tr class="hide">
                                        <td class="text-left td-referencia" valign="middle">Productos: </td>
                                        <td class="text-center"><input type="text" name="cantidad_productos" readonly value="0" id="cantidad_productos" class="form-control text-center cantidad_productos"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left td-referencia">Subtotal: </td>
                                        <td class="text-center">
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                    <span class="input-group-text"><b><strong>$</strong></b></span>
                                                </span>
                                                <input type="text" name="subtotal" value="0.00" readonly id="subtotal_global" class="form-control text-center">
                                            </div>
                                        </td>
                                    </tr>
                                        <tr>
                                            <td class="text-left td-referencia">IVA: </td>
                                            <td class="text-center">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                        <span class="input-group-text"><b><strong>$</strong></b></span>
                                                    </span>
                                                    <input type="text" name="iva_total" value="0.00" readonly id="iva_total" class="form-control text-center">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left td-referencia">Descuento: </td>
                                            <td class="text-center">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                        <span class="input-group-text"><b><strong>$</strong></b></span>
                                                    </span>
                                                    <input type="text" name="descuento" value="0.00" readonly id="descuento" class="form-control text-center">
                                                </div>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td class="text-left td-referencia">Total: </td>
                                        <td class="text-center">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                        <span class="input-group-text"><b><strong>$</strong></b></span>
                                                    </span>
                                                    <input type="text" name="total_global" value="0.00" readonly id="total_global" class="form-control text-center">
                                                </div>
                                                </td>
                                    </tr>
                                    <tr class="hide">
                                        <td class="text-left td-referencia">Cambio: </td>
                                        <td class="text-center">
                                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                        <span class="input-group-text"><b><strong>$</strong></b></span>
                                                    </span>
                                                    <input type="text" name="cambio" value="0.00" readonly id="cambio" class="form-control text-center">
                                                </div>
                                        </td>
                                    </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <b><strong>Datos generales</strong></b>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            </thead>
                            <tbody>
                            <tr>
                                            <td class="text-left">Venta: </td>
                                            <td class="text-right text-success" id="numero_venta"><b><strong><?php echo "#$id_siguiente_venta";?></strong></b></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" width="15%">Cliente: </td>
                                            <input type="hidden" name="id_cliente_seleccionado" value="1" id="id_cliente_seleccionado">
                                            <td class="text-right text-success">
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                            <input id="txt_nombre_cliente" type="text" value="Ventas al público" readonly  name="tch3"  class="form-control">
                                            <span class="input-group-btn input-group-append">
                                                <button class="btn btn-info btn-outline" type="button" onclick="seleccionar_cliente();" title="Seleccionar cliente" data-toggle="tooltip"><i class="fa fa-user"></i></button>
                                                <button id="btn_info_cliente" class="btn btn-warning btn-outline hide" type="button" title="Ver información del cliente" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
                                            </span>
                                            </div>
                                            </td>
                                        </tr>
                                <tr>
                                    <td class="text-left">Fecha: </td>
                                    <td class="text-right text-info"><b><strong><?php echo date("Y-m-d");?></strong></b></td>
                                </tr>
                                <tr>
                                            <td class="text-left">Atiende: </td>
                                            <td class="text-right "><b><strong><?php echo "Aarón Andrés Rizo Barrera";?></strong></b></td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- capa para el codigo del producto -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <b><strong>Acciones</strong></b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-12">
                                <form action="" id="frmBuscarProducto" class="form-inline">
                                    <label for="codigo" class="control-label">Código: </label> &nbsp;
                                    <input autofocus autocomplete="off" type="text" name="codigo" id="codigo" class="form-control"> &nbsp;
                                    <span id="resultado_producto" class="text-danger"></span>
                            </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- capa para el codigo del producto -->
        </div>
    </div>
    
    <div id="modal_producto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Buscar producto</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="nombre_cliente" class="control-label">Producto: </label>
                                                           
                                                            <input type="text" onkeypress="buscar_producto_form(this,event);" name="criterio_producto" id="criterio_producto" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table-hover table table-bordered color-table success-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-center">Código</th>
                                                                        <th class="text-center">Descripción del producto</th>
                                                                        <th class="text-center">Inventario actual</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbody_productos">
                                                                    <tr>
                                                                        <td class="text-center" colspan=4>Esperando busqueda . . </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancelar</button>
                                                    <button type="button" onclick="agregar_producto_form();" disabled id="btn_seleccionar_producto" class="btn btn-disabled waves-effect" >Agregar producto [ENTER]</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="modal_es" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        
                                    
                                    <!-- /.modal-dialog -->
                                </div>                           
    <div id="modal_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Seleccionar cliente para la venta</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="nombre_cliente" class="control-label">Cliente: </label>
                                                           
                                                            <input type="text" onkeypress="buscar_cliente(this,event);" name="nombre_cliente" id="nombre_cliente" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table-hover table table-bordered color-table success-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="10%" class="text-center"><i class="fa fa-check"></i></th>
                                                                        <th class="text-center">Cliente</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="tbody_clientes">
                                                                    <tr>
                                                                        <td class="text-center" colspan=2>Escribe el cliente a buscar</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancelar</button>
                                                    <button type="button" onclick="guardar_cliente();" disabled id="btn_guardar_cliente" class="btn btn-disabled waves-effect" >Seleccionar cliente</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    
                                    <!-- /.modal-dialog -->
                                </div>

                                <div id="modal_cerrar_venta" class="modal fade bs-example-modal-lg" data-keyboard="false" and data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <form action="cerrar_venta.php" id="frmCerrarVenta" method="POST" enctype="multipart/form-data" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Cerrar venta</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="metodo_pago" class="control-label">Método de pago: </label>
                                                            <select name="id_metodo_pago" id="id_metodo_pago" class="form-control">
                                                                <?php
                                                                $metodos = $conexion->query("SELECT id_metodo_pago,metodo_pago
                                                                FROM metodos_pagos
                                                                WHERE activo = 1");
                                                                while($row_data = $metodos->fetch(PDO::FETCH_ASSOC)){
                                                                    ?>
                                                                    <option value="<?php echo $row_data['id_metodo_pago'];?>"><?php echo $row_data['metodo_pago'];?></option>
                                                                    <?php
                                                                };
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="total_pagar" class="control-label text-info"><b>Total a pagar:</b> </label>
                                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                                <span class="input-group-text"><b>$</b></span>
                                                                </span>
                                                                <input id="txt_pagar" type="text" value="" readonly name="tch2" class="form-control" >
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="abonado" class="control-label text-success"><b>Pago con:</b> </label>
                                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                                <span class="input-group-text"><b>$</b></span>
                                                                </span>
                                                                <input type="number" step="any"  id="txt_campo_pagar" onkeyup="calcular_restante();" name="pagado" class="form-control" >
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label for="abonado" class="control-label text-warning"><b>Su cambio:</b> </label>
                                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend">
                                                                <span class="input-group-text"><b>$</b></span>
                                                                </span>
                                                                <input type="text" readonly  id="restante" name="restante" class="form-control" >
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="btn_close_modal_venta" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" id="btn_cerrar_venta" disabled class="btn btn-disabled waves-effect" >Cerrar venta [ENTER]</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </form>
                                    <!-- /.modal-dialog -->
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
    <script src="../assets/plugins/shortcut/shortcut.js"></script>
    <script type="text/javascript">
        buscar_numero_venta();
        $(".sidebartoggler").click();
        $(document).attr("title","<?php echo $modulo_actual;?> - Sistema de Control Interno");
        $("#frmBuscarProducto").submit(function(e){
            buscar_producto();
            e.preventDefault();
            return false;
        });
        $("#modal_cerrar_venta").on('shown.bs.modal', function(){
        $(this).find('#txt_pagar_campo_pagar').focus();
    });
        
    </script>
    <script type="text/javascript">
      shortcut.add("F4", function () {
        $("#modal_producto").modal("show");
        shortcut.add("ENTER", function () {
            agregar_producto_form();
        }, {
            "type": "keydown",
            "propagate": true,
            "disable_in_input":true,
            "target": document.getElementById("modal_producto")
        });
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      shortcut.add("F2", function () {
        $("#codigo").focus();
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      shortcut.add("ALT+S", function () {
        abrir_modal_es("salida");
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      shortcut.add("ALT+E", function () {
          abrir_modal_es("entrada");
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      shortcut.add("DELETE", function () {
        eliminar_producto();  
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      shortcut.add("F10", function () {
          //se va a cobrar
          var total_pagar = $("#total_global").html();
          total_pagar = parseFloat(total_pagar.replace('$',''));
          $("#txt_pagar").val(total_pagar.toFixed(2));
       $("#modal_cerrar_venta").modal("show");
      }, {
        "type": "keydown",
        "propagate": true,
        "target": document
      });
      function calcular_restante(){
          var abonado = parseFloat($("#txt_campo_pagar").val());
          var total_pagar =  parseFloat($("#txt_pagar").val());
          var restante = abonado - total_pagar;
          if(isNaN(restante) == true){
              $("#restante").val("0.00");
          }
          
          else if(restante < 0){
              $("#btn_cerrar_venta").prop("disabled",true);
              $("#btn_cerrar_venta").removeClass("btn-success");
              $("#btn_cerrar_venta").addClass("btn-disabled");
              $("#restante").addClass("txt_sin_pagar");
              $("#restante").addClass("border-danger");
              $("#restante").val(restante.toFixed(2));
          }
          else{
            $("#btn_cerrar_venta").prop("disabled",false);
            $("#btn_cerrar_venta").removeClass("btn-disabled");
              $("#btn_cerrar_venta").addClass("btn-success");
              $("#restante").removeClass("txt_sin_pagar");
              $("#restante").addClass("txt_saldado");
              $("#restante").removeClass("border-danger");
              $("#restante").addClass("border-success");
              $("#restante").val(restante.toFixed(2));
          }
          
      }
      $("#frmCerrarVenta").submit(function(e){
          var formulario = document.getElementById("frmListadoProductos");
          var formDataEnviar = new FormData(formulario);
          var id_cliente = $("#id_cliente_seleccionado").val();
          formDataEnviar.append("id_cliente_seleccionado",id_cliente);
          var cantidad_productos = parseInt($("#cantidad_productos").html());
          var abonado = parseFloat($("#txt_campo_pagar").val());
          var restante = parseFloat($("#restante").val());
          var id_metodo_pago = $("#id_metodo_pago").val();
          formDataEnviar.append("id_metodo_pago",id_metodo_pago);
          formDataEnviar.append("cantidad_productos",cantidad_productos);
          formDataEnviar.append("abonado",abonado);
          formDataEnviar.append("restante",restante);

          var division = $("#total_global").html().split("$");
          var total_global = parseFloat(division[1]);
          formDataEnviar.append("total_global",total_global);
          $("#btn_cerrar_venta").html('<i class="fas fa-spinner fa-spin"></i> Guardando venta');
          $("#btn_cerrar_venta").prop("disabled",true);
          $("#btn_cerrar_venta").removeClass("btn-sucecss");
          $("#btn_cerrar_venta").addClass("btn-info");
          $("#btn_close_modal_venta").hide();
          $.ajax({
              url:"cerrar_venta.php",
              type:"POST",
              dataType:"json",
              data: formDataEnviar,
                processData: false,  // tell jQuery not to process the data
                contentType: false 
          }).done(function(success){
              var resultado = success["resultado"];
              if(resultado == "exito"){
                  $("#modal_cerrar_venta").modal("hide");
                  //limpio la tabla
                  $("#listado_productos tr").remove();
                  //cambio la cantidad de productos a 0;
                  id_cliente_seleccionado = 1;
                  $("#resultado_producto").html("");
                        $("#cantidad_productos").html("0");
                        $("#total_global").html("$0.00");
                        //busco la siguiente codigo de venta
                        buscar_numero_venta();
                        $("#btn_cobrar").prop("disabled",true);
                        $("#btn_cobrar").removeClass("btn-success");
                        $("#btn_cobrar").addClass("btn-disabled");
                        $("#id_cliente_seleccionado").val("1");
                        //limpio el campo del codigo y mando el foco
                        $("#codigo").val("");
                        $("#codigo").focus();
                $.toast({
                    heading: "Venta generada correctamente",
                    position: 'bottom-center',
                    icon: "success",
                    hideAfter: 3000, 
                    stack: 1,
                    allowToastClose: false,
                    afterHidden: function () {
                        
                        $("#codigo").removeClass("border-success");
                        $("#codigo").focus();
                    }
                });
                  //la venta se realizo correctamente
              }
              $("#resultado_aa").html(success);
          }).fail(function(error){
              alert()
          });
          e.preventDefault();
          return false;
      });
    </script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
<script>
    /* $.contextMenu({
    selector: '.filas_productos', 
    callback: function(key, options) {
        var m = "clicked: " + key;
        window.console && console.log(m) || alert(m); 
    },
    items: {
        "delete": {name: "Eliminar producto", icon: "delete"},
        "sep1": "---------",
        "quit": {name: "Quit", icon: function($element, key, item){ return 'context-menu-icon context-menu-icon-quit'; }}
    }
}); */
$("#frmGenerarSalida").submit(function(e){
    alert("salida");
    e.preventDefault();
    return false;
});
</script>
</body>
</html>