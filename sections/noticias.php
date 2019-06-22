<?php
// Incluimos las noticias.
// Al incluir un archivo, si éste define variables o
// funciones, van a quedar definidos en el archivo en el
// que lo estoy incluyendo.
require 'libraries/data-noticias.php';
require 'libraries/helpers.php';

// Capturamos el parámetro de búsqueda, si es que lo
// hay.
$b = $_GET['b'] ?? null;

/**************************************
Paginador
**************************************/
// Tomamos la página que nos pide el usuario, y si
// no hay ninguna, asumimos que es la página 1.
$p = $_GET['p'] ?? 1;
// Definimos la cantidad de artículos que queremos
// mostrar por página.
$cantidad = 4;

// Calculamos el registo de inicio.
$inicio = ($cantidad * $p) - $cantidad;

// Leemos las noticias, pasando la conexión (traída del
// index.php).
$noticias = traerNoticias($db, $cantidad, $inicio, $b);
$cantidadTotalDeNoticias = traerCantidadTotalDeNoticias($db, $b);

// Calculamos la cantidad final de páginas.
$cantidadPaginas = $cantidadTotalDeNoticias / $cantidad;
?>
<main id="main-content">
    <section id="noticias" class="amplio">
        <section class="buscador">
            <!-- 
            A diferencia de los forms por POST, en
            los forms por GET no podemos dejar
            escrito un parámetro en el action.
            Si lo hacemos, el formulario lo va a
            eliminar al enviarse.
            -->
            <form method="get" action="index.php" class="form-inline">
                <!-- Para poder enviar la sección,
                la agregamos en un campo hidden. -->
                <input type="hidden" name="s" value="noticias">
                <div class="fila-form">
                    <label for="b">Buscar</label>
                    <input type="search" name="b" id="b" class="form-field" value="<?= $b;?>">
                </div>
                <button class="btn">Buscar</button>
            </form>
        </section>
       
        <div>
            <h2>Noticias</h2>
            <p class="lead">Qué está pasando.</p>
        </div>
        <?php
        foreach($noticias as $unaNoticia):
        ?>
        <article class="noticias-item">
            <a class="noticias-item_link" href="index.php?s=leer-noticia&id=<?= $unaNoticia['id_noticia'];?>">
                <div class="noticias-item_content">
                    <h3><?= resaltar($unaNoticia['titulo'], $b);?></h3>
                    <p><?= resaltar($unaNoticia['sinopsis'], $b);?></p>
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
        
        <!-- PAGINADOR -->
        <ul class="paginador">
        <!-- Links de primero y anterior -->
        <?php
        if($p > 1):
        ?>
            <li><a href="index.php?s=noticias&p=1">&lt;&lt;</a></li>
            <li><a href="index.php?s=noticias&p=<?= ($p - 1);?>">&lt;</a></li>
        <?php
        endif;
        ?>
        
        <!-- Lista de páginas -->
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
        
        <!-- Links de siguiente y última -->
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




