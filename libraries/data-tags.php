<?php
/**
 * Retorna todos los tags de la base.
 *
 * @param mysqli $db
 * @return array
 */
function obtenerTags($db) {
    $consulta = "SELECT * FROM tags
                ORDER BY nombre";
    $res = mysqli_query($db, $consulta);
    
    $salida = [];
    while($fila = mysqli_fetch_assoc($res)) {
        $salida[] = $fila;
    }
    return $salida;
}