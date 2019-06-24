<pre>

<?php
session_start();
require_once '../libraries/data-noticias.php';
require_once '../libraries/helpers.php';
require_once 'conexion.php';

var_dump($_GET);


if (!array_key_exists('carrito',$_SESSION)){
    $_SESSION['carrito']=[];
}



if (isset($_GET['id'])&&(isset($_GET['cantidad']))&&((int) $_GET['cantidad'])>0){
    $producto=traerProductoPorId($db,$_GET['id']);
    $id=$_GET['id'];
    $cantidad=$_GET['cantidad'];
}





if(empty($producto)){
    $_SESSION['mensaje']='el producto no existe';
    //header('location:'.prevurl());
}else{
    $_SESSION['mensaje']='Se agrego el producto al carrito';

    if(array_key_exists($id,$_SESSION['carrito'])){
        $_SESSION['carrito'][$id]+=$cantidad;
    }else{
        $_SESSION['carrito'][$id]=0+$cantidad;
    }
}

//var_dump($_SESSION['carrito']);


header('location:'.prevurl());


?>






</pre>


