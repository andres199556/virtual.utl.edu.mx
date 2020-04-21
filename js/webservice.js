//creo la variable global de la conexion
var modulo_actual = "";
var w = $(window);
var user_id = ""; //aqui voy a guardar el id que me servirá para el webservice
$server = "128.100.0.3:9000";
var session_id = "";
  function is_connected(socket) {
    if(socket == undefined){
      return false;
    }
    else if (socket['readyState'] == 1) {
      return true;
    }
  }
function cargar_webservice(session,user_id,type){
    if (is_connected(w.websocket)) { //si regresa true, significa que ya esta la conexion, por lo tanto la cierro
        w.websocket.onclose = function () {}; 
        w.websocket.close();
        
    }
    w.wsUri = "ws://"+$server+"/websocket.php";
    w.websocket = new WebSocket(w.wsUri); 
    w.websocket.onopen = function(ev) {
        var msg = {
          sid : session,
          user_id:user_id,
          type:type
        };
        //envio los datos de conexion al webservice
        w.websocket.send(JSON.stringify(msg));
    }

    //evento de recibir mensaje
    w.websocket.onmessage = function(ev) {
        var msg    = JSON.parse(ev.data); //Recibo el mensaje en formato JSON
        var type = msg.type;
        if(type == "logInUser" && modulo_actual == "mLogin"){
          //se conecto
          window.location = "../mInicio/index.php";
        }
        if(type == "recived_message"){
          if(modulo_actual == "mMensajes"){
            //estoy dentro del modulo de mensajes
            var id_conversacion = msg.id_conversacion;
            var tipo_conversacion = msg.tipo_conversacion;
            var cantidad_mensajes = msg.cantidad_mensajes;
            var nickname1 = msg.nickname;
            var nickname2 = msg.nickname2;
            var mensajes = msg.mensajes;
            if(id_conversacion == id_conversacion_activa){
              for(var j = 0;j<cantidad_mensajes;j++){
                var id_mensaje = mensajes[j]["id_mensaje"];
                var fecha_hora = mensajes[j]["fecha_hora"];
                var hora = mensajes[j]["hora"];
                var apodo1 = mensajes[j]["apodo1"];
                var nickname = mensajes[j]["apodo2"];
                var tipo_mensaje = mensajes[j]["tipo_mensaje"];
                var mensaje = mensajes[j]["mensaje"];
                $(".chat-list").append('<li> '+
              '<div id="conversacion_'+id_conversacion+'" class="chat-img"><img src="../assets/images/users/5.jpg" alt="user" /></div>'+
                                                '<div class="chat-content">'+
                                                    '<h5>'+nickname+'</h5>'+
                                                    '<div class="box-out"><div class="box-chat-user bg-primary" title="'+fecha_hora+'" id="mensaje_'+id_mensaje+'" data-placement="right">'+mensaje+'</div></div>'+
                                                '</div>'+
                                            '</li>');
                $("#mensaje_"+id_mensaje).tooltip();
              }
            var scrollTo_int = $(".chat-list").prop('scrollHeight') + 'px';
            $(".chat-list").slimScroll({
                scrollTo : scrollTo_int,
                height: '200px',
                start: 'bottom',
                alwaysVisible: true
            });
            }
            else{
              //es alguna otra conversacion o bien, no lo tengo incluido en la lista
              //primero busco si la capa de la conversacion se encuentra ya en las del inicio
              var convertation_li = $("[data-conver="+id_conversacion+"]");
              if(convertation_li.length == 0){
                //no existe
                $(".chat-normal").prepend('<li data-conver="<?php echo $id_conversacion;?>" class="li-conversations">'+
                '<a href="javascript:ver_conversacion('+id_conversacion+',"normal");" class="active" >'+
                '   <span class="dot-online" title="En linea"></span>'+
                '   <img src="../<?php echo $row_c["imagen_conversacion"];?>" alt="user-img" class="img-circle"> '+
                '       <span> '+apodo1+
                '           <span class="profile-status online pull-right"></span> '+
                '           <small class=""><?php echo $texto_remitente.$mensaje;?></small>'+
                '       </span>'+
                '   </a>'+
                '</li>');
              }
              else{
                //si existe, por lo tanto solo la muevo
              }
              
            }
          }
          else if(modulo_actual == "mInicio"){
            $(".notify-mensaje").removeClass("hide");
            var id_conversacion = msg.id_conversacion;
            var fecha_hora = msg.fecha_hora;
            var id_mensaje = msg.id_mensaje;
            var mensaje = msg.mensaje;
            var tipo_mensaje = msg.tipo_mensaje;
            var nickname = msg.nickname;
            var res = fecha_hora.split(" ");
            var hora = res[1] + " " + res[2];
            //verifico si ya existe una conversacion en la capa
            if($(".message-center").find("#conversacion_"+id_conversacion).length){
              //ya existe en la capa
              var capa_conversacion = $(".message-center").find("#conversacion_"+id_conversacion);
              $(capa_conversacion).css("background","#f2f4f8");
              var capa_mensaje =  $(capa_conversacion).find(".mail-desc");
              $(capa_mensaje).html("<b><strong>"+mensaje+"</strong></b>");
              $(capa_conversacion).find(".time").html(hora);
              $( ".message-center" ).prepend( $("#conversacion_"+id_conversacion ));

            }
            else{
              //la agrego
            }
          }
        }
        if(type == "msgPanel"){
            //es un mensaje de chat en el panel de mensajes
        }
        else if(type == "notification"){
            //es una notificacion
        }
        else if(type == "msgChatBox"){
            //muestro el mensaje en la bandeja arriba
        }
        else if(type == "logInUser"){
          alert("Te conectaste");
        }
        else if(type == "logOutUser"){

        }
        else if(type == "recived_message"){

        }

      };
      w.websocket.onerror = function(ev){
          //ocurrio un error al conectar con el webservice
          alert("Error en la conexión");
        };
      w.websocket.onclose   = function(ev){
          //se cerro la conexión
          alert("Se cerro la conexion");
        };
}


function send_message_conversation(){
    var mensaje = "hola";
    var id_conversation = 1;
    var msg = {
        message: mensaje,
        sid : session_id,
        conversation : id_conversation
      };

      //convert and send data to server
      w.websocket.send(JSON.stringify(msg));
}

