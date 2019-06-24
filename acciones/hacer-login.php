<?php
session_start();
require 'conexion.php';
require '../libraries/data-usuarios.php';
$email      = $_POST['email'];
$password   = $_POST['password'];


if(isset($_SESSION['backUrl'])){
    $back=$_SESSION['backUrl'];
    unset($_SESSION['backUrl']);
}else{
    $back='../index.php';
}

// TODO: Validar...

$id_usuario = logUser($db, $email, $password);

if($id_usuario !== false) {
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['email']      = $email;
    header('Location: '.$back);
} else {
    $_SESSION['errores'] = ["login" => 'Email y/o password incorrectos.'];
    $_SESSION['old_data'] = $_POST;
    header('Location: ../index.php?s=login');
}
