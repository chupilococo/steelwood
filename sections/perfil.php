<?php
// Como estamos en la sección del perfil, verificamos que
// solo usuarios autenticados puedan ingresar.
/*if(!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    header('Location: index_santiago.php?s=login');
    exit;
}*/
require 'libraries/data-usuarios.php';
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