<?php
require 'conexion.php';
require_once "../Mail.php";

if(empty($_POST["email"])):
    header("Location: ../index.php?s=recuperar_clave");
    die();
endif;

$email = $_POST["email"];

// chequear en nuestra db si ese email existe

$query = <<<QUERY
    SELECT id_usuario FROM usuarios WHERE email = "$email";
QUERY;

$rta = mysqli_query($db, $query);

// El email no existe en mi db
if(mysqli_num_rows($rta) == 0):
    header("Location: ../index.php?s=recuperar_clave");
    die();
endif;

// Generar el token
$token = password_hash($email.time(),PASSWORD_DEFAULT);

// INSERTAR ESOS DOS DATOS EN LA TABLA PASSWORD_RESETS
// Si está duplicado el email actualizo el token en vez de cargar uno nuevo
$query = <<<INSERT
    INSERT INTO password_resets SET email = "$email", token = "$token" ON DUPLICATE KEY UPDATE token = "$token";
INSERT;

$rta = mysqli_query($db, $query);

if($rta):
    /*----------------------------------------
    | Ejemplo con php nativo
    +-----------------------------------------*/
    /*
    Para enviar emails con php, necesitamos definir 4 cosas:
    1. Destinatario: A quién le queremos enviar el email.
    2. Asunto
    3. El cuerpo (por defecto, txt, salvo que le aclaremos que va a ser 
                HTML).
    4. "Headers". Pares de [nombre: valor] (sin corchetes) que configuran
        detalles del envío.
        De estos, hay uno que necesitamos definir que es el "From:", que
        es la dirección que "envía" el email. Técnicamente no envía nada,
        sino que simplemente indica el remitente.
    */
    $destinatario = $email;
    $asunto = "Sitio: Recuperar contraseña";
    // $cuerpo = file_get_contents('email-template.html');
    // $cuerpo = str_replace('{{EMAIL}}', $email, $cuerpo);
    // $cuerpo = str_replace('{{TOKEN}}', $token, $cuerpo);
    $cuerpo = <<<MENSAJE
                    <html>
                    <head>
                        <title>Recuperar clave</title>
                    </head>
                    <body style="width: 100%;">
                    <div style="width: 75%;margin:auto; padding:15px; background-color: #2E6DB4;border-bottom: 5px solid #ffca0a;height:40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                        <img src="https://a.espncdn.com/combiner/i?img=/redesign/assets/img/icons/ESPN-icon-basketball.png&w=288&h=288&transparent=true"
                            alt="Logo" width="40" style="float: left;">
                        <span style="float: left;margin-top: 20px; font-size: 18px;margin-left: 15px;font-weight: bold;color:white;">Saraza Basket</span>
                    </div>
                    
                    <div style="width: 75%;margin:auto; padding:15px;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    
                        <h1 style="font-size: 18px;">¿Te olvidaste tu clave?</h1>
                        <p>No te preocupes, nosotros nos vamos a encargar de que puedas volver a entrar. Solamente hacé click en el siguiente <b><a href="http://localhost/proyecto/index.php?s=cambiar_clave&email=$email&token=$token">link</a></b> </p>
                    
                        <p style="margin-top:50px;margin-bottom:0;">Muchas gracias</p>
                        <p style="font-size:12px;margin-top:0">Saraza Basket</p>
                    </div>
                    </body>
                    </html>
                        
MENSAJE;
    // Los headers van uno por línea, así que se separan con un salto de
    // línea, que se representa como "\r\n".
    // Primero, definimos el From.
    $headers = "From: no-reply@sitio.com" . "\r\n";
    // Después, le configuramos que se pueda enviar como HTML.
    // (Noten que lo concatenamos con .=).
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8" . "\r\n";

    // Tratamos de enviar el email.
    if(mail($destinatario, $asunto, $cuerpo, $headers)) {
        header("Location: ../index.php?s=exito-email");
        exit;
    } else {
        // Server posta.
//        $_SESSION['error'] = "El email no pudo ser enviado.";
//        header("Location: ../index.php?s=recuperar_clave");
//        exit;
        
        // Para testear.
        // Guardamos el email en un archivo de texto.
        file_put_contents('emails/' . time() . "_email-recuperar-password.html", $cuerpo);
        header("Location: ../index.php?s=exito-email");
        exit;
    }


    /*----------------------------------------
    | Ejemplo con PHPMailer
    +-----------------------------------------*/
    // mandar el email con los datos del usuario
    /*$datos = [
        "debug" => 2, // 0 -> desactivado, 1-> texto plano, 2-> html
        "host"  => 'smtp.mailtrap.io',
        "usuario" => '4dfda44ebf3281',
        "password" => '73779bb900e037',
        "puerto"   => 25,
        "from"     => "nosotros@basket.com",
        "to"       => $email,
        "cc"       => "",
        "replyTo"  => "",
        "subject"  => "Recuperar clave",
        "message"  => <<<MENSAJE
                    <html>
                    <head>
                        <title>Recuperar clave</title>
                    </head>
                    <body style="width: 100%;">
                    <div style="width: 75%;margin:auto; padding:15px; background-color: #2E6DB4;border-bottom: 5px solid #ffca0a;height:40px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                        <img src="https://a.espncdn.com/combiner/i?img=/redesign/assets/img/icons/ESPN-icon-basketball.png&w=288&h=288&transparent=true"
                            alt="Logo" width="40" style="float: left;">
                        <span style="float: left;margin-top: 20px; font-size: 18px;margin-left: 15px;font-weight: bold;color:white;">Saraza Basket</span>
                    </div>
                    
                    <div style="width: 75%;margin:auto; padding:15px;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    
                        <h1 style="font-size: 18px;">¿Te olvidaste tu clave?</h1>
                        <p>No te preocupes, nosotros nos vamos a encargar de que puedas volver a entrar. Solamente hacé click en el siguiente <b><a href="http://localhost/proyecto/index.php?s=cambiar_clave&email=$email&token=$token">link</a></b> </p>
                    
                        <p style="margin-top:50px;margin-bottom:0;">Muchas gracias</p>
                        <p style="font-size:12px;margin-top:0">Saraza Basket</p>
                    </div>
                    </body>
                    </html>
                        
MENSAJE
    ];
    
    // hago un new Mail con el array de datos
    // devuelve un bool dependiendo si se mandó o no el mail
    $email = new Mail($datos);
    
    if($email):
        header("Location: ../index.php");
        die();
    else:
        header("Location: ../index.php?s=recuperar_clave");
        die();
    endif;*/

endif;
