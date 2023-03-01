<?php 
    require '../config.inc.php';
    if(empty($_GET['key']) && !isset($_GET['key'])) header('Location:'.HOME_URL);
    if($web->isLoggedIn($db)) header('Location:'.HOME_URL);
    $key = $_GET['key'];
    $kverijs = $db->query('SELECT `id`, `hash`, `activated` FROM `users` WHERE `hash` = "'.$key.'" AND `activated` = 0;');
    if($kverijs->num_rows == 0) header('Location:'.HOME_URL);
    else {
        $kverijs = $kverijs->fetch_object();
        $db->query('UPDATE `users` SET `activated` = 1 WHERE `id` = '.$kverijs->id.';');
        header('Location:'.HOME_URL.'/login');
    }
?>