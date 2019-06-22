<?php
const DB_HOST = "127.0.0.1";
const DB_USER = "wadmin";
const DB_PASS = "wadmin";
const DB_BASE = "steelwood";
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if(!$db) {
    require 'mantenimiento.php';
    exit;
}

mysqli_set_charset($db, 'utf8mb4');
