<?php
class server_ssh{
    private $server = "128.100.0.2";
    private $user  ="soporte";
    private $password = "skynet_andres633156";
    private $ssh;
    private $arguments = false;
    private $comm = "";
    public $argumentos = "";
    
    public function get_connection(){
        $ssh = new Net_SSH2($this->server);
        $ssh->login($this->user, $this->password);
        return $ssh;
    }
    public function prepare($command,$lleva_argumentos){
        $this->comm = $command;
        $this->arguments = $lleva_argumentos;
    }
    public function run_command($conexion){
        if($this->arguments == false){
            //no lleva argumentos
            $command = "echo ".$this->password." | sudo -S ".$this->comm;
        }
        else{
            //si lleva argumentos
            $command = "echo ".$this->password." | sudo -S ".$this->comm." ".$this->argumentos;
        }
        $result = $conexion->exec($command);
        return $result;
    }
}
?>