<?php
require_once('libraries/helpers.php');
require_once ('acciones/conexion.php');
require_once ('libraries/data-noticias.php');

$_SESSION['backUrl']=prevurl();

//print_r(prevurl());

if (isset($_GET['id'])){
    $id = $_GET['id'];
    $producto = traerProductoPorId($db, $id);
    (empty($producto))?header('location:'.prevurl()):'';
}else{
    header('location:'.prevurl());
}



if(isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    $oldData = $_SESSION['old_data'];
    unset($_SESSION['errores'], $_SESSION['old_data']);
} else {
    $errores = [];
    $oldData = [];
}
?>
<main id="main-content">
    <div class="">
        <h2>Agregar al Carrito: <?= $producto['titulo'];?></h2>
        <p class="lead"><?= $producto['sinopsis'];?></p>
        
        <?php
        if(isset($errores['login'])):
        ?>
        <div class="alerta"><?= $errores['login'];?></div>
        <?php
        endif;
        ?>
        
        <form method="get" action="acciones/addToCart.php" class="form">
            <input type="hidden" name="id" value="<?=$_GET['id']?>">
            <div class="fila-form">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-field" value="<?= isset($oldData['cantidad']) ? $oldData['cantidad'] : '1';?>">
            </div>
            <button type="submit" class="btn">Agregar</button>
        </form>
        

</main>
