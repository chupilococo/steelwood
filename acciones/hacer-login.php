<?php
/*
En este archivo vamos a tratar de loguear al usuario.
Si tiene éxito, lo redireccionamos a otra pantalla.
Sino, lo reenviamos al formulario con los correspondientes
mensajes de error.
*/
// Iniciamos sesión.
session_start();

// Incluimos la conexión.
require 'conexion.php';
require '../libraries/data-usuarios.php';

// Capturamos los datos por POST.
$email      = $_POST['email'];
$password   = $_POST['password'];

// TODO: Validar...

// $id_usuario va a tener:
// a. Si salió bien, el ID del usuario.
// b. Sino, false.
$id_usuario = logUser($db, $email, $password);

if($id_usuario !== false) {
    // El usuario es correcto!
    // Marcamos como autenticado al usuario, usando una
    // variable de sesión.
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['email']      = $email;
    header('Location: ../index_santiago.php?s=home');
} else {
    // El usuario es incorrecto...
    $_SESSION['errores'] = ["login" => 'Email y/o password incorrectos.'];
    $_SESSION['old_data'] = $_POST;
    header('Location: ../index_santiago.php?s=login');
}








