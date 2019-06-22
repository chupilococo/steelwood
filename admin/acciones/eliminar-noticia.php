<?php
/*
Acá vamos a, si el usuario tiene acceso a la página,
eliminar la noticia que nos piden (incluyendo su imagen),
y luego, como modificamos la info del servidor, lo 
redireccionamos al panel con un mensaje de éxito.
*/
// Verificamos que el usuario esté autenticado.
session_start();

require '../../libraries/data-usuarios.php';
redirectIfNotLogged('../../');

// Incluimos lo que necesitamos.
require '../../acciones/conexion.php';
require '../../libraries/data-noticias.php';

// Capturamos el id de la noticia.
$id = $_GET['id'];

// Tratamos de eliminar la noticia.
$exito = eliminarNoticia($db, $id);

//var_dump($exito);

if($exito) {
    $_SESSION['mensaje'] = "La noticia fue eliminada exitosamente.";
    header('Location: ../index_santiago.php?s=noticias');
} else {
    $_SESSION['mensaje'] = "Error al tratar de eliminar la noticia <b>" . $id . "</b>.";
    header('Location: ../index_santiago.php?s=noticias');
}







