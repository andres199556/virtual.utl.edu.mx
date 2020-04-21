activos_individuales = 0;
no_activos = 0;

function validar_form() {
    if (no_activos == 0) {
        $("#btn_agregar").prop("disabled", true);
    } else {
        $("#btn_agregar").prop("disabled", false);
    }
}

function plan(id) {
    $.ajax({
        url: "detalle_plan.php",
        type: "POST",
        dataType: "html",
        data: { 'id': id },
        success: function(respuesta) {
            $("#content-details").html(respuesta);
            $("#btn_alta_mantenimiento").removeClass("hide");
            $("#btn_agregar_mantenimiento").attr("href", "alta_mantenimiento.php?id=" + id);
            listar_mantenimientos(id);
        },
        error: function(xhr, status) {
            alert("Error");
        }
    })
}

function seleccionar() {
    var id_usuario = $("#id_usuario").val();
    $("#incluir_activos").prop("disabled", false);
    $("#id_usuario_hidden").val(id_usuario);
    $("#id_usuario").prop("disabled", true);
    $("#btn_cancelar").removeClass("hide");
    $("#row_activos").removeClass("hide");
    $("#btn_seleccionar").addClass("hide");
    $("#incluir_activos").click();
    $("#incluir_activos").prop("disabled", false);
}

function cancelar_seleccion() {
    $("#incluir_activos").prop("disabled", true);
    $("#id_usuario_hidden").val("");
    $("#btn_cancelar").addClass("hide");
    $("#btn_seleccionar").removeClass("hide");
    $("#id_usuario").prop("disabled", false);
    $("#incluir_activos").click();
    $("#row_activos").addClass("hide");
    var options = $("[option-activos]");
    for (var i = 0; i < options.length; i++) {
        $(options).eq(i).prop("disabled", false);
    }
    $("#activos").select2();
}

function incluir_activos_ligados(checkbox) {
    var estado = $(checkbox).prop("checked");
    if (estado == true) {
        var id_usuario = $("#id_usuario").val();
        //hago la petición
        $.ajax({
            url: "activos.php",
            type: "POST",
            dataType: "json",
            data: { 'id_usuario': id_usuario },
            success: function(respuesta) {
                
                var has_rows = respuesta.length;
                if (has_rows == 0) {
                    //no tiene activos
                    $('#activos').select2();
                } else {
                    //los recorro
                    if (activos_individuales == 0) {
                        //son los unicos, por lo tanto limpio
                        $("#body_activos").html("");
                    } else {
                        //empiezo a contar desde el ultimo
                    }
                    for (var j = 0; j < has_rows; j++) {
                        var object = respuesta[j];
                        //creo fila
                        var row = $("<tr>");
                        $(row).attr("id", "row_" + object[1]);
                        $(row).attr("activos-propios", "true");
                        var td0 = $("<td>");
                        var td1 = $("<td>");
                        var td2 = $("<td>");
                        var td3 = $("<td>");
                        var td4 = $("<td>");
                        var td5 = $("<td>");
                        $(td0).addClass("text-center");
                        $(td0).attr("data-number", "consecutivo");
                        $(td0).html(j + 1);
                        $(td1).addClass("text-center");
                        $(td1).html(object[5]);
                        $(td2).addClass("text-center");
                        $(td2).html(object[1] + "<input type='hidden' name='activos_submit[]' value='" + object[1] + "'><input type='hidden' name='id_activos_submit[]' value='" + object[0] + "'>");
                        $(td3).addClass("text-center");
                        $(td3).html(object[2]);
                        $(td4).addClass("text-center");
                        $(td4).html(object[3]);
                        $(td5).addClass("text-center");
                        $(td5).html(object[4]);
                        //creo el botón
                        var td_btn = $("<td>");
                        $(td_btn).addClass("text-center");
                        var btn = $("<button>");
                        $(btn).attr("type", "button");
                        $(btn).addClass("btn btn-danger btn-sm");
                        $(btn).attr("title", "Eliminar");
                        $(btn).attr("data-toggle", "tooltip");
                        $(btn).attr("onclick", "delete_row('" + object[1] + "',this)");
                        $(btn).html("<i class='fas fa-times-circle'></i>");
                        $(btn).tooltip({ trigger: "hover" });
                        $(td_btn).append(btn);
                        $(row).append(td0);
                        $(row).append(td1);
                        $(row).append(td2);
                        $(row).append(td3);
                        $(row).append(td4);
                        $(row).append(td5);
                        $(row).append(td_btn);
                        $("#body_activos").append(row);
                        //lo quito del select
                        $('#' + object[1]).prop('disabled', true);
                        no_activos++;
                        $('#activos').select2();
                        validar_form();
                    }
                }
            },
            error: function(xhr, status) {
                alert("No");
            }
        });
    } else {
        //limpio el cuerpo
        if (activos_individuales == 0) {
            //son los unicos, por lo tanto limpio
            $("#body_activos").html("");
        } else {
            //dejo los indivudales
            var rows = $("[activos-propios]");
            for (var i = 0; i < rows.length; i++) {
                $(rows).eq(i).remove();
            }
            mover_celdas();
        }
    }
}

function delete_row(no_activo, btn) {
    $(btn).tooltip('hide');
    $("#row_" + no_activo).remove();
    $('#' + no_activo).prop('disabled', false);
    $('#activos').select2();
    mover_celdas();
    no_activos--;
    validar_form();
}

function mover_celdas() {
    var celdas = $("[data-number=consecutivo]");
    for (var i = 0; i < celdas.length; i++) {
        var celda = $(celdas).eq(i);
        $(celda).html(i + 1);
    }
}

function seleccionar_activo() {
    var siguiente = ($("[data-number=consecutivo]").length) + 1;
    var activo = $("#activos").val();

    if (activo == null) {
        //esta deshabilitado
    } else {
        var id_activo = $("#" + activo).attr("data-id");
        var tipo = $("#" + activo).attr("data-type");
        var marca = $("#" + activo).attr("data-marca");
        var modelo = $("#" + activo).attr("data-model");
        var serie = $("#" + activo).attr("data-serial");
        var row = $("<tr>");
        $(row).attr("id", "row_" + activo);
        var td0 = $("<td>");
        var td1 = $("<td>");
        var td2 = $("<td>");
        var td3 = $("<td>");
        var td4 = $("<td>");
        var td5 = $("<td>");
        $(td0).addClass("text-center");
        $(td0).attr("data-number", "consecutivo");
        $(td0).html(siguiente);
        $(td1).addClass("text-center");
        $(td1).html(tipo);
        $(td2).addClass("text-center");
        $(td2).html(activo + "<input type='hidden' name='activos_submit[]' value='" + activo + "'><input type='hidden' name='id_activos_submit[]' value='" + id_activo + "'>");
        $(td3).addClass("text-center");
        $(td3).html(marca);
        $(td4).addClass("text-center");
        $(td4).html(modelo);
        $(td5).addClass("text-center");
        $(td5).html(serie);
        //creo el botón
        var td_btn = $("<td>");
        $(td_btn).addClass("text-center");
        var btn = $("<button>");
        $(btn).attr("type", "button");
        $(btn).addClass("btn btn-danger btn-sm");
        $(btn).attr("title", "Eliminar");
        $(btn).attr("data-toggle", "tooltip");
        $(btn).attr("onclick", "delete_row('" + activo + "',this)");
        $(btn).html("<i class='fas fa-times-circle'></i>");
        $(btn).tooltip({ trigger: "hover" });
        $(td_btn).append(btn);
        $(row).append(td0);
        $(row).append(td1);
        $(row).append(td2);
        $(row).append(td3);
        $(row).append(td4);
        $(row).append(td5);
        $(row).append(td_btn);
        $("#body_activos").append(row);
        //lo quito del select
        $('#' + activo).prop('disabled', true);
        no_activos++;
        activos_individuales++;
        $('#activos').select2();
        validar_form();

    }

}

function listar_mantenimientos(id_plan) {
    $.ajax({
        url: "planes.php",
        type: "POST",
        dataType: "json",
        data: { 'id_plan': id_plan },
        success: function(respuesta) {
            var hasrow = respuesta.length;
            if (hasrow == 0) {
                //no arrojo datos
            } else {
                var contador = 1;
                for (var i = 0; i < respuesta.length; i++) {
                    var object_row = respuesta[i];
                    var active = object_row[7];
                    //creo el tr
                    var row = $("<tr>");
                    //td consecutivo
                    var td_count = $("<td>");
                    $(td_count).html(contador);
                    $(td_count).addClass("text-center");
                    var td_name = $("<td>");
                    $(td_name).addClass("text-center");
                    $(td_name).html(object_row[1]);
                    var td_depar = $("<td>");
                    $(td_depar).addClass("text-center");
                    $(td_depar).html(object_row[2]);
                    var td_date = $("<td>");
                    $(td_date).addClass("text-center");
                    $(td_date).html(object_row[4]);
                    var td_date_end = $("<td>");
                    $(td_date_end).addClass("text-center");
                    $(td_date_end).html(object_row[5]);
                    var td_comments = $("<td>");
                    $(td_comments).addClass("text-center");
                    $(td_comments).html("");
                    var td_state = $("<td>");
                    $(td_state).addClass("text-center");
                    if (active == 0) {
                        $(td_state).html("<label class='badge badge-success m-r-10'>Cerrado</label>");
                    } else if (active == 2) {
                        $(td_state).html("<label class='badge badge-primary m-r-10'>Pendiente de liberar</label>");
                    }
                    else{
                        $(td_state).html("<label class='badge badge-warning m-r-10'>Abierto</label>");
                    }
                    
                    var td_options = $("<td>");
                    $(td_options).addClass("text-center");
                    $(td_options).html("<a title='Ver mantenimiento' btn-options href='mantenimiento.php?id=" + object_row[0] + "' class='btn btn-sm btn-info'><i class='fas fa-book'></i></a>");
                    $(row).append(td_count);
                    $(row).append(td_name);
                    $(row).append(td_depar);
                    $(row).append(td_date);
                    $(row).append(td_date_end);

                    $(row).append(td_state);
                    $(row).append(td_options);
                    $("#body_listado_individuales").append(row);
                    $("[btn-options]").tooltip();
                    contador++;
                }
                if ($.fn.dataTable.isDataTable('#tabla_registros')) {
                    $('#tabla_registros').DataTable().destroy();
                    //º();

                } else {
                    //crear_tabla();
                }

            }
            $("#datos_planes_individuales").removeClass("hide");
        },
        error: function(xhr, status) {

        }
    });
}

function cerrar_mantenimiento() {
    $("#row_cerrar").removeClass("hide");
}

$("#frmCerrarMantenimiento").submit(function(e) {
    var frm_respuesta = new FormData(document.getElementById("frmCerrarMantenimiento"));
    $.ajax({
        url: 'cerrar_mantenimiento.php',
        data: frm_respuesta,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST', // For jQuery < 1.9
        dataType: "html",
        success: function(data) {
            alert(data);
        },
        error: function(xhr, status) {
            alert("Error");
        }
    });
    e.preventDefault();
    return false;
});

function definir_despues_a() {
    $("#incluir_activos").prop("disabled", true);
    $("#btn_agregar").prop("disabled", false);
}


function cambiar_fechas(id_plan) {
    $.ajax({
        url: "cambiar_fechas.php",
        type: "POST",
        dataType: "html",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        $("#modal_body").html(e);
        $('#nueva_fecha').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
        $("#nueva_fecha").datepicker().datepicker("setDate", new Date());
        $("#modal_action").modal("show");
    }).fail(function(error) {

    });
}

function cerrar_modal() {
    $("#modal_action").modal("hide");
}

function asignar_responsable_mantenimiento(id_plan) {
    $.ajax({
        url: "modal_responsable.php",
        type: "POST",
        dataType: "html",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        $("#modal_body").html(e);
        $("#modal_action").modal("show");
    }).fail(function(error) {
        alert("a");
    });
}

function agregar_activos(id_plan) {
    $.ajax({
        url: "modal_activos.php",
        type: "POST",
        dataType: "html",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        $("#modal_body").html(e);
        $("#modal_action").modal("show");
    }).fail(function(error) {
        alert("a");
    });
}

function actualizar_activos(id_plan) {
    $.ajax({
        url: "listar_activos_plan.php",
        type: "POST",
        dataType: "html",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        $("#table_activos").html(e);
    }).fail(function(error) {
        alert("Error");
    });
}

function eliminar_activo_mantenimiento(id_activo) {
    $.ajax({
        url: "eliminar_activo.php",
        type: "POST",
        dataType: "json",
        data: { 'id_activo_mantenimiento': id_activo },
        beforeSend: function(action) {
            $("#btn_eliminar_" + id_activo).prop("disabled", true);
        }
    }).done(function(e) {
        var resultado = e["resultado"];
        if (resultado == "exito") {
            $.toast({
                heading: "Exito!",
                text: "Activo eliminado correctamente!.",
                position: 'top-right',
                loaderBg: "#1E8449",
                icon: "success",
                hideAfter: 3000,
                stack: 6
            });
            $("#fila_mantenimiento_" + id_activo).remove();
        } else {
            $("#btn_eliminar_" + id_activo).prop("disabled", true);
            $.toast({
                heading: "Exito!",
                text: "Activo eliminado correctamente!.",
                position: 'top-right',
                loaderBg: "#A93226",
                icon: "danger",
                hideAfter: 3000,
                stack: 6
            });
        }
    }).fail(function(error) {

    });
}

function crear_tabla() {
    var table = $('#tabla_registros').DataTable({
        "language": {
            "url": "../assets/plugins/datatables/media/js/Spanish.json"
        }
    });
    $("#tabla_registros").removeClass("dataTable");
    $(table.table().header()).addClass('th-header');
}

function enviar_notificacion(id_plan) {
    $.ajax({
        url: "enviar_notificacion.php",
        type: "POST",
        dataType: "json",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        var resultado = e["resultado"];
        if (resultado == "exito") {
            $.toast({
                heading: "Exito!",
                text: "Se ha enviado la notificación de mantenimiento al usuario!.",
                position: 'top-right',
                loaderBg: "#1E8449",
                icon: "success",
                hideAfter: 3000,
                stack: 6
            });
        } else {

        }
    }).fail(function(error) {
        alert("Error");
    });
}

function agregar_nota(id_plan) {
    $.ajax({
        url: "modal_agregar_nota.php",
        type: "POST",
        dataType: "html",
        data: { 'id_plan': id_plan }
    }).done(function(e) {
        $("#modal_body").html(e);
        $("#modal_action").modal("show");
    }).fail(function(error) {
        alert("a");
    });
}