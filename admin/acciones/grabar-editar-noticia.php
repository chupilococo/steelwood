<?php

session_start();

require '../../libraries/data-usuarios.php';
redirectIfNotLogged('../../');

require '../../libraries/data-noticias.php';
require '../../libraries/image-functions.php';
require '../../acciones/conexion.php';
$id_noticia = $_GET['id'];
$titulo     = $_POST['titulo'];
$sinopsis   = $_POST['sinopsis'];
$texto      = $_POST['texto'];

$imagen = $_FILES['imagen'];

$errores = [];

if(empty($titulo)) {
    $errores['titulo'] = "El título no puede estar vacío.";
} else if(strlen($titulo) < 3) {
    $errores['titulo'] = "El título debe tener al menos 3 caracteres.";
}

if(empty($sinopsis)) {
    $errores['sinopsis'] = "La sinopsis no puede estar vacía.";
}

if(count($errores) !== 0) {
    $_SESSION['errores'] = $errores;
    $_SESSION['old_data'] = $_POST;
    header('Location: ../index_santiago.php?s=editar-noticia&id=' . $id_noticia);
    exit;
}

if(!empty($imagen['tmp_name'])) {
    $nombresImagenes = generateSiteImages($imagen, __DIR__ . '/../../imgs/', null, true);
    $nombreImagen = $nombresImagenes['name'];
} else {
    $nombreImagen = $_POST['imagen_actual'];
}

$exito = editarNoticia($db, $id_noticia, [
    'titulo' => $titulo,
    'sinopsis' => $sinopsis,
    'texto' => $texto,
    'imagen' => $nombreImagen
]);

if($exito) {
    if(!empty($imagen['tmp_name'])) {
        unlink(__DIR__ . '/../../imgs/' . $_POST['imagen_actual']);
        unlink(__DIR__ . '/../../imgs/' . str_replace('.jpg', '-big.jpg', $_POST['imagen_actual']));
    }
    
    header('Location: ../index_santiago.php?s=noticias');
} else {
    $_SESSION['errores'] = ['db' => "Error al grabar en la base. Por favor, volvé a intentarlo más tarde."];
    header('Location: ../index_santiago.php?s=editar-noticia&id' . $id_noticia);
}