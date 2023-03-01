<?php 
    require 'config.inc.php'; 
    include 'partials/top.php';
?>
<section id='center' class='left'>
    <h4 id='category_title'>TOP 50 populārākas lapas</h4>
    <?php
        if(isset($_GET['page'])) $page = $_GET['page']; else $page = 1;
        $start = 50;
        $limit = ($page - 1) * $start;
        $kverijs = $db->query('SELECT * FROM `adverts` ORDER BY `ad_in` DESC LIMIT '.$limit.', '.$start.';');
        if($kverijs->num_rows == 0) echo '<label class="alert alert-danger">Nav pievienotas nevienas lapas! Spied <a href="'.HOME_URL.'/site/add">šeit</a>, lai pievienotu!</label>';
        while($row = $kverijs->fetch_object()) {
            switch($row->ad_banner) {
                case 'nobanner.gif': $banner = HOME_URL.'/assets/images/nobanner.gif'; break;
                default: $banner = HOME_URL.'/assets/images/uploads/'.$row->ad_banner; break;
            }
    ?>
    <div class='banner'>
        <div id='top'>
            <div class='left'>
                <a href='<?=HOME_URL?>/out/<?=$row->ad_id?>' target='_blank'><?=strtoupper($row->ad_title)?></a>
                <span id='desc'> - <?=$row->ad_desc?></span>
            </div>
            <div class='right'>
                <span id='green'><i class='glyphicon glyphicon-chevron-up'></i><?=$row->ad_in?></span>
                <span id='red'><i class='glyphicon glyphicon-chevron-down'></i><?=$row->ad_out?></span>
            </div>
        </div>
        <div id='content'>
            <a href='<?=HOME_URL?>/out/<?=$row->ad_id?>' target='_blank'><img src='<?=$banner?>' /></a>
        </div>
    </div>
    <?php } 
        $kverijs2 = $db->query('SELECT * FROM `adverts`;');
        $total = $kverijs2->num_rows;
        $pages = ceil($total / $start);
        echo '<div class="pagination">';
        for($i = 1; $i <= $pages; $i++) {
            if($i == $page) $active = 'class="active"'; else $active = '';
        ?>
            <li <?=$active?>><a href="<?=HOME_URL?>/page/<?=$i?>"><?=$i?></a></li>
        <?php
        }
        echo '</div>';
    ?>
</section>
<?php include 'partials/bottom.php'; ?>