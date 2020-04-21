<?php
require '../assets/plugins/phpMailer/PHPMailerAutoload.php';
include "../includes/mail-conect.php";
function enviar_correo($cuerpo,$correo,$nombre_usuario,$asunto){
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
    $mail->addAddress($correo, $nombre_usuario);     // Add a recipient
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->AddEmbeddedImage('../images/logo/ut-logo-96-px.png', 'logo_ut');
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
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

function send_email($asunto,$cuerpo,$correo,$nombre_usuario){
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
    $mail->Username = "sac@utl.edu.mx";                 // SMTP username
    $mail->Password = "skynet_andres633156";                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->isHTML(true);
    $mail->setFrom("sac@utl.edu.mx", 'SAC Universidad Tecnológica Linares');
    $mail->addAddress($correo, $nombre_usuario);     // Add a recipient
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->AddEmbeddedImage('../images/logo/ut-logo-96-px.png', 'logo_ut');
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
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
?>
