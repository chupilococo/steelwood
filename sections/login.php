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
        <h2>Iniciar Sesión</h2>
        <p>Ingresá tus credenciales de acceso para iniciar sesión en el sitio y disfrutar de todos los beneficios que te ofrecemos.</p>
        
        <?php
        if(isset($errores['login'])):
        ?>
        <div class="alerta"><?= $errores['login'];?></div>
        <?php
        endif;
        ?>
        
        <form method="post" action="acciones/hacer-login.php" class="form">
            <div class="fila-form">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-field" value="<?= isset($oldData['email']) ? $oldData['email'] : '';?>">
            </div>
            <div class="fila-form">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-field">
                <button class="togglePassword" type="button" data-target="password">Mostrar/Ocultar Password</button>
            </div>
            
            <div class="fila-form">
                <a href="index.php?s=recuperar_clave">¿Olvidaste tu contraseña?</a>               
            </div>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        
<!--        <p>No tenés usuarios? <a href="index.php?s=registro">Registrate</a></p>-->
        <hr>
        
        <h2>Registrarse</h2>
        
        <form method="post" action="acciones/registrar.php" enctype="multipart/form-data">
            <div class="fila-form">
                <label for="email_r">Email</label>
                <input type="email" id="email_r" name="email" class="form-field" value="<?= $oldData['email_r'] ?? '';?>">
            <?php
            if(isset($errores['email'])):
            ?>
                <div class="alert"><?= $errores['email'];?></div>
            <?php
            endif;
            ?>
            </div>
            <div class="fila-form">
                <label for="password_r">Password</label>
                <input type="password" id="password_r" name="password" class="form-field"><button class="togglePassword" type="button" data-target="password_r">Mostrar/Ocultar Password</button>
            <?php
            if(isset($errores['password'])):
            ?>
                <div class="alert"><?= $errores['password'];?></div>
            <?php
            endif;
            ?>
            </div>
            <div class="fila-form">
                <label for="cpassword_r">Confirmar Password</label>
                <input type="password" id="cpassword_r" name="cpassword" class="form-field"><button class="togglePassword" type="button" data-target="cpassword_r">Mostrar/Ocultar Password</button>
            </div>
            <div class="fila-form">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-field" value="<?= $oldData['nombre'] ?? '';?>">
            </div>
            <div class="fila-form">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" class="form-field" value="<?= $oldData['apellido'] ?? '';?>">
            </div>
            <div class="fila-form">
                <label for="avatar">Avatar</label>
                <input type="file" id="avatar" name="avatar" class="form-field">
            </div>
            <button class="btn">Registrarse</button>

        </form>
    </div>
</main>

<script>
window.addEventListener('DOMContentLoaded', function() {
    var togglePwdBtn = document.querySelectorAll('.togglePassword');
    
    for(var i = 0; i < togglePwdBtn.length; i++) {
        togglePwdBtn[i].addEventListener('click', function() {
            // Capturamos el target del botón.
            var target = this.dataset.target;
            // Buscamos a ese elemento.
            var campoPassword = document.getElementById(target);
            
            // Preguntamos el tipo de campo, y lo 
            // cambiamos en consencuencia.
            /*if(campoPassword.type == 'password') {
                campoPassword.type = 'text';
            } else {
                campoPassword.type = 'password';
            }*/
            // Con un condicional ternario.
            campoPassword.type = campoPassword.type == 'password' ? 'text' : 'password';
        });
        
        /*togglePwdBtn[i].addEventListener('mousedown', function() {
            // Capturamos el target del botón.
            var target = this.dataset.target;
            // Buscamos a ese elemento.
            var campoPassword = document.getElementById(target);
            
            campoPassword.type = "text";
        });
        
        togglePwdBtn[i].addEventListener('mouseup', function() {
            // Capturamos el target del botón.
            var target = this.dataset.target;
            // Buscamos a ese elemento.
            var campoPassword = document.getElementById(target);
            
            campoPassword.type = "password";
        });*/
    }
});
</script>



