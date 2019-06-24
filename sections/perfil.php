<?php
require_once 'libraries/helpers.php';
require 'libraries/data-usuarios.php';
$_SESSION['backUrl']=prevurl();

redirectIfNotLogged();
$user = traerUsuarioPorId($db, $_SESSION['id_usuario']);
?>

<main>
    <h1>Perfil de <?= $_SESSION['email'];?></h1>

    <a href="acciones/logout.php">Cerrar Sesión</a>
    
    <dl>
        <dt>Nombre</dt>
        <dd><?= $user['nombre'] . " " . $user['apellido'];?></dd>
        <dt>Avatar</dt>
        <dd></dd>
    </dl>

</main>