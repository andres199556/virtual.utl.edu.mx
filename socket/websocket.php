<?php
include "../conexion/conexion.php";
$host = '127.0.0.1'; //host
$port = '9000'; //port
$null = NULL; //null var
function buscar_posicion($products, $field, $value)
{
   foreach($products as $key => $product)
   {
      if ( $product[2] === $value )
         return $key;
   }
   return false;
}
//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//bind socket to specified host
socket_bind($socket, 0, $port);

//listen to port
socket_listen($socket);

//create & add listning socket to the list
$clients = array($socket);
$clients_sid = array();
$array_sesiones_usuarios = array();
//start endless loop, so that our script doesn't stop
try{
while (true) {
  
  //manage multipal connections
  $changed = $clients;
  //returns the socket resources in $changed array
  socket_select($changed, $null, $null, 0, 10);
  
  
  
  //check for new socket
  if (in_array($socket, $changed)) {
    //ya se encuentra
    $socket_new = socket_accept($socket); //accpet new socket
    $clients[] = $socket_new; //add socket to client array
    /* $changed[] = $socket_new; */
    $header = socket_read($socket_new, 1024); //read data sent by the socket
    perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
    
    socket_getpeername($socket_new, $ip); //get ip address of connected socket
    socket_recv($socket_new, $buf, 1024, 0);
    $received_text = unmask($buf); //unmask data
    $tst_msg = json_decode($received_text); //json decode 
    $type_json = $tst_msg->type;
    $session_id_usuario = $tst_msg->sid;
    $user_id = $tst_msg->user_id;
    if($type_json == "login"){
      echo "echo se logueo";
      //se inicia sesión
      if(array_key_exists($user_id,$array_sesiones_usuarios)){
        //ya existe una sesion en el websocket con ese usuario
        //recorro las sessions_id
        if(!in_array($session_id_usuario,$array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"])){
          //es de una dirección diferente
          array_push($array_sesiones_usuarios[$tst_msg->user_id]["ip_addresses"],$ip);
          array_push($array_sesiones_usuarios[$tst_msg->user_id]["last_login"],date("Y-m-d H:i:s"));
          array_push($array_sesiones_usuarios[$tst_msg->user_id]["sockets"],$socket_new);
          array_push($array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"],$session_id_usuario);
          $response = mask(json_encode(array('type'=>'NewUserSession', 'message'=>$ip.' Se volvio a conectar'))); //prepare json data
        }
        else{
          //actualizo solo la hora y el nuevo socket
          $position = array_search($session_id_usuario,$array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"]);
          $array_sesiones_usuarios[$tst_msg->user_id]["last_login"][$position] = date("Y-m-d H:i:s");
          $array_sesiones_usuarios[$tst_msg->user_id]["sockets"][$position] = $socket_new;
          $response = mask(json_encode(array('type'=>'Reconect', 'message'=>$ip.' Se volvio a conectar'))); //prepare json data
          /* send_message($response); //notify all users about new connection */
        }
        
      }
      else{
        //no existe, por lo tanto la creo
        //busco el nombre del usuario
        $buscar_nombre = $conexion->query("SELECT CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
        FROM usuarios as U
        INNER JOIN personas as P ON U.id_persona = P.id_persona
        WHERE U.id_usuario = $user_id");
        $row_datos = $buscar_nombre->fetch(PDO::FETCH_ASSOC);
        //creo el array
        $array_sesiones_usuarios[$user_id] = array();
        $nombre_persona = $row_datos["persona"];
        $array_sesiones_usuarios[$tst_msg->user_id]["name"] = $nombre_persona;
        $array_sesiones_usuarios[$tst_msg->user_id]["ip_addresses"] = array();
        $array_sesiones_usuarios[$tst_msg->user_id]["last_login"] = array();
        $array_sesiones_usuarios[$tst_msg->user_id]["sockets"] = array();
        $array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"] = array();
        array_push($array_sesiones_usuarios[$tst_msg->user_id]["ip_addresses"],$ip);
        array_push($array_sesiones_usuarios[$tst_msg->user_id]["last_login"],date("Y-m-d H:i:s"));
        array_push($array_sesiones_usuarios[$tst_msg->user_id]["sockets"],$socket_new);
        array_push($array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"],$session_id_usuario);
        $response = mask(json_encode(array('type'=>'logInUser', 'message'=>$ip.' se conecto por primera vez'))); //prepare json data
        /* send_message($response); //notify all users about new connection */
        send_response($socket_new,$response);
      }
      print_r($array_sesiones_usuarios);
    }
    else if($type_json == "reload"){
      //estoy recargando las paginas
      if (array_key_exists($user_id, $array_sesiones_usuarios)) {
          //ya existe una sesion en el websocket con ese usuario
          //recorro las sessions_id
          if (!in_array($session_id_usuario, $array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"])) {
              //es de una dirección diferente
              array_push($array_sesiones_usuarios[$tst_msg->user_id]["ip_addresses"], $ip);
              array_push($array_sesiones_usuarios[$tst_msg->user_id]["last_login"], date("Y-m-d H:i:s"));
              array_push($array_sesiones_usuarios[$tst_msg->user_id]["sockets"], $socket_new);
              array_push($array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"], $session_id_usuario);
              $response = mask(json_encode(array('type'=>'NewUserSession', 'message'=>$ip.' Se volvio a conectar'))); //prepare json data
          } else {
              //actualizo solo la hora y el nuevo socket
              $position = array_search($session_id_usuario, $array_sesiones_usuarios[$tst_msg->user_id]["sessions_ids"]);
              $array_sesiones_usuarios[$tst_msg->user_id]["last_login"][$position] = date("Y-m-d H:i:s");
              $array_sesiones_usuarios[$tst_msg->user_id]["sockets"][$position] = $socket_new;
              $response = mask(json_encode(array('type'=>'Reconect', 'message'=>$ip.' Se volvio a conectar'))); //prepare json data
          /* send_message($response); //notify all users about new connection */
          }
      }
    }
    
    else if($type_json == "message_sended"){

    }
    else if($type_json == "notification"){

    }
    
  }
    //loop through all connected sockets
  foreach ($changed as $changed_socket) {  
    //check for any incomming data
    $bytesocket=@socket_recv($changed_socket, $buf, 1024, 0);
    while($bytesocket >= 1){
      print_r($changed);
      print_r($array_sesiones_usuarios);
      $received_text = unmask($buf); //unmask data
      $tst_msg = json_decode($received_text); //json decode 
      $type = $tst_msg->type;
      if($type == "message_sended"){
        //se envio un mensaje
        print_r($tst_msg);
        $mensajes = $tst_msg->array_messages;
        $cantidad_mensajes = $tst_msg->cantidad;
        $id_destinatario = $tst_msg->user_id;
        $id_conversacion = $tst_msg->conversation;
        $tipo_conversacion = $tst_msg->conversation_type;
        $tipo_mensaje = $tst_msg->message_type;
        $nickname = $tst_msg->nickname;
        $nickname2 = $tst_msg->nickname2;
        if($tipo_conversacion == "normal"){
          //busco si el destinatario tiene sesion activa
          if(array_key_exists($id_destinatario,$array_sesiones_usuarios)){
            echo "Ya existe el destinatario logueado";
            $cantidad_sockets = count($array_sesiones_usuarios[$id_destinatario]["sessions_ids"]);
              $msg = mask(
                json_encode(
                  array(
                    'type' =>'recived_message',
                    'id_conversacion' => $id_conversacion,
                    'tipo_conversacion' => $tipo_conversacion,
                    'cantidad_mensajes' => $cantidad_mensajes,
                    'nickname' => $nickname,
                    'nickname2' => $nickname2,
                    'mensajes' => $mensajes
                  )
                )
              );
              for($i = 0;$i<$cantidad_sockets;$i++){
                $socket_usuario = $array_sesiones_usuarios[$id_destinatario]["sockets"][$i];
                send_response($socket_usuario,$msg);
              }
          }
          else{
            echo "no";
          }
        }
      }
      break 2; //exist this loop
    }
    
    $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
    /* if ($buf === false) { // check disconnected client
      // remove client for $clients array
      $found_socket = array_search($changed_socket, $clients);
      socket_getpeername($changed_socket, $ip);
      unset($clients[$found_socket]);
      
      //notify all users about disconnected connection
      $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
      send_message($response);
    } */
  }
  
    /* $bytesocket=@socket_recv($changed_socket, $buf, 1024, 0);
    print_r($bytesocket); */
    
    /* while ($bytesocket >= 1) {
      $received_text = unmask($buf); //unmask data
      $tst_msg = json_decode($received_text); //json decode
      /* print_r($tst_msg);
    } */   
  
  //loop through all connected sockets
    
  /* socket_getpeername($socket_new, $ip); //get ip address of connected socket */
  /* foreach ($changed as $changed_socket) {
    $bytesocket=@socket_recv($changed_socket, $buf, 1024, 0);
    while ($bytesocket >= 1) {
      $received_text = unmask($buf); //unmask data
      $tst_msg = json_decode($received_text); //json decode
      print_r($tst_msg);
    }   
  } */
    /* $received_text = unmask($buf); //unmask data
      $tst_msg = json_decode($received_text); //json decode
      print_r($tst_msg); */
    /* while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
      $received_text = unmask($buf); //unmask data
      $tst_msg = json_decode($received_text); //json decode
      print_r($tst_msg);
    }  */
  
    /* foreach($sesiones_activas["sockets"] as $socket_usuarios_for){
      socket_select($socket_usuarios_for, $null, $null, 0, 10);
      while (socket_recv($socket_usuarios_for, $buf, 1024, 0) >= 1) {
          $received_text = unmask($buf); //unmask data
        $tst_msg = json_decode($received_text); //json decode
        print_r($tst_msg);
      }
    }
  }
  /* foreach ($array_sesiones_usuarios as $sesiones_activas) {
    foreach($sesiones_activas["sockets"] as $socket_usuarios_for){
        while(socket_recv($socket_usuarios_for, $buf, 1024, 0) >= 1){
          $received_text = unmask($buf); //unmask data
          $tst_msg = json_decode($received_text); //json decode
          $type_json = $tst_msg->type;
          //estoy recibiendo la notificacion de que un mensaje ha sido enviado
          $tipo_conversacion = $tst_msg->conversation_type; #tipo de conversacion si normal o grupo
          $tipo_mensaje = $tst_msg->message_type; #tipo de mensaje texto o enlace
          $id_conversacion = $tst_msg->conversation; #id de la conversacion
          $id_mensaje = $tst_msg->message_id; #id del mensaje enviado
          $fecha_hora = $tst_msg->date; #fecha y hora del mensaje
          $mensaje = $tst_msg->message; #mensaje recibido

          if($tipo_conversacion == "normal"){
            //es solo una conversacion de dos personas
            $id_destinatario = $tst_msg->user_id; #id del usuario remitente
            //busco si en los sockets se encuentra el usuario del mensaje
            $existe_socket = array_key_exists($id_destinatario,$array_sesiones_usuarios);
            if($existe_socket == true){
              //si existe el socket del usuario
              $cantidad_sockets = $array_sesiones_usuarios[$id_destinatario]["sessions_ids"];
              $msg = array(
                'type' =>'recived_message',
                'id_conversacion' => $id_conversacion,
                'id_mensaje' => $id_mensaje,
                'fecha_hora' => $fecha_hora,
                'mensaje' => $mensaje
              );
              $msg = mask(json_encode($msg));
              for($i = 0;$i<$cantidad_sockets;$i++){
                $socket_usuario = $array_sesiones_usuarios[$id_destinatario]["sockets"][$i];
                send_response($socket_usuario,$msg);
                echo "Si existe el socket";
              }
            }
          }
          else{
            
          }
        break 3; //exist this loop
      }
    }
    //check for any incomming data
    
    
    $buf = @socket_read($socket_usuarios_for, 1024, PHP_NORMAL_READ);
   /*  if ($buf === false) { // check disconnected client
      // remove client for $clients array
      $found_socket = array_search($changed_socket, $clients);
      socket_getpeername($changed_socket, $ip);
      unset($clients[$found_socket]);
      
      //notify all users about disconnected connection
      $response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
      send_message($response);
    } 
  } */
  // close the listening socket
}
socket_close($socket);
}

catch(Exception $error){
  echo $error->getMessage();
}

function send_response($socket,$msg){
  @socket_write($socket,$msg,strlen($msg));
  return true;
}
function send_message($msg, $to_users = false)
{
  global $clients, $clients_sid;
  
  if ($to_users) {
    
    foreach($clients_sid as $key => $value) {
      if (in_array($key, $to_users)) {
        @socket_write($value['socket'], $msg, strlen($msg));
      }
    }
    return true;
    
  }

  foreach($clients as $changed_socket) {
    @socket_write($changed_socket,$msg,strlen($msg));
  }
  return true;
}


//Unmask incoming framed message
function unmask($text) {
  $length = ord($text[1]) & 127;
  if($length == 126) {
    $masks = substr($text, 4, 4);
    $data = substr($text, 8);
  }
  elseif($length == 127) {
    $masks = substr($text, 10, 4);
    $data = substr($text, 14);
  }
  else {
    $masks = substr($text, 2, 4);
    $data = substr($text, 6);
  }
  $text = "";
  for ($i = 0; $i < strlen($data); ++$i) {
    $text .= $data[$i] ^ $masks[$i%4];
  }
  return $text;
}

//Encode message for transfer to client.
function mask($text)
{
  $b1 = 0x80 | (0x1 & 0x0f);
  $length = strlen($text);
  
  if($length <= 125)
    $header = pack('CC', $b1, $length);
  elseif($length > 125 && $length < 65536)
    $header = pack('CCn', $b1, 126, $length);
  elseif($length >= 65536)
    $header = pack('CCNN', $b1, 127, $length);
  return $header.$text;
}

//handshake new client.
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
  $headers = array();
  $lines = preg_split("/\r\n/", $receved_header);
  foreach($lines as $line)
  {
    $line = chop($line);
    if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
    {
      $headers[$matches[1]] = $matches[2];
    }
  }

  $secKey = $headers['Sec-WebSocket-Key'];
  $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
  //hand shaking header
  $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
  "Upgrade: websocket\r\n" .
  "Connection: Upgrade\r\n" .
  "WebSocket-Origin: $host\r\n" .
  "WebSocket-Location: ws://$host:$port/websocket.php\r\n".
  "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
  socket_write($client_conn,$upgrade,strlen($upgrade));
}


function users_list($users){

  $list = array();
  foreach($users as $key => $value) {
    $list[] = array(
      'name' => $value['name'],
      'id'   => $key
    );
  }
  return $list;

}