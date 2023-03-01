<?php 
    require '../config.inc.php'; 
    include '../partials/top.php';
    if(empty($_GET['c_id']) || !isset($_GET['c_id']) || !isset($_GET['c_name']) || !isset($_GET['c_name'])) header('Location:'.HOME_URL);
    $cat_id = $_GET['c_id'];
    $cat_name = $_GET['c_name'];
    $kverijs = $db->query('SELECT * FROM `adverts` WHERE `ad_category` = '.$cat_id.';');
    $kverijs2 = $db->query('SELECT * FROM `category`;');
    $kverijs3 = $db->query('SELECT `cat_name` FROM `category` WHERE `cat_id` = '.$cat_id.';');
    $cat = $kverijs3->fetch_object();
    if($cat_id > $kverijs2->num_rows) header('Location:'.HOME_URL);
?>
<section id='center' class='left'>
    <h4 id='category_title'><?=$cat->cat_name?></h4>
    <?php 
        if($kverijs->num_rows == 0) echo '<label class="alert alert-danger">Šajā kategorijā nav nevienas lapas!</label>';
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
                <span id='green'><i class='glyphicon glyphicon-right glyphicon-chevron-up'></i><?=$row->ad_in?></span>
                <span id='red'><i class='glyphicon glyphicon-right glyphicon-chevron-down'></i><?=$row->ad_out?></span>
            </div>
        </div>
        <div id='content'>
            <a href='<?=HOME_URL?>/out/<?=$row->ad_id?>' target='_blank'><img src='<?=$banner?>' /></a>
        </div>
    </div>
    <?php } ?>
</section>
<?php include '../partials/bottom.php'; ?>