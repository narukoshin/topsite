<!DOCTYPE html>
<html lang='lv'>
    <head>
        <meta charset='utf-8'>
        <title><?=title?></title>
        <link rel='stylesheet' type='text/css' href='<?=HOME_URL?>/assets/css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='<?=HOME_URL?>/assets/css/style.css' />
        <script type='text/javascript' src='<?=HOME_URL?>/assets/js/jquery.min.js'></script>
        <script type='text/javascript' src='<?=HOME_URL?>/assets/js/jquery.form.js'></script>
        <script type='text/javascript' src='<?=HOME_URL?>/assets/js/web.js'></script>
    </head>
<body>
    <nav>
        <ul>
            <li><a href='<?=HOME_URL?>'><?=strtoupper(title)?></a></li>
            <li><a href='<?=HOME_URL?>'><i class='glyphicon glyphicon-right glyphicon-home'></i>Galvenā</a></li>
            <li><a href='#'><i class='glyphicon glyphicon-right glyphicon-tasks'></i>Forums</a></li>
            <?php if(!$web->isLoggedIn($db)) { ?>
            <li class='right'><a href='<?=HOME_URL?>/register'>Reģistrēties</a></li>
            <li class='right'><a href='<?=HOME_URL?>/login'>Ienākt</a></li>
            <?php } else { ?>
            <li class='right'><a href='<?=HOME_URL?>/logout'>Iziet</a></li>
            <li class='right'><a href='<?=HOME_URL?>/profile'>Lietotāju panelis</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div class='container'>
        <section id='sidebar' class='left'>
            <ul class='nav nav-tabs nav-stacked side-menu'>
                <li><i class='glyphicon glyphicon-right glyphicon-folder-open'></i><b>CATEGORY</b> <?=strtoupper(title)?></li>
                <?php 
                    $kverijs = $db->query('SELECT `cat_id`, `cat_name` FROM `category`;');
                    if($kverijs->num_rows == 0) echo '<li style="margin-left:30px;"><i class="glyphicon glyphicon-right glyphicon-exclamation-sign"></i>Nav pievienotas nevienas kategorijas!</li>';
                    while($row = $kverijs->fetch_object()) {
                        $name = str_replace(' ', '-', strtolower($row->cat_name));
                ?>
                <li><a href='<?=HOME_URL?>/c/<?=$row->cat_id?>/<?=$name?>'><i class='glyphicon glyphicon-right glyphicon-chevron-right'></i><?=$row->cat_name?></a></li>
                <?php } ?>
        </section>