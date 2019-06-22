<?php
/*
Vamos a recibir los datos del form de edición, validarlos,
y si está todo ok, editar el registro en la base de datos.
*/
session_start();

require '../../libraries/data-usuarios.php';
redirectIfNotLogged('../../'); // Salimos de admin/acciones/

require '../../libraries/data-noticias.php';
require '../../libraries/image-functions.php';
require '../../acciones/conexion.php';

// Capturamos los datos.
//echo "<pre>";
//print_r($_GET);
//print_r($_POST);
//echo "</pre>";
$id_noticia = $_GET['id'];
$titulo     = $_POST['titulo'];
$sinopsis   = $_POST['sinopsis'];
$texto      = $_POST['texto'];

$imagen = $_FILES['imagen'];

//****************************
// Validación
//****************************
// Generamos un array de errores, para agregar
// los errores que vayamos encontrando.
$errores = [];

// Validamos que el título sea obligatorio.
if(empty($titulo)) {
    $errores['titulo'] = "El título no puede estar vacío.";
} else if(strlen($titulo) < 3) {
    $errores['titulo'] = "El título debe tener al menos 3 caracteres.";
}

// Validamos que el título sea obligatorio.
if(empty($sinopsis)) {
    $errores['sinopsis'] = "La sinopsis no puede estar vacía.";
}

// Validamos que haya una imagen.
//if(empty($imagen['tmp_name'])) {
//    $errores['imagen']  = "Debe elegir una imagen.";
//}

// Verificamos si hay errores...
if(count($errores) !== 0) {
    // Almacenamos los mensajes de error en una
    // variable de sesión.
    $_SESSION['errores'] = $errores;
    // Pasamos también los datos.
    $_SESSION['old_data'] = $_POST;
    header('Location: ../index_santiago.php?s=editar-noticia&id=' . $id_noticia);
    exit;
}

// Solo subimos la imagen si el usuario eligió una.
if(!empty($imagen['tmp_name'])) {
//    $nombreImagen = time() . "_" . $imagen['name'];
//    move_uploaded_file($imagen['tmp_name'], __DIR__ . '/../../imgs/' . $nombreImagen);
    $nombresImagenes = generateSiteImages($imagen, __DIR__ . '/../../imgs/', null, true);
    $nombreImagen = $nombresImagenes['name'];
//    die(__DIR__ . '/../../imgs/' . $nombreImagen);
    
    // Si se sube una imagen nueva, para poder eliminar la
    // anterior, buscamos la imagen actual.
//    $noticia = traerNoticiaPorId($db, $id_noticia);
    
//    print_r($noticia);
//    die;
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
    // Acá deberíamos borrar la imagen anterior, si se
    // grabó una nueva.
    if(!empty($imagen['tmp_name'])) {
        // Eliminamos la imagen anterior.
        // Para eliminar un archivo, usamos la función
        // unlink().
//        unlink(__DIR__ . '/../../imgs/' . $noticia['imagen']);
        unlink(__DIR__ . '/../../imgs/' . $_POST['imagen_actual']);
        unlink(__DIR__ . '/../../imgs/' . str_replace('.jpg', '-big.jpg', $_POST['imagen_actual']));
    }
    
    header('Location: ../index_santiago.php?s=noticias');
} else {
    $_SESSION['errores'] = ['db' => "Error al grabar en la base. Por favor, volvé a intentarlo más tarde."];
    header('Location: ../index_santiago.php?s=editar-noticia&id' . $id_noticia);
}










