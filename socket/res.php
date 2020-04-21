<?php
//include "../conexion/conexion.php";
$host = 'localhost'; //host
$port = '9000'; //port
$null = NULL; //null var

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
    
    //acepto la conexion del socket
    $socket_new = socket_accept($socket); //acepto la conexion del socket
    $header = socket_read($socket_new, 1024); //read data sent by the socket
    perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake  
    socket_getpeername($socket_new, $ip); //get ip address of connected socket
    $header = socket_read($socket_new, 1024); //read data sent by the socket
    perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
    //acepto la conexion del socket
    //recibo los datos enviados por el usuario conectado
    socket_recv($socket_new, $buf, 1024, 0);
    //los guardo en una array
    $received_text = unmask($buf); //unmask data
    //descompongo el array
    $mensaje = json_decode($received_text); //json decode 
    $session_id_usario = $mensaje->sid;
    $user_id = $mensaje->user_id;
    /* if(array_key_exists($user_id,$array_sesiones_usuarios)){
      //ya existe una sesion en el websocket con ese usuario
      $response = mask(json_encode(array('type'=>'Reconect', 'message'=>$ip.' Se volvio a conectar'))); //prepare json data
      send_message($response); //notify all users about new connection
    }
    else{
      //no existe, por lo tanto la creo
      //busco el nombre del usuario
      $buscar_nombre = $conexion->query("SELECT CONCAT(P.nombre,' ',P.ap_paterno,' ',P.ap_materno) as persona
      FROM usuarios as U
      INNER JOIN personas as P ON U.id_persona = P.id_persona
      WHERE U.id_usuario = $user_id");
      $row_datos = $buscar_nombre->fetch(PDO::FETCH_ASSOC);
      $nombre_persona = $row_datos[0];
      $array_sesiones_usuarios[$mensaje->user_id]["name"] = $nombre_persona;
      $array_sesiones_usuarios[$mensaje->user_id]["ip_addresses"] = array();
      $array_sesiones_usuarios[$mensaje->user_id]["sockets"] = array();
      $array_sesiones_usuarios[$mensaje->user_id]["sessions_ids"] = array();
      array_push($array_sesiones_usuarios[$mensaje->user_id]["ip_addresses"],$ip);
      array_push($array_sesiones_usuarios[$mensaje->user_id]["sockets"],$socket_new);
      array_push($array_sesiones_usuarios[$mensaje->user_id]["sessions_ids"],$session_id_usario);
      $response = mask(json_encode(array('type'=>'logInUser', 'message'=>$ip.' se conecto por primera vez'))); //prepare json data
      send_message($response); //notify all users about new connection
    } */
  }
  echo "#asdasd";
  // close the listening socket
socket_close($sock);
}
catch(Exception $error){
  echo $error->getMessage();
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
  "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
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