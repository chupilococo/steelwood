<?php
session_start();
require 'conexion.php';
if(empty($_POST["password"])):
    header("Location:".$_SERVER["HTTP_REFERER"]);
    die();
endif;

$password = password_hash($_POST["password"],PASSWORD_DEFAULT);

$query = <<<UPDATE
    UPDATE usuarios SET password = "$password" WHERE email = "$_SESSION[email]";
UPDATE;

$rta = mysqli_query($db, $query);

// Solo si se pudo actualizar el password del usuario
if($rta):
    $query = <<<DELETE
        DELETE FROM password_resets WHERE email = "$_SESSION[email]";
DELETE;

    $rta = mysqli_query($db, $query);
    if($rta):
        header("Location: ../index.php?s=login");
        die();
    endif;
endif;