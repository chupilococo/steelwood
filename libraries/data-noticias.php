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
 * Retorna todas los productos de la tabla "productos",
 * opcionalmente limitadas por $cantidad.
 *
 * @param mysqli $db La conexión a la base de datos de MySQL.
 * @param int|null $cantidad La cantidad a traer. Default: null.
 * @param int|null $inicio El valor desde el cuál traer los registros. Si es null, se trae del comienzo. Default: null.
 * @param string|null $busqueda El texto a buscar. Default: null.
 * @return array
 */
function traerProducto($db, $cantidad = null, $inicio = null, $busqueda = null) {
    // Consulta.
    $consulta = "SELECT * FROM noticias";
    
    if($busqueda !== null) {
        $consulta .= " WHERE titulo LIKE '%" . $busqueda . "%'
                    OR sinopsis LIKE '%" . $busqueda . "%'
                    OR texto LIKE '%" . $busqueda . "%'";
    }
    
    $consulta .= " ORDER BY fecha_publicacion DESC";
    
    if(is_numeric($cantidad)) {
        $inicio = $inicio ?? 0;
        $consulta .= " LIMIT " . $inicio . ", " . $cantidad;
    }
    $res = mysqli_query($db, $consulta);
    $salidaResultados = [];
    
    while($fila = mysqli_fetch_assoc($res)) {
        $salidaResultados[] = $fila;
    }
    return $salidaResultados;
    
}

/**
 *
 */
function traerCantidadTotalDeProductos($db, $busqueda = null) {
    $consulta = "SELECT count(*) AS cantidad FROM noticias";
    
    $res = mysqli_query($db, $consulta);
    
    $fila = mysqli_fetch_assoc($res);
    
    return $fila['cantidad'];
}

/**
 * Retorna una noticia por su $id.
 *
 * @param mysqli $db
 * @param int $id   El id de la noticia.
 * @return array|null
 */
function traerProductoPorId($db, $id) {
    $id = mysqli_real_escape_string($db, $id);
    $consulta = "SELECT 
                    titulo, 
                    sinopsis, 
                    texto, 
                    fecha_publicacion, 
                    imagen 
                FROM noticias
                WHERE id_noticia = '$id'";
    $res = mysqli_query($db, $consulta);
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
    $consulta = "INSERT INTO noticias (id_usuario, titulo, sinopsis, texto, imagen, fecha_publicacion)
    VALUES (
        '" . mysqli_real_escape_string($db, $datos['id_usuario']) . "',
        '" . mysqli_real_escape_string($db, $datos['titulo']) . "',
        '" . mysqli_real_escape_string($db, $datos['sinopsis']) . "',
        '" . mysqli_real_escape_string($db, $datos['texto']) . "',
        '" . mysqli_real_escape_string($db, $datos['imagen']) . "',
        NOW()
    )";
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
    $id = mysqli_real_escape_string($db, $id);
    $consulta = "DELETE FROM noticias
                WHERE id_noticia = '$id'";
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
    $id = mysqli_real_escape_string($db, $id);
    $camposSQL = [];
    
    foreach($data as $columna => $valor) {
        $camposSQL[] = $columna . " = '" . mysqli_real_escape_string($db, $valor) . "'";
    }
    
    $consulta = "UPDATE noticias
                SET " . implode(', ', $camposSQL) . "
                WHERE id_noticia = '" . $id . "'";
       return mysqli_query($db, $consulta);
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
function grabarTagsParaProducto($db, $id, $tags) {
    $consulta = "INSERT INTO noticias_has_tags (id_noticia, id_tag)
                VALUES ";
    
    foreach($tags as $tag) {
        $tagFiltrado = mysqli_real_escape_string($db, $tag);
        $paresValores[] = "('" . $id . "', '" . $tagFiltrado . "')";
    }
    $consulta .= implode(', ', $paresValores);
    return mysqli_query($db, $consulta);
}

/** 
 * Retorna todos los tags asociados a una noticia.
 *
 * @param mysqli $db
 * @param int $id
 * @return array
 */
function traerTagsDeProductoPorId($db, $id) {
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
