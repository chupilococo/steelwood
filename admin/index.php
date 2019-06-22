<?php
// Iniciamos sesión.
session_start();

// Como estamos en la sección de admin, verificamos que
// solo usuarios autenticados puedan ingresar.
/*if(!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: ../index_santiago.php?s=login');
    exit;
}*/
require '../libraries/data-usuarios.php';
redirectIfNotLogged('../');

// Incluimos la conexión, para que ya quede creada en
// las secciones.
require '../acciones/conexion.php';

// Lista de secciones permitidas.
// Verificación por "Whitelist".
$sectionsAvailable = ['home', 'noticias', 'nueva-noticia', 'editar-noticia'];

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
    <title>Saraza Basket :: Panel de Administración</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header id="main-header">
        <h1>Saraza Basket :: Panel</h1>
        <p>Bienvenido/a al panel de administración de Saraza Basket!</p>
    </header>
    <nav id="main-nav">
        <ul>
            <li><a href="index.php?s=home">Home</a></li>
            <li><a href="index.php?s=noticias">Noticias</a></li>
        <?php
        if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])):
        ?>
            <li><a href="../index_santiago.php?s=perfil"><?= $_SESSION['email'];?> (Ir a mi perfil)</a></li>
        <?php
        else:
        ?>
            <li><a href="../index_santiago.php?s=login">Iniciar Sesión</a></li>
        <?php
        endif;
        ?>
        </ul>
    </nav>
    <?php
    if(in_array($section, $sectionsAvailable)) {
        require 'sections/' . $section . '.php';
    } else {
        header('Location: index_santiago.php?s=404');
    }
    ?>
    <footer id="main-footer">
        <p>&copy; Da Vinci - 2018</p>
    </footer>
</body>
</html>