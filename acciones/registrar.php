<?php
// Iniciamos la sesión.
session_start();

// Requerimos la base de datos.
require 'conexion.php';
require '../libraries/data-usuarios.php';

// Capturamos los datos del form.
$email      = $_POST['email'];
$password   = $_POST['password'];
$cpassword  = $_POST['cpassword'];
$nombre     = $_POST['nombre'];
$apellido   = $_POST['apellido'];
$avatar     = $_FILES['avatar'];

// Validación.
$errores = [];

// Email
if(empty($email)) {
    $errores['email'] = 'El email no puede quedar vacío.';
} 
// filter_var permite "filtrar" una variable, según algún
// filtro nativo de php preestablecido.
// Si el valor no corresponde con el filtro, retorna 
// false.
// Sino, retorna el mismo valor.
// FILTER_VALIDATE_EMAIL valida el formato de email.
// https://www.php.net/manual/es/filter.filters.validate.php
else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errores['email'] = "El email no parece tener un formato correcto.";
}

// Password.
if(empty($password)) {
    $errores['password'] = "El password no puede quedar vacío.";
} else if(strlen($password) < 6) {
    $errores['password'] = "El password debe tener al menos 6 caracteres.";
} 
// Comparamos que el password coincida con su confirmación
else if($password !== $cpassword) {
    $errores['password'] = "El password no coincide con su confirmación.";
}

if(count($errores) !== 0) {
    // Error...
    $_SESSION['errores'] = $errores;
    $_SESSION['old_data'] = [
        'email_r'   => $_POST['email'],
        'password_r'=> $_POST['password'],
        'cpassword' => $_POST['cpassword'],
        'nombre'    => $_POST['nombre'],
        'apellido'  => $_POST['apellido'],
    ];
    header('Location: ../index_santiago.php?s=login');
    exit;
}

// La imagen la hacemos opcional...
if(!empty($avatar['tmp_name'])) {
    // time() retorna la fecha y hora actual en formato
    // UNIX timestamp.
    // UNIX timestamp se mide como la cantidad de
    // segundos que pasaron desde el Epoch (01-01-1970)
    // hasta hoy.
    $nombreImagen = time() . "_" . $avatar['name'];
    
    move_uploaded_file($avatar['tmp_name'], __DIR__ . '/../imgs/users/' . $nombreImagen);
} else {
    $nombreImagen = "";
}

$id_usuario = registrarUsuario($db, [
    'email'     => $email,
    'password'  => $password,
    'nombre'    => $nombre,
    'apellido'  => $apellido,
    'avatar'    => $nombreImagen
]);


if($id_usuario !== false) {
//    echo "Usuario registrado! :D";
    // Marcamos como logueado al usuario.
    $_SESSION['id_usuario'] = $id_usuario;
    $_SESSION['email']      = $email;
    header('Location: ../index_santiago.php?s=home');
} else {
    echo "Error... :(";
}






