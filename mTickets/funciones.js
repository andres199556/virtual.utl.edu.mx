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
            }
        },
        error:function(xhr,status){
            alert("Error");
        }
    })
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

function show_respuestas(ticket){
    $.ajax({
        url:"respuestas.php",
        type:"POST",
        dataType:"html",
        data:{'ticket':ticket},
        success:function(respuesta){
            $("#cuerpo_respuestas").html(respuesta);
        },
        error:function(xhr,status){
            alert("Error");
        }
    })
}

function mostrar_tipos(){
    $.ajax({
        url:"tipos_servicios.php",
        type:"POST",
        dataType:"html",
        data:{'var':0},
        success:function(respuesta){
            $("#modal_title_generico").html("Cambiar tipo de servicio");
            $("#cuerpo_modal_generico").html(respuesta);
            $("#form_modal_generico").attr("action","cambiar_tipo.php");
            $("#modal_generico").modal("show");
        }
    })
}

$("#form_modal_generico").submit(function(e){
    //extraigo la url del action
    var url = $("#form_modal_generico").attr("action");
    var id_tipo_servicio = $("#id_tipo_servicio").val();
    var ticket = $("#ticket_activo").val();
    $.ajax({
        url:url,
        type:"POST",
        dataType:"json",
        data:{'id_tipo_servicio':id_tipo_servicio,'ticket':ticket},
        success:function(respuesta){
            $("#modal_generico").modal("hide");
            $("#nombre_tipo").html(respuesta["tipo_servicio"]);
            $.toast({
                        heading: respuesta["titulo"],
                        text: respuesta["mensaje"],
                        position: 'top-right',
                        loaderBg:respuesta["color"],
                        icon: respuesta["icon"],
                        hideAfter: 3000, 
                        stack: 6
                    });
        },
        error:function(xhr,status){
            alert("Error");
        }
    });
    e.preventDefault;
    return false;
});

function enviar_notificacion(ticket,id_respuesta){
    $.ajax({
        url:"enviar_correo.php",
        type:"POST",
        dataType:"json",
        data:{'id_respuesta':id_respuesta,'ticket':ticket},
        success:function(respuesta){
            $.toast({
                        heading: respuesta["titulo"],
                        text: respuesta["mensaje"],
                        position: 'top-right',
                        icon: respuesta["icon"],
                        hideAfter: 3000, 
                        stack: 6
                    });
        },
        error:function(xhr,status){
            alert("Error");
        }
    });
}

function eliminar_respuesta(id_mensaje,ticket){
    swal({
              title: '¿Deseas eliminar esta respuesta?',
              text: "Una vez eliminado, no podrás acceder nuevamente a la información ni a los archivos adjuntos.",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Eliminar',
                cancelButtonText:"Cancelar"
            }).then((result) => {
              if (result.value) {
                  //si lo tomo, por lo tanto actualizo el responsable
                  $.ajax({
                      url:"eliminar_mensaje.php",
                      type:"POST",
                      dataType:"json",
                      data:{'ticket':ticket,'id_mensaje':id_mensaje},
                      success:function(respuesta){
                          $.toast({
                                heading: respuesta["titulo"],
                                text: respuesta["mensaje"],
                                position: 'top-right',
                                icon: respuesta["icon"],
                                hideAfter: 3000, 
                                stack: 6
                            });
                          show_respuestas(ticket);
                      },
                      error:function(xhr,status){
                          alert("Error");
                      }
                  });
              }
            }
        )
}

function eliminar_ticket(ticket){
    swal({
              title: '¿Deseas eliminar este ticket?',
              text: "Una vez eliminado, no podrás acceder a la información que se había guardado.",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Eliminar',
                cancelButtonText:"Cancelar"
            }).then((result) => {
              if (result.value) {
                  //si lo tomo, por lo tanto actualizo el responsable
                  $.ajax({
                      url:"eliminar_ticket.php",
                      type:"POST",
                      dataType:"json",
                      data:{'ticket':ticket},
                      success:function(respuesta){
                          var resultado = respuesta["resultado"];
                          if(resultado == "exito"){
                              window.location = "index.php?resultado=exito_eliminar";
                          }
                      },
                      error:function(xhr,status){
                          alert("Error");
                      }
                  });
              }
            }
        )
}

function cerrar_ticket(ticket){
    $.ajax({
        url:"modal_cerrar.php",
        type:"GET",
        dataType:"html",
        data:{'ticket':ticket},
        success:function(respuesta){
            $("#modal_cerrar_ticket").html(respuesta);
            $("#modal_cerrar_ticket").modal("show");
            
        },
        error:function(xhr,status){
            alert("No");
        }
    });
    
}

function cambiar_estado(ticket){
    $.ajax({
        url:"modal_cambiar_estado.php",
        type:"GET",
        dataType:"html",
        data:{'ticket':ticket},
        success:function(respuesta){
            $("#modal_cambiar_estado").html(respuesta);
            $("#modal_cambiar_estado").modal("show");
            
        },
        error:function(xhr,status){
            alert("No");
        }
    });
}

var movimientos_canvas = new Array();
  var pulsado;
var context;
    function initCanvas() {
        var canvasDiv = document.getElementById('canvasDiv');
        canvas = document.createElement('canvas');
        //canvas.width = $("#canvasDiv").width();
        //canvas.height = $("#canvasDiv").height();
        canvas.setAttribute('width', 464);
        canvas.setAttribute('height', 300);
        canvas.setAttribute('id', 'canvas');
        //canvasDiv.appendChild(canvas);
        if(typeof G_vmlCanvasManager != 'undefined') {
            canvas = G_vmlCanvasManager.initElement(canvas);
        }
        context = canvas.getContext("2d");

        /*$('#canvas').mousedown(function(e){
            var parentOffset = $(this).parent().offset(); 
           var relX = e.pageX - parentOffset.left;
           var relY = parseInt(e.pageY) - parseInt(parentOffset.top);
          pulsado = true;
          movimientos_canvas.push([relX,relY,false]);
          repinta();
        });
        
        $('#canvas').mousemove(function(e){
            var parentOffset = $(this).parent().offset(); 
           var relX = e.pageX - parentOffset.left;
           var relY = parseInt(e.pageY) - parseInt(parentOffset.top);
          if(pulsado){
              movimientos_canvas.push([relX,relY,true]);
              console.log("movido");
            repinta();
        }
    });
    
    $('#canvas').mouseup(function(e){
        console.log("soltado");
        pulsado = false;
    });

    $('#canvas').mouseleave(function(e){
        pulsado = false;
    });*/
    
        $('#canvas').bind('touchstart',function(event){
          var e = event.originalEvent;
          e.preventDefault();
          pulsado = true;
            var parentOffset = $(this).parent().offset(); 
           var relX = e.pageX - parentOffset.left;
           var relY = parseInt(e.pageY) - parseInt(parentOffset.top);
          movimientos_canvas.push([relX,relY,false]);
          repinta();
        });

        $('#canvas').bind('touchmove',function(event){
          var e = event.originalEvent;
          e.preventDefault();
            var parentOffset = $(this).parent().offset(); 
           var relX = e.pageX - parentOffset.left;
           var relY = parseInt(e.pageY) - parseInt(parentOffset.top);
          if(pulsado){
              movimientos_canvas.push([relX,relY,true]);
        repinta();
        }
    });
    
    $('#canvas').bind('touchend',function(event){
        var e = event.originalEvent;
        e.preventDefault();
        pulsado = false;
    });
    
    $('#canvas').mouseleave(function(e){
        pulsado = false;
    });
        repinta();
}

function repinta(){
  canvas.width = canvas.width; // Limpia el lienzo
  
  context.strokeStyle = "#000ff0";
  context.lineJoin = "round";
  context.lineWidth = 6;
  for(var i=0; i < movimientos_canvas.length; i++)
  {
    context.beginPath();
    if(movimientos_canvas[i][2] && i){
      context.moveTo(movimientos_canvas[i-1][0], movimientos_canvas[i-1][1]);
      }
    else{
      context.moveTo(movimientos_canvas[i][0], movimientos_canvas[i][1]);
    }
      context.lineTo(movimientos_canvas[i][0], movimientos_canvas[i][1]);
      context.closePath();
      context.stroke();
      
      
  }
    /*var c=document.getElementById("canvas");
var ctx=c.getContext("2d");
ctx.beginPath();
ctx.moveTo(0,0);
ctx.lineTo(200,200);
ctx.stroke();*/
}
$("#frmModalCambiarEstado").submit(function(e){
    $.ajax({
        url:"cambiar_estado.php",
        type:"POST",
        dataType:"json",
        data:$("#frmModalCambiarEstado").serialize(),
        success:function(respuesta){
            $.toast({
                                heading: respuesta["titulo"],
                                text: respuesta["mensaje"],
                                position: 'top-right',
                                icon: respuesta["icon"],
                                hideAfter: 3000, 
                                stack: 6
                            });
            $("#modal_cambiar_estado").modal("hide");
        },
        error:function(xhr,status){
            alert("Weeoe");
        }
    });
    e.preventDefault;
    return false;
});

function verificar(ticket){
     swal({
              title: '¿Deseas verificar y cerrar el ticket?',
              type: 'question',
              html:
         '<label>Una vez que presiones el botón de verificar, el ticket quedará cerrado completamente, adicionalmente puedes agregar un comentario de cierre.</label><br>' +
         '<textarea id="comentarios_cierre" class="form-control">',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Verificar',
                cancelButtonText:"Cancelar"
            }).then((result) => {
              if (result.value) {
                  //si lo tomo, por lo tanto actualizo el responsable
                  var comentarios = $("#comentarios_cierre").val();
                  $.ajax({
                      url:"verificar.php",
                      type:"POST",
                      dataType:"json",
                      data:{'ticket':ticket,'comentarios':comentarios},
                      success:function(respuesta){
                          var resultado = respuesta["resultado"];
                          if(resultado == "exito_liberar"){
                              window.location = "index.php?resultado=exito_liberar&ticket="+ticket;
                          }
                          else{
                              window.location = "index.php?resultado=error_liberar&ticket="+ticket;
                          }
                      },
                      error:function(xhr,status){
                          alert("Error");
                      }
                  });
              }
            }
        )
}