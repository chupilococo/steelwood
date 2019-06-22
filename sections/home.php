<?php
// Incluimos las noticias.
// Al incluir un archivo, si éste define variables o
// funciones, van a quedar definidos en el archivo en el
// que lo estoy incluyendo.
require 'libraries/data-noticias.php';

// Leemos las noticias, pasando la conexión (traida del
// index.php).
$noticias = traerNoticias($db, 3);
?>
   <main id="main-content">
    <section id="ranking" class="clearfix">
        <div>
            <h2>Ranking</h2>
            <p>La carrera por los playoffs.</p>
            <p>Este es la tabla de posiciones en la carrera hacia los playoffs.</p>
        </div>

        <section id="west-conference">
            <h3>Conferencia Oeste</h3>
            <ol class="positions">
                <li>Houston Rockets</li>
                <li>Golden State</li>
                <li>Portland Trailblazers</li>
                <li>Oklahoma City Thunder</li>
                <li>Utah Jazz</li>
                <li>New Orleans Pelicans</li>
                <li>San Antonio Spurs</li>
                <li>Minnesota Timberwolves</li>
                <li>Denver Nuggets</li>
                <li>Los Angeles Clippers</li>
                <li>Los Angeles Lakers</li>
                <li>Sacramento Kings</li>
                <li>Dallas Mavericks</li>
                <li>Memphis Grizzles</li>
                <li>Phoenix Suns</li>
            </ol>
        </section>

        <section id="east-conference">
            <h3>Conferencia Este</h3>
            <ol class="positions">
                <li>Toronto Raptors</li>
                <li>Boston Celtics</li>
                <li>Philadelphia 76ers</li>
                <li>Cleveland Cavaliers</li>
                <li>Indiana Pacers</li>
                <li>Miami Heat</li>
                <li>Milwaukee Bucks</li>
                <li>Washinton Wizards</li>
                <li>Detroit Pistons</li>
                <li>Charlotte Hornets</li>
                <li>New York Knicks</li>
                <li>Brooklyn Nets</li>
                <li>Chicago Bulls</li>
                <li>Orlando Magic</li>
                <li>Atlanta Hawks</li>
            </ol>
        </section>
    </section>

    <section id="home-noticias">
        <div>
            <h2>Noticias</h2>
            <p class="lead">Qué está pasando.</p>
        </div>
        <?php
//        while($unaNoticia = mysqli_fetch_assoc($noticias)):
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
//        endwhile;
        ?>
    </section>
</main>