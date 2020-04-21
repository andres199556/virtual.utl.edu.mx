var array_direcciones =  [];
var encendidos = 0;
var apagados = 0;
var totales = 0;
function listar_registros(){
    $.ajax({
        url:"tabla.php",
        type:"POST",
        dataType:"html",
        data:{'valor':0},
        success:function(respuesta){
            $("#cuerpo_tabla").html(respuesta);
            var direcciones = $(".direccion-ip");
            var cantidad = $(direcciones).length;
            for(var i = 0;i<cantidad;i++){
                var direccion = $(direcciones).eq(i);
                var activo = $(direccion).attr("data-activo");
                var ip = $(direccion).html();
                var objeto = new Object();
                objeto["activo"] = activo;
                objeto["ip"] = ip;
                array_direcciones.push(objeto);
            }
            actualizar_estados();
 

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
    $("#tabla_registros").removeClass("dataTable");
    $( table.table().header()).addClass( 'th-header' );
}

function wake(numero){
    $.ajax({
        url:"wake.php",
        type:"POST",
        dataType:"html",
        data:{'no':numero}
    }).done(function(success){
        alert(success);
    }).fail(function(error){
        alert("Error");
    });
}

function actualizar_estados(){
    var cantidad = $(array_direcciones).length;
    encendidos = 0;
    apagados = 0;
    totales = 0;
    $(".encendidos").html("0");
    $(".apagados").html("0");
    $(".equipos-totales").html("0");
    if ( $.fn.dataTable.isDataTable( '#tabla_registros' ) ) {
        $('#tabla_registros').DataTable().destroy();
    }
    for(var i =0;i<cantidad;i++){
        var objeto = array_direcciones[i];
        $.ajax({
            url:"update.php",
            type:"POST",
            dataType:"json",
            data:{"array_d":objeto}
        }).done(function(success){
            var activo = success["activo"];
            var estado = success["isUp"];
            if(estado == true){
                //esta encendida
                encendidos++;
                $(".estado-equipo-"+activo).html('<i class="fa fa-desktop text-success"></i> <br><span class="label label-success">Encendido</span>');
                $(".encendidos").html(encendidos);
            }
            else{
                //esta apagada
                apagados++;
                $(".estado-equipo-"+activo).html('<i class="fa fa-desktop text-danger"></i> <br><span class="label label-danger">Apagada</span>');
                $(".apagados").html(apagados);
            }
            totales++;
            $(".equipos-totales").html(totales);
            if(totales == cantidad){
             if ( $.fn.dataTable.isDataTable( '#tabla_registros' ) ) {
                $('#tabla_registros').DataTable().destroy();
                //crear_tabla();
                
            }
            else {
                crear_tabla();
                $('div.dataTables_filter input').focus();
            }
            }
            
        }).fail(function(error){
            alert("Error");
        });
    }
    
    
}