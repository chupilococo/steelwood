<?php
// Iniciamos sesión.
session_start();

// Preguntamos si el usuario está logueado y puede estar
// acá.
/*if(!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    $_SESSION['mensaje'] = "Tenés que iniciar sesión para poder crear noticias.";
    header('Location: ../index.php?s=noticias');
    exit;
}*/
require '../../libraries/data-usuarios.php';

redirectIfNotLogged('../');

require '../../acciones/conexion.php';
require '../../libraries/data-noticias.php';
require '../../libraries/image-functions.php'; // Para el resize de la imagen

// Recibimos los datos por POST.
$titulo     = $_POST['titulo'];
$sinopsis   = $_POST['sinopsis'];
$texto      = $_POST['texto'];
//$alt        = $_POST['alt'];
// Los tags los recibimos como un array de tags.
$tags       = $_POST['tags'];
//print_r($tags);
//exit;

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
if(empty($imagen['tmp_name'])) {
    $errores['imagen']  = "Debe elegir una imagen.";
}

// Check si subieron un archivo.
/*
if(!empty($imagen['tmp_name'])) {
    // Hay una imagen :D
}
*/

// Verificamos si hay errores...
if(count($errores) !== 0) {
    // Almacenamos los mensajes de error en una
    // variable de sesión.
    $_SESSION['errores'] = $errores;
    // Pasamos también los datos.
    $_SESSION['old_data'] = $_POST;
    header('Location: ../index.php?s=nueva-noticia');
    exit;
}

// Cambiamos el upload que teníamos por la función.
//$nombreImagen = time() . "_" . $imagen['name'];
//move_uploaded_file($imagen['tmp_name'], __DIR__ . '/../../imgs/' . $nombreImagen);
// Pasamos la imagen que sacamos de $_FILES, la ruta de la carpeta
// imágenes, null para no especificar ningún nombre, y true para que
// croppee las imágenes.
$nombresImagenes = generateSiteImages($imagen, __DIR__ . '/../../imgs/', null, true);

$exito = grabarNoticia($db, [
    'id_usuario' => 1, // Eventualmente el usuario logueado.
    'titulo' => $titulo,
    'sinopsis' => $sinopsis,
    'texto' => $texto,
//    'imagen' => $nombreImagen,
    'imagen' => $nombresImagenes['name'], // Cambiamos para guardar la imagen obtenida y redimensionada de la función.
]);

if($exito) {
    $idNoticia = mysqli_insert_id($db);
    // Ahora que la noticia grabó, y tenemos el id generado, podemos
    // hacer el insert de los tags para la noticia en la tabla pivot.
    $exitoTags = grabarTagsParaNoticia($db, $idNoticia, $tags);
    
    if($exitoTags) {
        // Pedimos el id de la noticia que se creó.
        // mysqli_insert_id($conexion)
        // Retorna el último id auto-generado por la
        // base de datos.
        header('Location: ../index.php?s=noticias');
    } else {
        echo "Error :(";
    }
} else {
//    header('Location: ../index.php?s=noticias');
    echo "Error :(";
}




