function listar_registros(){
    $.ajax({
        url:"tabla.php",
        type:"POST",
        dataType:"html",
        data:{'valor':0},
        success:function(respuesta){
            $("#cuerpo_tabla").html(respuesta);
            if ( $.fn.dataTable.isDataTable( '#tabla_registros' ) ) {
                $('#tabla_registros').DataTable().destroy();
                //crear_tabla();
                
            }
            else {
                crear_tabla();
                $('div.dataTables_filter input').focus();
            }
 

        },
        error:function(xhr,status){
            alert("Error");
        }
    });
}

function crear_tabla(){
    var table = $('#tabla_registros').DataTable( {
                        "language": {
                            "url": "../assets/plugins/datatables/media/js/Spanish.json"
                            }
                    } );
                    $("[data-toggle=tooltip]").tooltip();
    $("#tabla_registros").removeClass("dataTable");
    $( table.table().header()).addClass( 'th-header' );
}

function habilitar_campos(){
    var id_tipo = $("#id_consecutivo_activo_fijo").val();
    if(id_tipo == 77){
        //es una computadora
        var campos = $("[tipo_campo=computadora]");
        for(var i= 0;i<campos.length;i++){
            var campo = $(campos).eq(i);
            $(campo).show();
        }
    }
    else{
        //oculto los campos de computadoras
        var campos = $("[tipo_campo=computadora]");
        for(var i= 0;i<campos.length;i++){
            var campo = $(campos).eq(i);
            $(campo).hide();
        }
    }
    calcular_activo();
}
function calcular_activo(){
    var activo = "UTL-(consecutivo)";
    $("#no_activo").val(activo);
}

function cambiar_tipo_activo(elemento){
    var estado = $(elemento).prop("checked");
    if(estado == false){
        $("#no_activo").prop("readonly",false);
        $("#no_activo").focus();
    }
    else{
        $("#no_activo").prop("readonly",true);
    }
}
function buscar_subgrupos(){
    var id = $("#id_grupo_activo").val();
    $.ajax({
        url:"subgrupos.php",
        type:"POST",
        dataType:"html",
        data:{'id_grupo':id}
    }).done(function(e){
        $("#id_subgrupo_activo").html(e);
        $("#id_subgrupo_activo").select2();
        buscar_clases();
    }).fail(function(error){
        alert("Error");
    })
}
function buscar_clases(){
    var id = $("#id_subgrupo_activo").val();
    $.ajax({
        url:"clases.php",
        type:"POST",
        dataType:"html",
        data:{'id_subgrupo':id}
    }).done(function(e){
        $("#id_clase_activo_fijo").html(e);
        $("#id_clase_activo_fijo").select2();
        buscar_subclases();
    }).fail(function(error){
        alert("Error");
    })
}
function buscar_subclases(){
    var id = $("#id_clase_activo_fijo").val();
    $.ajax({
        url:"subclases.php",
        type:"POST",
        dataType:"html",
        data:{'id_clase':id}
    }).done(function(e){
        $("#id_subclase_activo_fijo").html(e);
        $("#id_subclase_activo_fijo").select2();
        buscar_consecutivos();
    }).fail(function(error){
        alert("Error");
    })
}
function buscar_consecutivos(){
    var id = $("#id_subclase_activo_fijo").val();
    $.ajax({
        url:"consecutivos.php",
        type:"POST",
        dataType:"html",
        data:{'id_subclase':id}
    }).done(function(e){
        $("#id_consecutivo_activo_fijo").html(e);
        $("#id_consecutivo_activo_fijo").select2();
    }).fail(function(error){
        alert("Error");
    })
}