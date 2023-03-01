<?php
    require '../config.inc.php';
    if(isset($_COOKIE['t_id']) && $_COOKIE['t_hash']) {
        setcookie('t_id', '', time()-3600);
        setcookie('t_hash', '', time()-3600);
        unset($_COOKIE['t_id']);
        unset($_COOKIE['t_hash']);
        header('Location: '.HOME_URL);
    }
    header('Location: '.HOME_URL);
?>