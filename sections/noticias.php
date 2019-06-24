<?php
require 'libraries/data-noticias.php';
//require 'libraries/helpers.php';
$b = $_GET['b'] ?? null;

/**************************************
Paginador
**************************************/
$p = $_GET['p'] ?? 1;
$cantidad = 4;
$inicio = ($cantidad * $p) - $cantidad;
$productos = traerProducto($db, $cantidad, $inicio, $b);
$cantidadTotalDeProductos = traerCantidadTotalDeProductos($db, $b);
$cantidadPaginas = $cantidadTotalDeProductos / $cantidad;
?>
<main id="main-content">
    <section id="noticias" class="amplio">
        <section class="buscador">
            <form method="get" action="index.php" class="form-inline">
                <input type="hidden" name="s" value="noticias">
                <div class="fila-form">
                    <label for="b">Buscar</label>
                    <input type="search" name="b" id="b" class="form-field" value="<?= $b;?>">
                </div>
                <button class="btn">Buscar</button>
            </form>
        </section>
       
        <div>
            <h2>Productos</h2>
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


        <ul class="paginador">
        <?php
        if($p > 1):
        ?>
            <li><a href="index.php?s=noticias&p=1">&lt;&lt;</a></li>
            <li><a href="index.php?s=noticias&p=<?= ($p - 1);?>">&lt;</a></li>
        <?php
        endif;
        ?>
        <?php
        for($i = 1; $i <= $cantidadPaginas; $i++): 
        ?>
            <?php
            if($i != $p):
            ?>
            <li><a href="index.php?s=noticias&p=<?= $i;?>"><?= $i;?></a></li>
            <?php
            else:
            ?>
            <li class="activa"><?= $i;?></li>
            <?php
            endif;
            ?>
            
        <?php
        endfor;
        ?>
        <?php
        if($p < $cantidadPaginas):
        ?>
            <li><a href="index.php?s=noticias&p=<?= ($p + 1);?>">&gt;</a></li>
            <li><a href="index.php?s=noticias&p=<?= $cantidadPaginas;?>">&gt;&gt;</a></li>
        <?php
        endif;
        ?>
        </ul>
    </section>
</main>




