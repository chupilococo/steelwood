<?php
// redireccionSiNoEstaLogueado
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
 * Verifica si existe un usuario con el $email y $password indicados.
 *
 * @param mysqli $db
 * @param string $email
 * @param string $password
 * @return bool
 */
function logUser($db, $email, $password) {
    // Sanitizamos los datos.
    $email    = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);
    
    // Armamos la consulta.
    // Con esta consulta, solo buscamos si existe un
    // usuario que tenga este email.
    $consulta = "SELECT id_usuario, email, password FROM usuarios
            WHERE email = '" . $email . "'";
    // Como el password ahora está hasheado, no podemos
    // verificarlo en la base de datos.
//            AND password = '" . $password . "'";
    
    // Ejecutamos la consulta :)
    // Como esta consulta es un SELECT, SIEMPRE (salvo que
    // haya un error) va a retornar un resultset. 
    // INDISTINTAMENTE de cuántos registros haya: 0, 1, 10, 1000
    $res = mysqli_query($db, $consulta);
    
    // Ya sea que el usuario coincida y exista en la base o no,
    // en $res tenemos un resultset.
    // Entonces, cómo identificamos si el usuario existía en la
    // base o no?
    // La diferencia va a estar en que si los datos son 
    // correctos, vamos a tener un registro. De lo contrario,
    // el resultset va a estar vacío.
    
    // Esto se puede chequear de 2 maneras distintas:
    // 1. Usando la función mysqli_num_rows($resultset).
    if(mysqli_num_rows($res) === 1) {
        // El usuario existe.
        $fila = mysqli_fetch_assoc($res);
        
        // Ahora comparamos los passwords.
        // Esto lo hacemos comparando el password que
        // escribió el usuario en el form, con el hash
        // que tenemos en la base, usando la función
        // password_verify.
        if(password_verify($password, $fila['password'])) {
            // El password coincide. El usuario es válido.
            // Retornamos el id del usuario.
            return $fila['id_usuario'];
        } else {
            return false;
        }
    } else {
        // El usuario NO existe.
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
    // Armamos la consulta.
    /*$consulta = "INSERT INTO usuarios (email, password, nombre, apellido, avatar)
            VALUES (
                '" . mysqli_real_escape_string($db, $data['email']) . "',
                '" . password_hash($data['password'], PASSWORD_DEFAULT) . "',
                '" . mysqli_real_escape_string($db, $data['nombre']) . "',
                '" . mysqli_real_escape_string($db, $data['apellido']) . "',
                '" . mysqli_real_escape_string($db, $data['avatar']) . "'
            )";*/
    
    // Sanitizamos los campos.
    $email = mysqli_real_escape_string($db, $data['email']);
    $nombre = mysqli_real_escape_string($db, $data['nombre']);
    $apellido = mysqli_real_escape_string($db, $data['apellido']);
    $avatar = mysqli_real_escape_string($db, $data['avatar']);
    // El password no hace falta sanitizarlo, porque
    // directamente lo hasheamos.
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    
    // Armamos la consulta.
    $consulta = "INSERT INTO usuarios (email, password, nombre, apellido, avatar)
            VALUES (
                '" . $email . "',
                '" . $password . "',
                '" . $nombre . "',
                '" . $apellido . "',
                '" . $avatar . "'
            )";
    
    // Ejecutamos la consulta.
    $exito = mysqli_query($db, $consulta);
    
//    return $exito;
    if($exito) {
        // Pedimos el último id autogenerado a la base.
        // mysqli_insert_id llama al last insert id
        // de MySQL, que retorna el último id que se
        // autogeneró con un insert.
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
    
    // Como es una búsqueda por PK, solo va a haber un
    // registro.
    $fila = mysqli_fetch_assoc($res);
    return $fila;
}





