<?php 
    require '../config.inc.php';
    include '../partials/top.php';
    if(empty($_GET['id']) || !isset($_GET['id'])) header('Location:'.HOME_URL);
    $id = $_GET['id'];
    $kverijs = $db->query('SELECT * FROM `adverts` WHERE `ad_id` = '.$id.';');
    if($kverijs->num_rows == 0) header('Location:'.HOME_URL);
    $vote = $kverijs->fetch_object();
    
    $kverijs2 = $db->query('SELECT * FROM `votes` WHERE `vote_ip` = "'.$ip.'" AND `vote_page` = '.$id.';');
    $votes = $kverijs2->fetch_object();
    if($kverijs2->num_rows == 0) {
        $voted = false;
    } else {
        if($time <= $votes->vote_time) {
            $voted = true;
        }
        else {
            $voted = false;
        }
    }
    
    if(isset($_POST['vote_submit'])) {
        if($kverijs2->num_rows == 0) {
            $kverijs3 = $db->prepare('INSERT INTO `votes` (`vote_ip`, `vote_time`, `vote_page`) VALUES(?, ?, ?);');
            $kverijs3->bind_param('sii', $ip, $next_vote, $id);
            $kverijs3->execute();

            $kverijs4 = $db->prepare('UPDATE `adverts` SET `ad_in` = `ad_in` + 1 WHERE `ad_id` = ?;');
            $kverijs4->bind_param('i', $id);
            $kverijs4->execute();
        }
        else {
            if($time >= $votes->vote_time) {
                $kverijs4 = $db->prepare('UPDATE `adverts` SET `ad_in` = `ad_in` + 1 WHERE `ad_id` = ?;');
                $kverijs4->bind_param('i', $id);
                $kverijs4->execute();

                $kverijs5 = $db->prepare('UPDATE `votes` SET `vote_time` = ? WHERE `vote_page` = ? AND `vote_ip` = ?;');
                $kverijs5->bind_param('iis', $next_vote, $id, $ip);
                $kverijs5->execute();
            }
        }
        header('Location:'.HOME_URL);
    }
?>
<section id='vote' class='left'>
    <h5 id='category_title'><i class='glyphicon glyphicon-right glyphicon-thumbs-up'></i>Spied uz pogas, lai balsotu par ( <?=$vote->ad_address?> )</h5>
    <form method='post' action='<?=HOME_URL?>/in/<?=$id?>/'>
        <?php if($voted === false) {?>
        <button class='btn btn-custom-vote' name='vote_submit'>+1 <?=strtoupper($vote->ad_title)?></button>
        <?php } else { ?> 
        <label class='alert alert-danger'>Jūs šodien jau balsojāt, lūdzu mēģiniet velreiz vēlāk!</label>
        <?php } ?>
        <span>Vēlies vairāk balsis (<?=strtoupper($vote->ad_title)?>) lapai? <a href='#'>Spied šeit!</a></span>
    </form>
</section>
<?php include '../partials/bottom.php'; ?>