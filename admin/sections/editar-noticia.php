<?php
// Buscamos los datos de la noticia que quieren editar.
require '../libraries/data-noticias.php';

// Usamos la misma variable "$oldData" que usábamos para
// precargar los campos luego de un error. De esta forma,
// esa misma variable va a servir para precargar los datos
// actuales del registro, o los modificados por el usuario.
if(isset($_SESSION['old_data'])) {
    $oldData = $_SESSION['old_data'];
    $errores = $_SESSION['errores'];
    unset($_SESSION['old_data'], $_SESSION['errores']);
} else {
    $oldData = traerNoticiaPorId($db, $_GET['id']);
}


/*echo "<pre>";
print_r($noticia);
echo "</pre>";*/
?>
<div id="main-panel">
    <h2>Editar noticia</h2>
    <!--
    Envío del id de la noticia vía GET
    ==================================
    Si bien el form se envía por POST, se le pueden enviar
    sin problemas parámetros por GET también.
    -->
    <form action="acciones/grabar-editar-noticia.php?id=<?= $_GET['id'];?>" method="post" enctype="multipart/form-data">
        <!-- 
        Envío del id de la noticia vía POST 
        ===================================
        Una forma de enviar el id junto a los datos de POST,
        es agregando un campo en el form.
        -->
<!--        <input type="hidden" name="id_noticia" value="<?= $_GET['id'];?>">-->
        <input type="hidden" name="imagen_actual" value="<?= $oldData['imagen'];?>">
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
        <div>
            <p>Imagen actual</p>
            <img src="<?= '../imgs/' . $oldData['imagen'];?>" alt="Imagen acutal">
            <p>Si querés cambiar la imagen, seleccioná una nueva abajo. En cambio, si querés mantener la actual, dejá el campo vacío.</p>
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
        <!--<div class="fila-form">
            <label for="alt">Descripción de la imagen</label>
            <input type="text" id="alt" name="alt" class="form-field" value="<?php //= isset($oldData['alt']) ? $oldData['alt'] : '';?>">
        </div>-->
        <button class="btn">Grabar</button>
    </form>
</div>