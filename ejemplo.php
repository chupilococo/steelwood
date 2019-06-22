<?php
require_once "Mail.php";



$nombre = empty($_POST["nombre"]) ? "anonimo" : $_POST["nombre"] ;

$email = $_POST["email"];

$contenido = $_POST["comentario"];

$datos = [
    "debug" => 2, // 0 -> desactivado, 1-> texto plano, 2-> html
    "host"  => 'smtp.mailtrap.io',
    "usuario" => '8afedc72cb4fdf',
    "password" => '8a98b174d2ef77',
    "puerto"   => 25,
    "from"     => "joni@mail.com",
    "to"       => $email,
    "cc"       => "",
    "replyTo"  => "",
    "subject"  => "Mensaje desde la web",
    "message"  => $contenido
];

//
$email = new Mail($datos);

if($email)
    echo "envió";
else
    echo "no envió";
