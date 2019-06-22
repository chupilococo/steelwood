<?php
// Así se hace un logout, es RE difícil.

// 1. Abrimos la sesión (no puedo cerrar sesión si no tenemos
// la sesión).
session_start();

// 2a. Destruimos la sesión. Básicamente aniquila el archivo de
// texto con los valores.
//session_destroy();

// 2b. Eliminamos las variables de sesión del login.
unset($_SESSION['id_usuario'], $_SESSION['email']);

// 3. Redireccionamos.
header('Location: ../index.php?s=home');