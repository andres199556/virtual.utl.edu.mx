var express = require('express');
var array_sesiones_usuarios = Object();
array_sesiones_usuarios["id_sockets"] = [];
array_sesiones_usuarios["usuarios"] = [];
var array_sockets = [];
var app = express();
var server = require('http').Server(app);
var io = require('socket.io')(server);
const connectedSockets = new Set();
var coleccion_sockets = [];

app.use(express.static('public'));

app.get('/', function(req, res) {
    res.status(200).send("Hola mundo!");
});

io.on('connection', function(socket) {
    //array_sockets.push(socket);
    //verifico que no exista
    var id_socket = socket["id"];
    //coleccion_sockets[id_socket]["id_socket"] = id_socket;
    connectedSockets.add(socket);
    var address = socket.handshake.address;
    array_sesiones_usuarios["id_sockets"][id_socket] = Object();
    /* socket.emit('messages', messages); */

    socket.on('new-message', function(data) {
        var s_id = data["s_id"];
        var user_id = data["user_id"];
        var type = data["type"];
        var date = data["date"];
        var device = data["device"];
        array_sesiones_usuarios["id_sockets"][id_socket]["id_socket"] = id_socket;
        array_sesiones_usuarios["id_sockets"][id_socket]["user_id"] = user_id;
        array_sesiones_usuarios["id_sockets"][id_socket]["socket"] = socket;
        array_sesiones_usuarios["id_sockets"][id_socket]["device"] = device;
        if (type == "login") {
            //se va a loguear el usuario
            var existe = array_sesiones_usuarios["usuarios"]["user_" + user_id];
            if (existe == undefined) {
                //lo creo
                array_sesiones_usuarios["usuarios"]["user_" + user_id] = Object();
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["user_id"] = user_id;
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["id_sockets"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].push(socket);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["id_sockets"].push(id_socket);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].push(address);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].push(s_id);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].push(date);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"].push(device);
            } else {
                var existe_s = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].includes(s_id);
                if (existe_s == true) {
                    //es la misma, por lo tanto solo actualizo la ultima conexion y el ultimo socket
                } else {
                    //es una conexion nueva
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].push(socket);
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["id_sockets"].push(id_socket);
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].push(address);
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].push(s_id);
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].push(date);
                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"].push(device);
                }
            }
        } else if (type == "reload") {
            //vuevo a validar que exita ya el array de objeto del usuario
            var existe = array_sesiones_usuarios["usuarios"]["user_" + user_id];
            if (existe == undefined) {
                //lo creo porque no existe
                array_sesiones_usuarios["usuarios"]["user_" + user_id] = Object();
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["user_id"] = user_id;
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["id_sockets"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"] = [];
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].push(socket);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["id_sockets"].push(id_socket);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].push(address);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].push(s_id);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].push(date);
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"].push(device);
            } else {
                console.log("Ya existe el usuario");
                //actualizo solo los datos
                //actualizo la hora de sesion y el socket
                var posicion = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].indexOf(s_id);
                //actualizo los valores
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"][posicion] = socket;
                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"][posicion] = date;
            }

        } else if (type == "message_sended") {
            console.log(data);
            //acabo de enviar un mensaje
            var array_mensajes = data["array_messages"];
            var cantidad_mensajes = data["cantidad"];
            var user_id = data["user_id"];
            var id_conversacion = data["conversation"];
            var tipo_conversacion = data["conversation_type"];
            var nickname_user = data["nickname2"];
            var nickname_own = data["nickname"];
            if (tipo_conversacion == "normal") {
                //busco si el usuario tiene sesiones activas
                var existe = array_sesiones_usuarios["usuarios"]["user_" + user_id];
                if (existe == undefined) {
                    //el usuario no tiene sockets activos, por lo tanto hasta aqui termino
                } else {
                    //tiene sockets activos, por lo tanto le envio los mensajes
                    cantidad_sockets = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].length;
                    for (var i = 0; i < cantidad_sockets; i++) {
                        var socket_user = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"][i];
                        var existe = array_sockets.indexOf(socket_user);
                        if (existe < 0) {
                            console.log("Ya no existe");
                            //no existe ya el socket, lo elimino
                            var pos = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].indexOf(socket_user);
                            array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].splice(pos, 1);
                            array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].splice(pos, 1);
                            array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].splice(pos, 1);
                            array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].splice(pos, 1);
                        } else {
                            socket_user.emit("messages", data);
                        }

                    }

                }
            } else if (tipo_conversacion == "grupal") {
                //envio a todos los integrantes
                var integrantes = data["integrantes"];
                var user_send = data["user_send"];
                var a_i = integrantes.split(",");
                console.log("intgrantes:" + a_i);
                var cantidad_integrantes = a_i.length;
                for (var n = 0; n < cantidad_integrantes; n++) {
                    var user_id = a_i[n];
                    //envio la notificacion a cada usuario integrante de la conversacion
                    //busco si el usuario tiene sesiones activas
                    var existe = array_sesiones_usuarios["usuarios"]["user_" + user_id];
                    if (existe == undefined) {
                        //el usuario no tiene sockets activos, por lo tanto hasta aqui termino
                    } else {
                        //tiene sockets activos, por lo tanto le envio los mensajes
                        cantidad_sockets = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].length;
                        for (var i = 0; i < cantidad_sockets; i++) {
                            var socket_user = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"][i];
                            if (socket_user == "-1") {
                                //esta dañado, lo elimino
                                console.log("Esta dañado");
                                var pos = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].indexOf(socket_user);
                                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].splice(pos, 1);
                                array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].splice(pos, 1);
                                array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].splice(pos, 1);
                                array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].splice(pos, 1);
                            } else {
                                //esta bueno, lo valido
                                var existe = array_sockets.indexOf(socket_user);
                                if (existe < 0) {
                                    console.log("Ya no existe");
                                    //no existe ya el socket, lo elimino
                                    var pos = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].indexOf(socket_user);
                                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].splice(pos, 1);
                                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].splice(pos, 1);
                                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].splice(pos, 1);
                                    array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].splice(pos, 1);
                                } else {
                                    if (user_send != user_id) {
                                        socket_user.emit("messages", data);
                                    } else {

                                    }

                                }
                            }

                        }

                    }
                }

            }
        } else if (type == "logout") {
            var posicion = array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].indexOf(s_id);
            //actualizo los valores
            //elimino los valores
            array_sesiones_usuarios["usuarios"]["user_" + user_id]["sockets"].splice(posicion, 1);
            array_sesiones_usuarios["usuarios"]["user_" + user_id]["last_login"].splice(posicion, 1);
            array_sesiones_usuarios["usuarios"]["user_" + user_id]["devices"].splice(posicion, 1);
            array_sesiones_usuarios["usuarios"]["user_" + user_id]["addresses"].splice(posicion, 1);
            array_sesiones_usuarios["usuarios"]["user_" + user_id]["sessions_ids"].splice(posicion, 1);

            //voy a cerrar sesión
        }

        /* messages.push(data); */
        console.log(array_sesiones_usuarios);
        console.log(array_sesiones_usuarios["usuarios"]["user_" + user_id]);

        /* io.sockets.emit('messages', messages); */
    });

    //se va a desconectar el socket
    socket.on('disconnect', function(e) {

        delete array_sesiones_usuarios["id_sockets"][id_socket];
    });
});
server.listen(8080, function() {});

function getConnectedSockets() {
    return Object.values(io.of("/").connected);
}
getConnectedSockets().forEach(function(s) {
    /* s.disconnect(true); */
    console.log("Existe uno");
});