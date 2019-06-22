<?php
// Iniciamos sesión.
session_start();

// Incluimos la conexión, para que ya quede creada en
// las secciones.
require 'acciones/conexion.php';

// Lista de secciones permitidas.
// Verificación por "Whitelist".
$sectionsAvailable = ['home', 'login', 'noticias', 'leer-noticia', 'perfil', '404','recuperar_clave','cambiar_clave'];

// Usando el operador de php 7: Null coalesce (??)
// Null coalesce funciona de la siguiente manera:
$section = $_GET['s'] ?? 'home';
// Significa "Si $_GET['s'] existe y es un valor distinto
// a null, usalo. Sino, usá el default a continuación."
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saraza Basket :: Ranking de la temporada regular</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header id="main-header">
        <h1>Saraza Basket</h1>
        <p>Enterate de todas las novedades sobre la NBA</p>
    </header>
    <nav id="main-nav">
        <ul>
            <li><a href="index.php?s=home">Home</a></li>
            <li><a href="index.php?s=noticias">Noticias</a></li>
            <li><a href="admin/index.php">Panel</a></li>
        <?php
        if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])):
        ?>
<!--            <li><a href="index.php?s=crear-noticia">Crear noticia</a></li>-->
            <li><a href="index.php?s=perfil"><?= $_SESSION['email'];?> (Ir a mi perfil)</a></li>
        <?php
        else:
        ?>
            <li><a href="index.php?s=login">Iniciar Sesión</a></li>
        <?php
        endif;
        ?>
        </ul>
    </nav>
    <?php
    // Acá va el contenido :)
    // Capturamos por $_GET la sección que el usuario quiere
    // cargar.
    // Verificamos que la sección exista.
    // in_array retorna true si el valor que buscamos existe
    // en el array que le pasamos.
    if(in_array($section, $sectionsAvailable)) {
        require 'sections/' . $section . '.php';
    } else {
        // Redireccionamos a una sección de "Not Found".
        // Para redireccionar en php, tenemos la siguiente
        // instrucción:
        // header('Location: ruta-a-donde-lo-mandan.ext');
        header('Location: index.php?s=404');
    }
    ?>
    <footer id="main-footer">
        <p>&copy; Da Vinci - 2018</p>
    </footer>
</body>
</html>