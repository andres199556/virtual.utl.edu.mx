<?php
require '../assets/plugins/phpMailer/PHPMailerAutoload.php';
include "../includes/mail-conect.php";
class correos{
    private $destinatario;
    private $asunto;
    private $mensaje;
    private $nombre;
    public function __construct($as,$des,$name){
        $this->destinatario = $des;
        $this->asunto = $as;
        $this->nombre = $name;
    }

    public function send_mail_plain($message){
        $resultado = false;
        $mail = new PHPMailer;
        $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
        $mail->Port = 465;                                    // TCP port to connect to
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = "soporte@utl.edu.mx";                 // SMTP username
        $mail->Password = "skynet_andres199556";                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->isHTML(true);
        $mail->setFrom("soporte@utl.edu.mx", 'Soporte Técnico UTL');
        $mail->addAddress($this->destinatario, $this->nombre);     // Add a recipient
        $mail->Subject = $this->asunto;
        $mail->Body    = $message;
        if(!$mail->send()) {
            //error
            $resultado = false;
        } 
        else {
            
            //el correo se envió
            $resultado = true;
        }
        
        return $resultado;
    }
}
?>