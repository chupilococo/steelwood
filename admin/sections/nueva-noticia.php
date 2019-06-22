<?php
require '../libraries/data-tags.php';

// Preguntamos si hay errores.
if(isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    $oldData = $_SESSION['old_data'];
    // unset permite eliminar una variable.
    unset($_SESSION['errores'], $_SESSION['old_data']);
} else {
    $errores = [];
    $oldData = [];
}

// Obtenemos todos los tags.
$tags = obtenerTags($db);
//print_r($tags);
?>
<div id="main-panel">
    <h2>Crear nueva noticia</h2>
    <!-- Ponemos una URL que no pase por el index.
    Esto se debe a que esta URL no debe mostrar nada,
    sino que graba la info.
    Para poder enviar archivos en un form, necesitamos
    agregar el atributo "enctype", con el valor
    "multipart/form-data".
    -->
    <form action="acciones/grabar-noticia.php" method="post" enctype="multipart/form-data">
        <div class="fila-form">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" class="form-field" value="<?= isset($oldData['titulo']) ? $oldData['titulo'] : '';?>">
            <?php
            if(isset($errores['titulo'])):
            ?>
            <div class="form-error"><?= $errores['titulo'];?></div>
            <?php
            endif;
            ?>
        </div>
        <div class="fila-form">
            <label for="sinopsis">Sinopsis</label>
            <textarea id="sinopsis" name="sinopsis" class="form-field"><?= isset($oldData['sinopsis']) ? $oldData['sinopsis'] : '';?></textarea>
            <?php
            if(isset($errores['sinopsis'])):
            ?>
            <div class="form-error"><?= $errores['sinopsis'];?></div>
            <?php
            endif;
            ?>
        </div>
        <div class="fila-form">
            <label for="texto">Texto de la nota</label>
            <textarea id="texto" name="texto" class="form-field"><?= isset($oldData['texto']) ? $oldData['texto'] : '';?></textarea>
        </div>
        <div class="fila-form">
            <label for="imagen">Imagen</label>
            <input type="file" id="imagen" name="imagen" class="form-field">
            <?php
            if(isset($errores['imagen'])):
            ?>
            <div class="form-error"><?= $errores['imagen'];?></div>
            <?php
            endif;
            ?>
        </div>
        <fieldset>
            <legends>Tags</legends>
            <?php
            foreach($tags as $tag):
            ?>
                <div class="fila-form">
                    <label><input type="checkbox" name="tags[]" value="<?= $tag['id_tag'];?>"> <?= $tag['nombre'];?></label>
                </div>
            <?php
            endforeach;
            ?>
        </fieldset>
        <!--<div class="fila-form">
            <label for="alt">Descripción de la imagen</label>
            <input type="text" id="alt" name="alt" class="form-field" value="<?php //= isset($oldData['alt']) ? $oldData['alt'] : '';?>">
        </div>-->
        <button class="btn">Grabar</button>
    </form>
</div>