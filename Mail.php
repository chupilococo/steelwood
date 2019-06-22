<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

    public function __construct(Array $datos)
    {

        $mail = new PHPMailer(true);
        $mail->setLanguage('es', 'vendor/phpmailer/phpmailer/language/');

        try {
            //Server settings
            $mail->SMTPDebug = $datos['debug'];                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host       = $datos['host'];  // Specify main and backup SMTP servers
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $datos['usuario'];                     // SMTP username
            $mail->Password   = $datos['password'];                               // SMTP password
            $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port       = $datos['puerto'];                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($datos['from']);
            $mail->addAddress($datos['to']);     // Add a recipient
            if(!empty($datos['replyTo']))
                $mail->addReplyTo($datos['replyTo']);

            if(!empty($datos['cc']))
                $mail->addCC($datos['cc']);

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $datos['subject'];
            $mail->Body    = $datos['message'];

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "No se pudo mandar el mail. Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}