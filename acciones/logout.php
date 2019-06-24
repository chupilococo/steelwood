<?php
session_start();
if(isset($_SESSION['backUrl'])){
    $back=$_SESSION['backUrl'];
    unset($_SESSION['backUrl']);
}else{
    $back='../index.php';
}
unset($_SESSION['id_usuario'], $_SESSION['email']);
header('Location: '.$back);