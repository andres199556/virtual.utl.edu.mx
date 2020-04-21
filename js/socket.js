var socket;
var global_date = "";

function conect_socket(s_id, user_id, type, dispositivo) {
    var message = {
        s_id: s_id,
        user_id: user_id,
        type: type,
        date: global_date,
        device: dispositivo
    };
    socket = io.connect('http://127.0.0.1:8080', { 'forceNew': true });
    socket.emit('new-message', message);

    socket.on('messages', function(data) {
        console.log(data);
        var type = data["type"];
        if (type == "message_sended") {
            //estoy recibiendo un mensaje
            var mensajes = data["array_messages"];
            var cantidad = data["cantidad"];
            var array_mensajes = data["array_messages"];
            var cantidad_mensajes = data["cantidad"];
            var user_id = data["user_id"];
            var id_conversacion = data["conversation"];
            var tipo_conversacion = data["conversation_type"];
            var nickname_user = data["nickname2"];
            var nickname_remitente = data["nickname"];
            for (i = 0; i < cantidad; i++) {
                var mensaje = mensajes[i];
                var id_mensaje = mensaje["id_mensaje"];
                var fecha_hora = mensaje["fecha_hora"];
                var hora = mensaje["hora"];
                var tipo_conversacion = mensaje["tipo_conversacion"];
                var nickname_destinatario = mensaje["apodo1"];
                var nickname_remitente = mensaje["apodo2"];
                var tipo_mensaje = mensaje["tipo_mensaje"];
                var mensaje_texto = mensaje["mensaje"];
                var fotografia = mensaje["imagen"];
                if (modulo_actual == "mInicio") {
                    //lo recibo en el inicio
                    $(".notify-mensaje").removeClass("hide");
                    //verifico si ya existe una conversacion en la capa
                    var existe_conver = $(".message-center").find("[data-conversacion=" + id_conversacion + "]").length;
                    if (existe_conver == 1) {
                        //ya existe en la capa
                        var capa_conversacion = $(".message-center").find("[data-conversacion=" + id_conversacion + "]");
                        $(capa_conversacion).css("background", "#f2f4f8");
                        var capa_mensaje = $(capa_conversacion).find(".mail-desc");
                        $(capa_mensaje).html("<b><strong>" + mensaje_texto + "</strong></b>");
                        $(capa_conversacion).find(".time").html(hora);
                        $(capa_conversacion).prependTo(".message-center");
                        break;

                    } else if (existe_conver == 2) {
                        //ya existe en la capa
                        var capa_conversacion = $(".message-center").find("[data-conversacion=" + id_conversacion + "]");
                        $(capa_conversacion).css("background", "#f2f4f8");
                        var capa_mensaje = $(capa_conversacion).find(".mail-desc");
                        $(capa_mensaje).html("<b><strong>" + mensaje_texto + "</strong></b>");
                        $(capa_conversacion).find(".time").html(hora);
                    } else {
                        //la agrego
                    }
                } else if (modulo_actual == "mMensajes") {
                    //estoy en el modulo de mensajes
                    if (id_conversacion == id_conversacion_activa) {
                        var span_conversacion = $("[data-conver=" + id_conversacion + "]").find(".texto_conversacion");
                        $(span_conversacion).html(mensaje_texto);
                        //la conversacion se encuentra abierta
                        $(".chat-list").append('<li class=""> ' +
                            '<div class="chat-img"><img src="../' + fotografia + '" alt="user" /></div>' +
                            '<div class="chat-content">' +

                            '<h5>' + nickname_remitente + '</h5>' +
                            '<div class="box-out"><div class="box-chat-user bg-primary" title="' + fecha_hora + '" id="mensaje_' + id_mensaje + '" data-placement="top">' + mensaje_texto + '</div></div>' +
                            '</div>' +
                            '</li>');
                        $("#mensaje_" + id_mensaje).tooltip();
                        var scrollTo_int = $(".chat-list").prop('scrollHeight') + 'px';
                        $(".chat-list").slimScroll({
                            scrollTo: scrollTo_int,
                            height: '200px',
                            start: 'bottom',
                            alwaysVisible: true
                        });
                    } else {
                        alert(id_conversacion);
                        //no es la conversacion activa
                        //no se encuentra abierta, pero se encuetnra en el módulo de mensajes
                        var item = $("[data-conver=" + id_conversacion + "]");
                        if (item.length == 0) { //no existe
                            //recorro las demas
                            var listas = $(".li-conversations");
                            var cantidad = $(listas).length;
                            for (var i = 0; i < cantidad; i++) {
                                $(listas).eq(i).find("a").removeClass("active");
                            }
                            //significa que es una conversacion nueva
                            $(".chat-normal").prepend('<li data-conver="' + id_conversacion + '" class="li-conversations">' +
                                '<a href="javascript:ver_conversacion(' + id_conversacion + ',"normal");" class="active" >' +
                                '   <span class="dot-online" title="En linea"></span>' +
                                '   <img src="../images/profile/2.jpg" alt="user-img" class="img-circle"> ' +
                                '       <span> ' + nickname_remitente +
                                '           <span class="profile-status online pull-right"></span> ' +
                                '           <small class="texto_conversacion"><b><strong>' + mensaje_texto + '</strong></b></small>' +
                                '       </span>' +
                                '   </a>' +
                                '</li>');
                        } else {
                            //ya se encontraba en el panel, la muevo al inicio
                            var listas = $(".li-conversations");
                            var cantidad = $(listas).length;
                            for (var i = 0; i < cantidad; i++) {
                                $(listas).eq(i).find("a").removeClass("active");
                            }
                            alert(id_conversacion);
                            $(item).find("a").addClass("active");
                            $(item).find(".texto_conversacion").html(mensaje_texto);
                            $(item).prependTo(".chat-normal");
                        }
                    }
                } else {
                    //se encuentra en cualquier otro modulo, por lo tanto agrego el mensaje a la bandeja de entrada
                }
            }
        }
        console.log(JSON.stringify(data));
        //render(data);
    });
    socket.on('disconnect', function() {
        // Do stuff (probably some jQuery)
        alert("Se desconecto");
    });
    return false;
}

function render(data) {
    var html = data.map(function(elem, index) {
        return (`<div>
              <strong>${elem.author}</strong>:
              <em>${elem.text}</em>
            </div>`);
    }).join(" ");

    document.getElementById('messages').innerHTML = html;
}


function send_data(data) {
    socket.emit("new-message", data);
}

function addMessage(e) {
    var message = {
        author: document.getElementById('username').value,
        text: document.getElementById('texto').value
    };

    socket.emit('new-message', message);
    return false;
}