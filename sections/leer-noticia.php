<?php
require 'libraries/data-noticias.php';

// Capturamos el id.
$id = $_GET['id'];

// Buscamos la noticia por su id.
$noticia = traerNoticiaPorId($db, $id);
$tags    = traerTagsDeNoticiaPorId($db, $id);
?>
<main class="main" id="leer-noticia">
    <h2><?= $noticia['titulo'];?></h2>
    <div class="leer-noticia_imagen">
        <img src="imgs/<?= str_replace('.jpg', '-big.jpg', $noticia['imagen']);?>" alt="<?= $noticia['titulo'];?>">
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
    <p class="lead"><?= $noticia['sinopsis'];?></p>
    
    <p><?= $noticia['texto'];?></p>
</main>