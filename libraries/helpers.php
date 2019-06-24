<?php
/*
Colección de funciones útiles para manejo de datos
generales.
*/

function prevurl(){
    return (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] :str_replace($_SERVER['DOCUMENT_ROOT'],'',__DIR__.'/../index.php');
};








/**
 * Resalta el string de $textoAResaltar usando la
 * etiqueta <mark> dentro del $valor.
 *
 * @param string $valor
 * @param string $textoAResaltar
 * @return string
 */
function resaltar($valor, $textoAResaltar) {
    return $textoAResaltar !== null 
            ? str_ireplace($textoAResaltar, "<mark>" . $textoAResaltar . "</mark>", $valor) 
            : $valor;
}