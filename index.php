<?php
    session_start();
    require 'acciones/conexion.php';
    $sectionsAvailable = ['home','carrito', 'login', 'noticias', 'ver-producto', 'perfil', '404','recuperar_clave','cambiar_clave','agregar-carrito'];
    $section = $_GET['s'] ?? 'home';
?>
<!DOCTYPE html>
    <html lang="es">
<head>
    <meta charset="utf-8">
    <meta lang="es">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/productos.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>Carrito de Compras</title>
</head>
<body>
<header>
    <h1><a href="?s=home" >SteelWood <i class="far fa-calendar-alt"></i></a></h1>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <nav>
        <ul>
            <li><a href="?s=contacto">Contacto</a></li>
            <li><a href="?s=noticias">Productos</a></li>
            <?php
            if(isset($_SESSION['id_usuario']) && !empty($_SESSION['id_usuario'])):
                ?>
                <li><a href="index.php?s=perfil"><?= $_SESSION['email'];?> (Ir a mi perfil)</a></li>
            <?php
            else:
                ?>
                <li><a href="index.php?s=login">Iniciar Sesión</a></li>
            <?php
            endif;
            ?>
            <li>
                <a href="?s=carrito">
                <i class="fas fa-shopping-cart"></i>
                    Carrito
                    <span>
                        <?= (array_key_exists('carrito',$_SESSION))?count($_SESSION['carrito']):'';?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <label for="nav-toggle" class="nav-toggle-label">
        <span></span>
    </label>
</header>
<div class="content">

    <?php
        if (isset($_SESSION['mensaje'])):
    ?>
        <div class="mensaje">
            <?=$_SESSION['mensaje']?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
    endif;
    ?>


    <?php
    if(in_array($section, $sectionsAvailable)) {
        require 'sections/' . $section . '.php';
    } else {
        header('Location: index.php?s=404');
    }
    ?>
</div>
<footer>
    <p>&copy;</p>
</footer>
</body>
</html>