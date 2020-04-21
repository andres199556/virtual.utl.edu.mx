var id_cliente_seleccionado = 0;
var nombre_cliente_seleccionado = 0;
var contador_productos = 0;
function buscar_producto(){
    var codigo = $("#codigo").val();
    if(codigo == ""){
        $("#codigo").focus();
    }
    else{
        var cantidad_multiplicar = 1;
        var existe_multiplicacion = codigo.indexOf('*');
        if(existe_multiplicacion == -1){
            cantidad_multiplicar = 1;
        }
        else{
            var arrayDeCadenas = codigo.split("*");
            codigo = arrayDeCadenas[1];
            cantidad_multiplicar = parseInt(arrayDeCadenas[0]);
        }
        $.ajax({
            url:"producto.php",
            type:"POST",
            dataType:"json",
            data:{'codigo':codigo}
        }).done(function(respuesta){
            var existe = parseInt(respuesta["existe"]);
            if(existe == 0){
                $("#codigo").removeClass("border-success");
                $("#codigo").addClass("border-danger");
                $("#codigo").val("");
                $("#resultado_producto").html('<i class="fa fa-times-circle text-danger"></i> <b><strong> No existe un producto con este código</strong></b>')
                $.toast({
                    heading: "Articulo no encontrado",
                    position: 'bottom-center',
                    icon: "error",
                    hideAfter: 3000, 
                    stack: 1,
                    allowToastClose: false,
                    afterHidden: function () {
                        $("#resultado_producto").html("");
                        $("#codigo").removeClass("border-danger");
                    }
                });
            }
            else{
                $("#codigo").removeClass("border-danger");
                $("#codigo").addClass("border-success");
                
                $("#resultado_producto").html(' ')
                /* var cantidad_actual_productos = $("#cantidad_productos").html();
                var numero = parseInt(cantidad_actual_productos);
                var nueva = numero + 1;
                $("#cantidad_productos").html(nueva); */
                var id_producto = respuesta["id_producto"];
                var imagen_producto = respuesta["imagen_producto"];
                /* $("#imagen_producto").attr("src",imagen_producto); */
                //busco si ya existe una fila asi
                var fila = $("#fila_producto_"+id_producto);
                if(fila.length){
                    //ya existe, por lo tanto solo agrego uno mas a la cantidad
                    var cantidad_actual = parseInt($("#input_cantidad_producto_"+id_producto).val());
                    var nueva_cantidad = cantidad_actual + cantidad_multiplicar;
                    $("#input_cantidad_producto_"+id_producto).val(nueva_cantidad);
                    $("#codigo").val("");
                    $("#codigo").focus();
                    calcular_precio_producto(id_producto);
                }
                else{
                    //quito la clase de los colores
                    $(".filas_productos").removeClass("table-info");
                    var cantidad_filas = $(".filas_productos").length;
                    var nombre = respuesta["nombre_producto"];
                    $(".nombre-producto").html(nombre);
                    var iva = respuesta["iva"];
                    //array de precios
                    var precios = respuesta["precios"];
                    contador_productos++;
                    var fila = $("<tr>");
                    $(fila).attr("id","fila_producto_"+id_producto);
                    $(fila).addClass("filas_productos");
                    $(fila).addClass("table-info");
                    var td_numero = $("<td>");
                    $(td_numero).html(contador_productos);
                    $(td_numero).addClass("text-center");
                    //codigo
                    //nombre del producto
                    var td_codigo = $("<td>");
                    $(td_codigo).html(codigo);
                    $(td_codigo).addClass("text-center");
                    //nombre del producto
                    var td_nombre = $("<td>");
                    $(td_nombre).html(nombre);
                    $(td_nombre).addClass("text-center");

                    //creo el select de los precios
                    var td_select_precios = $("<td>");
                    $(td_select_precios).addClass("text-center");

                    var select_precios = $("<select>");
                    $(select_precios).addClass("form-control");
                    $(select_precios).attr("onchange","mostrar_precio_venta("+id_producto+")");
                    $(select_precios).attr("id","select_precios_producto_"+id_producto);
                    $(select_precios).attr("name","id_precios_seleccionados[]");
                    $(td_select_precios).html(select_precios);
                    
                    //$(fila).append(td_numero);
                    $(fila).append(td_codigo);
                    $(fila).append(td_nombre);

                    var cantidad_precios = precios.length;
                    for(var i = 0;i<cantidad_precios;i++){
                        var id_precio = precios[i]["id_precio"];
                        var nombre_precio = precios[i]["nombre_precio"];
                        var precio = precios[i]["precio"];
                        //creo el option
                        var option = $("<option>");
                        $(option).attr("value",id_precio);
                        $(option).attr("data-price",precio);
                        $(option).html(nombre_precio);
                        $(select_precios).append(option);
                    }
                    var td_input_precio = $("<td>");
                    $(td_input_precio).html('<input type="hidden" ivas_globales name="iva_precio_producto_'+id_producto+'" value="'+iva+'"><input type="hidden" iva_producto_'+id_producto+' name="iva_producto_'+id_producto+'" value="'+iva+'"><input type="hidden" id_productos name="id_productos[]" value="'+id_producto+'"><input type="number" name="valores_precios[]" readonly id="input_precio_'+id_producto+'" step="any" class="form-control">');
                    $(td_input_precio).addClass("text-center");

                    //creo el td de la cantidad
                    var td_cantidades = $("<td>");
                    $(td_cantidades).html('<input type="number" valores_cantidades min=1 name="valores_cantidades[]" onkeypress="detectar_simbolo(this,event,'+id_producto+')"; onchange="calcular_precio_producto('+id_producto+');" value='+cantidad_multiplicar+' id="input_cantidad_producto_'+id_producto+'" step="any" min=1 class="form-control">');
                    $(td_cantidades).addClass("text-center");

                    //creo el td de los totales
                    var td_totales = $("<td>");
                    $(td_totales).html('<input type="number" valores_totales name="valores_totales[]" id="input_total_producto_'+id_producto+'" step="any" readonly class="form-control">');
                    $(td_totales).addClass("text-center");
                    $(fila).append(td_select_precios);
                    $(fila).append(td_input_precio);
                    $(fila).append(td_cantidades);
                    $(fila).append(td_totales);
                    $("#listado_productos").append(fila);
                    $("#codigo").val("");
                    $("#codigo").focus();
                    //mando imprimir el precio en base al precio de lista
                    mostrar_precio_venta(id_producto);
                }
            }
        }).fail(function(error){
            alert("Error");
        });
    }
}
function mostrar_precio_venta(id_producto){
    var option = $("#select_precios_producto_"+id_producto+" option:selected");
    var precio = parseFloat($(option).attr("data-price"));
    $("#input_precio_"+id_producto).val(precio.toFixed(2));
    calcular_precio_producto(id_producto);
}

function calcular_precio_producto(id_producto){
    var precio_producto = $("#input_precio_"+id_producto).val();
    var cantidad = $("#input_cantidad_producto_"+id_producto).val();
    var total = parseFloat(precio_producto * cantidad);
    $("#input_total_producto_"+id_producto).val(total.toFixed(2));
    totales_globales();
}

function totales_globales(){
    var totales = $("[valores_totales]");
    var acumulador = 0;
    var cantidad = totales.length;
    for(var i = 0;i<cantidad;i++){
        var campo_total = parseFloat($(totales).eq(i).val());
        acumulador = acumulador + campo_total;
        //acumulador+=campo_total.toFixed(2);
    }
    acumulador_global = parseFloat(acumulador).toFixed(2);
    $("#total_global").val(acumulador_global);
    $("#subtotal_global").val(acumulador_global);
    calcular_cantidades_productos();
}


function calcular_cantidades_productos(){
    var acumulador = 0;
    var cantidades = $("[valores_cantidades]");
    var longitud = cantidades.length;
    for(var i = 0;i<longitud;i++){
        var cantidad = parseInt($(cantidades).eq(i).val());
        acumulador+=cantidad;
    }
    if(acumulador == 0){
        $("#btn_cobrar").prop("disabled",true);
        $("#btn_cobrar").removeClass("btn-outline-success");
        $("#btn_cobrar").addClass("btn-outline-disabled");
    }
    else{
        $("#btn_cobrar").removeClass("btn-outline-disabled");
        $("#btn_cobrar").addClass("btn-outline-success");
        $("#btn_cobrar").prop("disabled",false);
    }
    $("#cantidad_productos").val(acumulador);
}

function detectar_simbolo(elemento,e,id_producto){
    var cantidad = parseInt($(elemento).val());
    var codigo = e.keyCode;
    if(cantidad == 1 && codigo == 45){
        e.preventDefault();
    }
    else{
        if(codigo == 43){
            cantidad++;
            //cambio el valor
            $(elemento).val(cantidad);
            calcular_precio_producto(id_producto);
            e.preventDefault();
            
        }
        else if(codigo == 45){
            --cantidad;
            //cambio el valor
            $(elemento).val(cantidad);
            calcular_precio_producto(id_producto);
            e.preventDefault();
            
        }
    }
    
 
}

function seleccionar_cliente(){
    $("#modal_cliente").modal("show");
}

function buscar_cliente(elemento,e){
    var keyC = e.keyCode;
    if(keyC == 13){
        var cliente = $("#nombre_cliente").val();
        $.ajax({
            url:"buscar_cliente.php",
            type:"POST",
            dataType:"json",
            data:{'cliente':cliente}
        }).done(function(success){
            var existe = success["existe"];
            if(existe == 0){
                $("#tbody_clientes").html('<tr> '+
                '<td class="text-center text-danger" colspan=2><b><strong>No existen clientes con ese nombre</b></strong></td>'+
            '</tr>');
            }
            else{
                $("#tbody_clientes tr").remove();
                for(var i= 0;i<existe;i++){
                    var id_cliente = success["data"][i]["id_cliente"];
                    var cliente = success["data"][i]["cliente"];
                    //creo el tr
                    var fila = $("<tr>");
                    $(fila).attr("onclick","seleccionar_fila("+id_cliente+");");
                    $(fila).attr("id","fila_cliente_"+id_cliente);
                    $(fila).css("cursor","pointer");
                    var celda_check = $("<td>");
                    $(celda_check).addClass("text-center");
                    $(celda_check).html('<input type="checkbox" campo id="campo_seleccionar_'+id_cliente+'" class="filled-in" value="'+id_cliente+'">' +
                    '<label for="campo_seleccionar_'+id_cliente+'"></label>');
                    var celda_nombre = $("<td>");
                    $(celda_nombre).addClass("text-center td-nombre");
                    $(celda_nombre).html(cliente);
                    $(fila).append(celda_check);
                    $(fila).append(celda_nombre);
                    $("#tbody_clientes").append(fila);
                }
            }

        }).fail(function(error){

        });
        
    }
    else{

    }
    
}

function seleccionar_fila(id_cliente){
    limpiar_check(id_cliente);
    //busco el campo
    var cantidad = $("#fila_cliente_"+id_cliente).find("input[type=checkbox]");
    var estado = $(cantidad).eq(0).prop("checked");
    if(estado == false){
        $(cantidad).eq(0).prop("checked",true);
        $("#btn_guardar_cliente").prop("disabled",false);
        $("#btn_guardar_cliente").removeClass("btn-disabled");
        $("#btn_guardar_cliente").addClass("btn-success");
    }
    else{
        $(cantidad).eq(0).prop("checked",false);
        $("#btn_guardar_cliente").removeClass("btn-success");
        $("#btn_guardar_cliente").addClass("btn-disabled");
    }
    
}

function limpiar_check(id_cliente){
    var filas = $("#tbody_clientes").find("tr");
    for(var i = 0;i<filas.length;i++){
        var fila = $(filas).eq(i);
        var campo = $(fila).find("[campo]").prop("checked",false);
    }
}

function guardar_cliente(){
    id_cliente_seleccionado = $("#tbody_clientes").find("[campo]:checked").val();
    nombre_cliente_seleccionado = $("[campo]:checked").parents("tr").find(".td-nombre").html();
    $("#txt_nombre_cliente").val(nombre_cliente_seleccionado);
    $("#btn_info_cliente").removeClass("hide");
    $("#btn_info_cliente").attr("onclick","ver_cliente("+id_cliente_seleccionado+");");
    $("#modal_cliente").modal("hide");
    alert(id_cliente_seleccionado);
    $("#id_cliente_seleccionado").val(id_cliente_seleccionado);
    
}

function eliminar_producto(){
    $(".table-info").remove();
    $("#codigo").focus();
}

function buscar_numero_venta(){
    $.ajax({
        url:"buscar_numero_venta.php",
        type:"POST",
        dataType:"json",
        data:{'a':0}
    }).done(function(e){
        var id_venta = e["id_venta"];
        $("#numero_venta").html('<b><strong>#'+id_venta+'</strong></b>')
    }).fail(function(error){

    });
}

function buscar_producto_form(campo,e){
    var valor = $(campo).val();
    var keyC = e.keyCode;
    if(keyC == 13){
        //busco el producto
        $.ajax({
            url:"buscar_producto_modal.php",
            type:"POST",
            dataType:"json",
            data:{'criterio':valor}
        }).done(function(respuesta){
            var existe = respuesta["existe"];
            if(existe == 0){
                $("#tbody_productos").html('<tr> '+
                '<td class="text-center text-danger" colspan=4><b><strong>No existen productos con ese criterio</b></strong></td>'+
            '</tr>');
            }
            else{
                $("#tbody_productos tr").remove();
                for(var i= 0;i<existe;i++){
                    var id_producto = respuesta["data"][i]["id_producto"];
                    var codigo = respuesta["data"][i]["codigo"];
                    var producto = respuesta["data"][i]["nombre_producto"];
                    var cantidad = respuesta["data"][i]["cantidad"];
                    //creo el tr
                    var fila = $("<tr>");
                    $(fila).attr("onclick","seleccionar_fila_producto_buscar("+id_producto+",event);");
                    $(fila).attr("id","fila_producto_buscar_"+id_producto);
                    $(fila).attr("codigo_producto",codigo);
                    $(fila).addClass("row_productos");
                    $(fila).css("cursor","pointer");
                    var celda_codigo = $("<td>");
                    $(celda_codigo).addClass("text-center td-nombre");
                    $(celda_codigo).html(codigo);
                    var celda_producto = $("<td>");
                    $(celda_producto).addClass("text-center ");
                    $(celda_producto).html(producto);
                    var celda_cantidad = $("<td>");
                    $(celda_cantidad).addClass("text-center ");
                    $(celda_cantidad).html(cantidad);
                    $(fila).append(celda_codigo);
                    $(fila).append(celda_producto);
                    $(fila).append(celda_cantidad);
                    $("#tbody_productos").append(fila);
                }
            }
        }).fail(function(error){

        });
    }
    else{
        //escribo la tecla
    }
}

function seleccionar_fila_producto_buscar(id_producto,e){
    var fila_seleccionada = $(e.target).parent();
    var resultado = $(fila_seleccionada).hasClass("table-success");
    if(resultado == true){
        //solo voy a deseleccionar la fila actual
        $(fila_seleccionada).removeClass("table-success");
        //desabilito el campo
        $("#btn_seleccionar_producto").prop("disabled",true);
        $("#btn_seleccionar_producto").removeClass("btn-success");
        $("#btn_seleccionar_producto").addClass("btn-disabled");
    }
    else{
        //seleccione una nueva fila
        var filas = $(".row_productos");
        for(var i = 0;i<filas.length;i++){
            var fila = $(filas).eq(i);
            //quito la clase
            $(fila).removeClass("table-success");
        }
        //agrego la clase a esta
        $("#fila_producto_buscar_"+id_producto).addClass("table-success");
        $("#btn_seleccionar_producto").prop("disabled",false);
        $("#btn_seleccionar_producto").removeClass("btn-disabled");
        $("#btn_seleccionar_producto").addClass("btn-success");
    }
    
}

function agregar_producto_form(){
    var fila = $("#tbody_productos").find(".table-success");
    var codigo_producto = $(fila).attr("codigo_producto");
    $("#codigo").val(codigo_producto);
    buscar_producto();
    $("#btn_seleccionar_producto").prop("disabled",true);
        $("#btn_seleccionar_producto").removeClass("btn-success");
        $("#btn_seleccionar_producto").addClass("btn-disabled");
        $("#tbody_productos tr").remove();
        $("#criterio_producto").val("");
        $("#modal_producto").modal("hide");
}

function abrir_modal_es(tipo){
    var url = "";
    if(tipo == "entrada"){
        url = "modal_entrada.php";
    }
    else{
        url = "modal_salida.php";
    }
    $.ajax({
        url:url,
        type:"GET",
        dataType:"html"
    }).done(function(respuesta){
        $("#modal_es").html(respuesta);
        $("#modal_es").modal("show");
    }).fail(function(error){
    });
}