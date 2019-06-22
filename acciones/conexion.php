<?php
// Valores de conexión.
const DB_HOST = "127.0.0.1";
const DB_USER = "root";
const DB_PASS = "";
const DB_BASE = "steelwood";

// Conectamos con MySQL.
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE);

// Verificamos si la conexión falló...
if(!$db) {
    // Manejamos el escenario de fallo de la base.
    require 'mantenimiento.php';
    exit;
}

// Seteamos el charset.
mysqli_set_charset($db, 'utf8mb4');


/*
Los archivos de php, que SOLO contengan código php,
se recomienda NO cerrarlos.
Para php es lo mismo, y evita un potencial problema
que puede ocurrir bajo ciertas circunstancias.
*/