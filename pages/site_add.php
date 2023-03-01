<?php 
    require '../config.inc.php';
    include '../partials/top.php';
    if(!$web->isLoggedIn($db)) header('Location:'.HOME_URL.'/login');
    $kverijs = $db->query('SELECT `cat_id`, `cat_name` FROM `category`;');
    $kverijs2 = $db->query('SELECT `email` FROM `users` WHERE `id` = '.$_COOKIE['t_id'].';');
    $kverijs2 = $kverijs2->fetch_object();
    $kverijs4 = $db->query('SELECT * FROM `adverts` WHERE `ad_owner` = "'.$_COOKIE['t_id'].'";');
?>
<section id='site' class='left'>
    <label class='label label-info'><i class='glyphicon glyphicon-right glyphicon glyphicon-chevron-right'></i>Pievienot mājaslapu<i class='glyphicon glyphicon-left glyphicon glyphicon-chevron-left'></i></label>
    <form method='post' action='<?=HOME_URL?>/site/add' class='form' enctype='multipart/form-data'>
        <?php 
            if(isset($_POST['submit'])) {
                $upload = ROOT_PATH.'/assets/images/uploads/';
                $name = hash('sha1', $kverijs2->email);
                $banners = [
                    'image/gif',
                    'image/jpeg'
                ];
                if(empty($_FILES['ad_banner']['tmp_name'])) echo '<label class="alert alert-danger">Lūdzu pievienojiet banneri!</label>';
                elseif(!in_array($_FILES['ad_banner']['type'], $banners)) echo '<label class="alert alert-danger">Banneram jābut GIF vai JPG!</label>';
                elseif($kverijs4->num_rows > 0) echo '<label class="alert alert-danger">Jūs pārsniedzāt lapas limitu!</label>';
                else {
                    $kverijs3 = $db->prepare('INSERT INTO `adverts` (`ad_title`, `ad_category`, `ad_desc`, `ad_address`, `ad_banner`, `ad_create`, `ad_owner`) VALUES(?, ?, ?, ?, ?, ?, ?);');
                    $kverijs3->bind_param('sisssii', $_POST['ad_title'], $_POST['ad_category'], $_POST['ad_desc'], $_POST['ad_address'], $name, $time, $_COOKIE['t_id']);
                    $kverijs3->execute();
                    $kverijs3->close();
                    echo '<label class="alert alert-success">Lapa veiksmīgi pievienota!</label>';
                    move_uploaded_file($_FILES['ad_banner']['tmp_name'], $upload.'/'.$name);
                }
            }
        ?>
        <label>Nosaukums</label>
        <div class='input-group'><input type='text' class='form-control' name='ad_title' required /></div>
        <label>Adrese</label>
        <div class='input-group'><input type='text' class='form-control' name='ad_address' required /></div>
        <label>Apraksts</label>
        <div class='input-group'><input type='text' class='form-control' name='ad_desc' required /></div>
        <label>Kategorija</label>
        <div class='input-group'><select class='form-control' name='ad_category'>
            <?php while($row = $kverijs->fetch_object()) {
            ?>
                <option value='<?=$row->cat_id?>'><?=$row->cat_name?></option>
            <?php
            } ?>
        </select></div>
        <label>Banneris</label>
        <label for='banner' class='btn btn-custom-file' class='addBanner'>Pievienot banneri</label>
        <input type='file' name='ad_banner' id='banner' style='display:none;' />
        <div class='progress'>
            <div class='progress-bar progress-bar-striped progress-bar-success active'>0%</div>
        </div>
        <hr>
        <button name='submit' class='btn btn-danger'>Pievienot</buttom>
    </form>
</section>
<?php include '../partials/bottom.php'; ?>