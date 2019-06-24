<?php
require 'libraries/data-noticias.php';
$productos = traerProducto($db, 10);
?>
   <main id="main-content">
    <section id="home-productos">
        <div class="productos-titulo">
            <h2>Lo nuestro</h2>
            <p class="lead">Esto es lo que hacemos.</p>
        </div>
        <div class="productos-wrapper">
            <?php
            foreach($productos as $producto):
            ?>
            <article class="producto">
                <a class="producto-item_link" href="index.php?s=ver-producto&id=<?= $producto['id_noticia'];?>">
                <div class="producto-item_content">
                    <div class="producto-item_texto">
                        <h3><?= $producto['titulo'];?></h3>
                        <p><?= $producto['sinopsis'];?></p>
                    </div>
                    <picture class="producto-item_imagen">
                        <source srcset="//unsplash.it/500/500" media="all and (min-width: 46.875em)">
                        <img src="//unsplash.it/100/100" alt="<?= $producto['titulo'];?>">
                    <!--
                        <source srcset="imgs/<?= str_replace('.jpg', '-big.jpg', $producto['imagen']);?>" media="all and (min-width: 46.875em)">
                        <img src="imgs/<?= $producto['imagen'];?>" alt="<?= $producto['titulo'];?>">
                    -->
                    </picture>
                </div>
                </a>
            </article>
            <?php
            endforeach;
            ?>
        </div>
    </section>
</main>