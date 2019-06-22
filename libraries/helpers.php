<?php
/*
Colección de funciones útiles para manejo de datos
generales.
*/

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