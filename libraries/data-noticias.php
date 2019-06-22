<?php
// Definimos las noticias disponibles.
// Definimos la cantidad de registros que queremos que
// se puedan traer.
// Al parámetro de $cantidad lo definimos como "opcional".
// Un parámetro opcional, como el nombre indica, puede
// no recibir un valor.
// Para crearlo como opcional, simplemente tenemos que
// asignarle un valor en la definición de la función.

/**
 * Retorna todas las noticias de la tabla "noticias", 
 * opcionalmente limitadas por $cantidad.
 *
 * @param mysqli $db La conexión a la base de datos de MySQL.
 * @param int|null $cantidad La cantidad a traer. Default: null.
 * @param int|null $inicio El valor desde el cuál traer los registros. Si es null, se trae del comienzo. Default: null.
 * @param string|null $busqueda El texto a buscar. Default: null.
 * @return array
 */
function traerNoticias($db, $cantidad = null, $inicio = null, $busqueda = null) {
    // Consulta.
    $consulta = "SELECT * FROM noticias";
    
    if($busqueda !== null) {
        $consulta .= " WHERE titulo LIKE '%" . $busqueda . "%'
                    OR sinopsis LIKE '%" . $busqueda . "%'
                    OR texto LIKE '%" . $busqueda . "%'";
    }
    
    $consulta .= " ORDER BY fecha_publicacion DESC";
    
    // Si cantidad es un número...
    if(is_numeric($cantidad)) {
        // Seteamos que si no indicaron un inicio,
        // empiece en 0.
        $inicio = $inicio ?? 0;
        // Agregamos el LIMIT.
        $consulta .= " LIMIT " . $inicio . ", " . $cantidad;
    }
    
    // Ejecutamos.
    $res = mysqli_query($db, $consulta);
    
    // Armamos una matriz con todos los resultados.
    $salidaResultados = [];
    
    // Recorremos todos los resultados.
    while($fila = mysqli_fetch_assoc($res)) {
        // Hacemos un push. Es equivalente a usar 
        // array_push.
        $salidaResultados[] = $fila;
    }
    
    /*echo "<pre>";
    print_r($salidaResultados);
    echo "</pre>";
    die;*/
    
    // Retornamos la matriz.
    return $salidaResultados;
    
    // Retorna los resultados.
//    return $res;
}

/**
 *
 */
function traerCantidadTotalDeNoticias($db, $busqueda = null) {
    // Armamos la consulta.
    $consulta = "SELECT count(*) AS cantidad FROM noticias";
    
    // Ejecutamos la consulta.
    $res = mysqli_query($db, $consulta);
    
    // Como buscamos por una columna de grupo y
    // no hay cláusula GROUP BY siempre vamos a 
    // tener un único resultado.
    $fila = mysqli_fetch_assoc($res);
    
    // Retornamos la cantidad total.
    return $fila['cantidad'];
}

/**
 * Retorna una noticia por su $id.
 *
 * @param mysqli $db
 * @param int $id   El id de la noticia.
 * @return array|null
 */
function traerNoticiaPorId($db, $id) {
    // Sanitizamos el $id.
    // IMPORTANTE: Protege contra SQL Injection.
    $id = mysqli_real_escape_string($db, $id);
    
    // Armamos la consulta.
    // Paso 2, agregamos comillas a los valores.
    $consulta = "SELECT 
                    titulo, 
                    sinopsis, 
                    texto, 
                    fecha_publicacion, 
                    imagen 
                FROM noticias
                WHERE id_noticia = '$id'";
    
    // Ejecutamos la consulta.
    $res = mysqli_query($db, $consulta);
    
    // Como buscamos por PK, solo puede haber un resultado.
//    $fila = mysqli_fetch_assoc($res);
//    return $fila;
    
    return mysqli_fetch_assoc($res);
}

/**
 * Graba una noticia en la base de datos.
 * Retorna true si tuvo éxito, false de lo contrario.
 *
 * @param mysqli $db
 * @param array $datos  Los datos a insertar.
 * @return bool|mysqli_result
 */
function grabarNoticia($db, $datos) {
    // Opción A:
    /*$id_usuario = mysqli_real_escape_string($db, $datos['id_usuario']);
    $titulo = mysqli_real_escape_string($db, $datos['titulo']);
    $sinopsis = mysqli_real_escape_string($db, $datos['sinopsis']);
    $texto = mysqli_real_escape_string($db, $datos['texto']);
    $imagen = mysqli_real_escape_string($db, $datos['imagen']);
    
    $consulta = "INSERT INTO noticias (id_usuario, titulo, sinopsis, texto, imagen)
    VALUES (
        '" . $id_usuario . "',
        '" . $titulo . "',
        '" . $sinopsis . "',
        '" . $texto . "',
        '" . $imagen . "'
    )";*/
    
    // Opción B:
    $consulta = "INSERT INTO noticias (id_usuario, titulo, sinopsis, texto, imagen, fecha_publicacion)
    VALUES (
        '" . mysqli_real_escape_string($db, $datos['id_usuario']) . "',
        '" . mysqli_real_escape_string($db, $datos['titulo']) . "',
        '" . mysqli_real_escape_string($db, $datos['sinopsis']) . "',
        '" . mysqli_real_escape_string($db, $datos['texto']) . "',
        '" . mysqli_real_escape_string($db, $datos['imagen']) . "',
        NOW()
    )";
    // NOW() en MySQL retorna la fecha actual.
    
    // Como estamos haciendo un INSERT, query va
    // true si se ejecuta con éxito, false de lo
    // contrario.
    return mysqli_query($db, $consulta);
}

/**
 * Elimina una noticia de la base de datos.
 * Retorna true en caso de éxito.
 * false de lo contrario.
 *
 * @param mysqli $db
 * @param int $db
 * @return bool
 */
function eliminarNoticia($db, $id) {
    // Sanitizamos el id que llega por parámetro.
    $id = mysqli_real_escape_string($db, $id);
    
    // Eliminamos la noticia.
    
    // Primero, eliminamos la noticia de la tabla
    // noticias_has_tags
    // Si seteamos el ON DELETE en CASCADE, podemos
    // omitir esta parte.
    /*$consulta = "DELETE FROM noticias_has_tags
                WHERE id_noticia = '$id'";
    
    mysqli_query($db, $consulta);*/
    
    // Armamos la consulta.
    $consulta = "DELETE FROM noticias
                WHERE id_noticia = '$id'";
    
    // Ejecutamos la consulta.
    return mysqli_query($db, $consulta);
}

/**
 * Actualiza la $data de la noticia $id en la base.
 *
 * @param mysqli $db
 * @param int $id
 * @param array $data
 * @return bool
 */
function editarNoticia($db, $id, $data) {
    // Sanitizamos los datos.
    $id = mysqli_real_escape_string($db, $id);
//    $data['titulo'] = mysqli_real_escape_string($db, $data['titulo']);
//    $data['sinopsis'] = mysqli_real_escape_string($db, $data['sinopsis']);
//    $data['texto'] = mysqli_real_escape_string($db, $data['texto']);
//    $data['imagen'] = mysqli_real_escape_string($db, $data['imagen']);
    
    // Manejo de la imagen, forma 1.
    /*$consulta = "UPDATE noticias
                SET titulo = '" . $data['titulo'] . "',
                    sinopsis = '" . $data['sinopsis'] . "',
                    texto = '" . $data['texto'] . "'";
    
    if(!empty($data['imagen'])) {
        $consulta .= ",
                    imagen = '" . $data['imagen'] . "'"
    }
    
    $consulta .= " WHERE id_noticia = '" . $id . "'";*/
    
    // Manejo de la imagen, forma 2.
    /*if(!empty($data['imagen'])) {
        $imageSQL = ", imagen = '" . $data['imagen'] . "'";
    } else {
        $imageSQL = "";
    }
    
    $consulta = "UPDATE noticias
                SET titulo = '" . $data['titulo'] . "',
                    sinopsis = '" . $data['sinopsis'] . "',
                    texto = '" . $data['texto'] . "'
                " . $imageSQL . "
                WHERE id_noticia = '" . $id . "'";*/
    
    // Forma 3: creando la consulta dinámicamente.
    // Esto lo podemos hacer siempre y cuando hayamos recibido
    // los datos como un array, cuyos índices se llamen igual
    // a las columnas que les corresponden.
    $camposSQL = [];
    
    foreach($data as $columna => $valor) {
        $camposSQL[] = $columna . " = '" . mysqli_real_escape_string($db, $valor) . "'";
    }
    
    $consulta = "UPDATE noticias
                SET " . implode(', ', $camposSQL) . "
                WHERE id_noticia = '" . $id . "'";
    
    // implode() permite unir todos los items de un array
    // en un string, unidos por un string de "pegamento".
    // Recibe 2 argumentos:
    // 1. "glue". String. El string con el que queremos pegar
    //      los valores del array.
    // 2. "array". Array. El array que contiene los valores a
    //      unir.
    /*echo implode(', ', $camposSQL);
    echo "<hr>";
    
    echo "<pre>";
    print_r($camposSQL);
    echo "</pre>";*/
    
    
    
//    echo $consulta;
    
    return mysqli_query($db, $consulta);
//    return $exito;
}

/**
 * Inserta los $tags en la tabla pivot para la noticia con el $id
 * provisto.
 *
 * @params mysqli $db
 * @params int $id
 * @params array $tags
 * @return bool
 */
function grabarTagsParaNoticia($db, $id, $tags) {
    $consulta = "INSERT INTO noticias_has_tags (id_noticia, id_tag)
                VALUES ";
    
    // Generamos usando la misma estrategia que hicimos en el update
    // todos los pares de valores para la consulta.
    $paresValores = [];
    
    foreach($tags as $tag) {
        $tagFiltrado = mysqli_real_escape_string($db, $tag);
        $paresValores[] = "('" . $id . "', '" . $tagFiltrado . "')";
    }
    
    // Agregamos todos los pares a la consulta.
    $consulta .= implode(', ', $paresValores);
    
    //$exito = mysqli_query($db, $consulta);
    //return $exito;
    return mysqli_query($db, $consulta);
}

/** 
 * Retorna todos los tags asociados a una noticia.
 *
 * @param mysqli $db
 * @param int $id
 * @return array
 */
function traerTagsDeNoticiaPorId($db, $id) {
    $id = mysqli_real_escape_string($db, $id);
    
    $consulta = "SELECT t.* FROM tags t
                INNER JOIN noticias_has_tags nht
                ON nht.id_tag = t.id_tag
                WHERE nht.id_noticia = '" . $id . "'";
    $res = mysqli_query($db, $consulta);
    
    $salida = [];
    while($fila = mysqli_fetch_assoc($res)) {
        $salida[] = $fila;
    }
    return $salida;
}



