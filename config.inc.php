<?php 
    error_reporting(-1);
    define('HOME_URL', 'http://localhost/tops2');
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/tops2/');
    define('title', 'WOLFTOP.EU');
    date_default_timezone_set('Europe/Riga');
    $db = new mysqli('localhost', 'root', '', 'topsite2');
    require 'web.class.php';
    $time = time();
    $ip = $_SERVER['REMOTE_ADDR'];
    $next_vote = $time + 86400;
    $regblock = 0;
    ob_start();
?>