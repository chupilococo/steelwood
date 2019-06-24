<?php
/**
 * Verifica si el usuario está autenticado. En caso de
 * no estarlo, lo redirecciona al login del $path 
 * indicado.
 *
 * @param string $path
 */
function redirectIfNotLogged($path = "../") {
    if(!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
        $_SESSION['mensaje'] = "Tenés que iniciar sesión para poder acceder a esta página.";
        header('Location: ' . $path . 'index.php?s=login');
        exit;
    }
}

/**
 * Verifica si el usuario está autenticado. En caso de
 * estarlo, lo redirecciona al login del $path
 * indicado.
 *
 * @param string $path
 */
function redirectIfLogged($path = "../") {
    if(isset($_SESSION['id_usuario'])) {
        $_SESSION['mensaje'] = "Ya estas logueado";
        header('Location: ' . $path);
        exit;
    }
}


/**
 * Verifica si existe un usuario con el $email y $password indicados.
 *
 * @param mysqli $db
 * @param string $email
 * @param string $password
 * @return bool
 */
function logUser($db, $email, $password) {
    $email    = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);
    $consulta = "SELECT id_usuario, email, password FROM usuarios
            WHERE email = '" . $email . "'";
    $res = mysqli_query($db, $consulta);
    if(mysqli_num_rows($res) === 1) {
        $fila = mysqli_fetch_assoc($res);
        if(password_verify($password, $fila['password'])) {
            return $fila['id_usuario'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/**
 * Crea un usuario en la base de datos.
 *
 * @param array $data
 * @return bool|int
 */
function registrarUsuario($db, $data) {
    $email = mysqli_real_escape_string($db, $data['email']);
    $nombre = mysqli_real_escape_string($db, $data['nombre']);
    $apellido = mysqli_real_escape_string($db, $data['apellido']);
    $avatar = mysqli_real_escape_string($db, $data['avatar']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $consulta = "INSERT INTO usuarios (email, password, nombre, apellido, avatar)
            VALUES (
                '" . $email . "',
                '" . $password . "',
                '" . $nombre . "',
                '" . $apellido . "',
                '" . $avatar . "'
            )";
    $exito = mysqli_query($db, $consulta);
    if($exito) {
        $id = mysqli_insert_id($db);
        return $id;
    } else {
        return false;
    }
}

/**
 * Retorna los datos de un usuario por su $id.
 *
 * @param int $id
 * @return array
 */
function traerUsuarioPorId($db, $id) {
    $consulta = "SELECT * FROM usuarios
                WHERE id_usuario = " . $id;
    $res = mysqli_query($db, $consulta);
    $fila = mysqli_fetch_assoc($res);
    return $fila;
}
