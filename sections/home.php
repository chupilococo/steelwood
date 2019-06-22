<?php
require 'libraries/data-noticias.php';
$noticias = traerNoticias($db, 3);
?>
   <main id="main-content">
    <section id="home-noticias">
        <div>
            <h2>Lo nuestro</h2>
            <p class="lead">Esto es lo que hacemos.</p>
        </div>
        <?php
        foreach($noticias as $unaNoticia):
        ?>
            <article class="noticias-item">
                <a class="noticias-item_link" href="index.php?s=leer-noticia&id=<?= $unaNoticia['id_noticia'];?>">
                    <div class="noticias-item_content">
                        <h3><?= $unaNoticia['titulo'];?></h3>
                        <p><?= $unaNoticia['sinopsis'];?></p>
                    </div>
                    <picture class="noticias-item_imagen">
                        <source srcset="imgs/<?= str_replace('.jpg', '-big.jpg', $unaNoticia['imagen']);?>" media="all and (min-width: 46.875em)">
                        <img src="imgs/<?= $unaNoticia['imagen'];?>" alt="<?= $unaNoticia['titulo'];?>">
                    </picture>
                </a>
            </article>
        <?php
        endforeach;
        ?>
    </section>
</main>