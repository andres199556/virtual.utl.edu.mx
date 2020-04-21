<?php
class dataServer{
    public $server_url = "http://128.100.0.2:3000/";
    private $host;
    private $type;
    private $user = "admin";
    private $password = "topsecret";
    public function __construct(){
        /* $this->host = $host;
        $this->type = $type; */
    }
    public function get_data_host($host){
        $this->host = $host;
        $url = $this->server_url."lua/host_get_json.lua?ifid=1&host=".$host;
        // abrimos la sesión cURL
        $ch = curl_init();
        
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,$url);
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array("Content-type: application/json") );
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".$user."&password=".$password);
        
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        
        // cerramos la sesión cURL
        curl_close ($ch);
        $div = explode("\r\n\r\n",$remote_server_output);
        $data_json = json_decode($div[1],true);
        return $data_json;
    }
    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
?>