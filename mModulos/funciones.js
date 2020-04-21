var contador_filas = 0;
function agregar_precio(){
    ++contador_filas;
    //creo el tr
    var fila = $("<tr>");
    $(fila).attr("id","fila_"+contador_filas);
    //creo el td
    var td_numero = $("<td>");
    //creo el td del nombre
    var td_nombre = $("<td>");
    $(td_nombre).addClass("text-center");
    $(td_nombre).html('<input type="text" name="nombre_precios[]" id="" class="form-control">');
    var td_precio = $("<td>");
    $(td_precio).addClass("text-center");
    $(td_precio).html('<input type="number" name="precios[]" value="0.00" id="" class="form-control">');
    var td_boton = $("<td>");
    $(td_boton).html('<button class="btn btn-danger btn-sm" onclick="eliminar_fila('+contador_filas+');" type="button" title="Eliminar precio"><i class="fa fa-times"></i></button>');
    $(td_boton).addClass("text-center");
    $(fila).append(td_nombre);
    $(fila).append(td_precio);
    $(fila).append(td_boton);
    $("#cuerpo_precios").append(fila);
}

function eliminar_fila(fila){
    $("#fila_"+fila).remove();
}

function llenar_tabla(){
    var table = $("#cuerpo_tabla").DataTable({
        "language": {
                            "url": "../assets/plugins/datatables/media/js/Spanish.json"
                            },
        "ajax":'tabla.php'
    });
    $("#cuerpo_tabla").removeClass("dataTable");
    $( table.table().header()).addClass( 'th-header' ); //agrego una clase a los th
    $( table.table().body()).addClass( 'text-center' ); //agrego una clase al cuerpo
}
$("#sidebarnav").prepend('<li class="nav-small-cap">Opciones del módulo</li><li> '+
                        '<a class=" waves-effect waves-dark" href="index.php" aria-expanded="false"> '+
                         '   <i class="fa fa-list"></i><span class="hide-menu">Listado de registros</span> '+
                        '</a> '+
                        '</li><li> '+
                        '<a class=" waves-effect waves-dark" href="alta.php" aria-expanded="false"> '+
                         '   <i class="fa fa-plus"></i><span class="hide-menu">Agregar registro</span> '+
                        '</a> '+
                        '</li><li> '+
                        '<a class=" waves-effect waves-dark" href="inventario.php" aria-expanded="false"> '+
                         '   <i class="fa fa-list"></i><span class="hide-menu">Generación de inventarios</span> '+
                        '</a> '+
                        '</li>');