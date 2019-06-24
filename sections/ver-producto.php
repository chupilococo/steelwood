<?php
require 'libraries/data-noticias.php';

$id = $_GET['id'];
$producto = traerProductoPorId($db, $id);
$tags    = traerTagsDeProductoPorId($db, $id);
?>
<main class="main" id="leer-noticia">
    <h2><?= $producto['titulo'];?></h2>
    <div class="leer-noticia_imagen">
        <img src="//unsplash.it/600/600">
        <!--img src="imgs/<?= str_replace('.jpg', '-big.jpg', $producto['imagen']);?>" alt="<?= $producto['titulo'];?>"-->
    </div>
    <div class="leer-noticia_tags">
    <?php
    foreach($tags as $tag):
    ?>
        <span class="leer-noticia_tags_item"><?= $tag['nombre'];?></span>
    <?php
    endforeach;
    ?>
    </div>
    <p class="lead"><?= $producto['sinopsis'];?></p>
    <p><?= $producto['texto'];?></p>



    <a href="index.php?s=agregar-carrito&id=<?= $id;?>">Agregar al Carrito</a>



</main>