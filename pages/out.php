<?php 
    require '../config.inc.php'; 
    if(empty($_GET['id']) || !isset($_GET['id'])) header('Location:'.HOME_URL);
    $id = $_GET['id'];
    $kverijs = $db->query('SELECT `ad_address` FROM `adverts` WHERE `ad_id` = '.$id.';');
    if($kverijs->num_rows == 0) header('Location:'.HOME_URL);
    $page = $kverijs->fetch_object();
    $kverijs2 = $db->query('SELECT * FROM `visits` WHERE `v_ip` = "'.$ip.'" AND `v_page` = '.$id.';');
    $visit = $kverijs2->fetch_object();
    if($kverijs2->num_rows == 0) {
        $kverijs3 = $db->query('INSERT INTO `visits` (`v_ip`, `v_time`, `v_page`) VALUES("'.$ip.'", '.$next_vote.', '.$id.');');
        $kverijs4 = $db->query('UPDATE `adverts` SET `ad_out` = `ad_out` + 1 WHERE `ad_id` = '.$id.';');
    } 
    else {
        if($time >= $visit->v_time) {
            $kverijs4 = $db->query('UPDATE `adverts` SET `ad_out` = `ad_out` + 1 WHERE `ad_id` = '.$id.';');
            $kverijs5 = $db->query('UPDATE `visits` SET `v_time` = '.$next_vote.' AND `v_page` = '.$id.' WHERE `v_ip` = "'.$ip.'";');
        }
    }
    header('Location:'.$page->ad_address);
?>