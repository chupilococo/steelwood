<?php

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
        <h2>Recuperá tu clave</h2>
        <p>Ingresá tu email para que podamos ayudarte a ingresar nuevamente a nuestro sitio.</p>
        
        <?php
        if(isset($errores['login'])):
        ?>
        <div class="alerta"><?= $errores['login'];?></div>
        <?php
        endif;
        ?>
        
        <form method="post" action="acciones/recuperar_clave.php" class="form">
            <div class="fila-form">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-field" value="<?= isset($oldData['email']) ? $oldData['email'] : '';?>">
            </div>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        
    </div>
</main>
