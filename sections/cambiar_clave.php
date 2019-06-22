<?php

if(empty($_GET["email"]) || empty($_GET["token"])):
    header("Location: index_santiago.php");
    die();
endif;

$email = mysqli_real_scape_string($_GET["email"]);
$token = mysqli_real_scape_string($_GET["token"]);

|$query = "SELECT * FROM password_resets WHERE email = '$email' AND token = '$token';";

$rta = mysqli_query($db, $query);


if(mysqli_num_rows($rta) == 0):
    header("Location: index_santiago.php");
    die();
endif;

$_SESSION["email"] = $email;
$_SESSION["token"] = $token;

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
?>
<main id="main-content">
    <div class="login-section">
        <h2>Cambiá tu clave</h2>
        <p>Ingresá una nueva contraseña y tratá de no olvidartela 😁.</p>
        
        <?php
        if(isset($errores['login'])):
        ?>
        <div class="alerta"><?= $errores['login'];?></div>
        <?php
        endif;
        ?>
        
        <form method="post" action="acciones/cambiar_clave.php" class="form">
            <div class="fila-form">
                <label for="password">Nueva clave</label>
                <input type="password" name="password" id="password" class="form-field" value="<?= isset($oldData['password']) ? $oldData['password'] : '';?>">
            </div>
            <button type="submit" class="btn">Enviar</button>
        </form>
        
    </div>
</main>
