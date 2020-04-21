/*function listar_registros(){
    $.ajax({
        url:"tabla.php",
        type:"POST",
        dataType:"html",
        data:{'valor':0},
        success:function(respuesta){
            $("#cuerpo_tabla").html(respuesta);
        },
        error:function(xhr,status){
            alert("Error");
        }
    })
}*/
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
    $("#tabla_registros").removeClass("dataTable");
    $( table.table().header()).addClass( 'th-header' );
}
function tomar_servicio(id_servicio){
            swal({
              title: '¿Deseas tomar este servicio?',
              text: "Una vez que tomes este servicio deberás garantizar que se le de solución a la problematica presentada.",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Tomar servicio',
                cancelButtonText:"Cancelar"
            }).then((result) => {
              if (result.value) {
                  //si lo tomo, por lo tanto actualizo el responsable
                  $.ajax({
                      url:"tomar_servicio.php",
                      type:"POST",
                      dataType:"json",
                      data:{'id_servicio':id_servicio},
                      success:function(respuesta){
                          alert(respuesta["mensaje"]);
                          listar_registros();
                      },
                      error:function(xhr,status){
                          alert("Error");
                      }
                  })
              }
            });
        }
        function cambiar_estado(id_servicio){
            $("#modal_configuracion").modal("show");
        }
        function liberar(id_servicio){
            $("#id_servicio_liberar").val(id_servicio);
            $("#modal_liberar").modal("show");
        }