<?php 
    require '../config.inc.php'; 
    include '../partials/top.php';
    if(!$web->isLoggedIn($db)) header('Location:'.HOME_URL);
    $kverijs = $db->query('SELECT * FROM `users` WHERE `id` = '.$_COOKIE['t_id'].';');
    $kverijs = $kverijs->fetch_object();
?>
<section id='center' class='left'>
    <label class='label label-info'><i class='glyphicon glyphicon-right glyphicon glyphicon-chevron-right'></i>Lietotāju panelis<i class='glyphicon glyphicon-left glyphicon glyphicon-chevron-left'></i></label>
    <div class='table-responsive'>
        <table class='table table-bordered'>
            <?php 
                if(isset($_POST['emailClick'])) {
                    $kverijs2 = $db->query('UPDATE `users` SET `email` = "'.$_POST['emailClick'].'" WHERE `id` = '.$_COOKIE['t_id'].';');
                    header('Location:'.HOME_URL.'/profile');
                }
            ?>
            <thead>
                <tr>
                    <th style='text-align:center;' colspan='2'>Profila informācija</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th width='50%'><i class='glyphicon glyphicon-user glyphicon-right'></i>Lietotājvārds:</th>
                    <td width='50%'><?=$kverijs->username?><span class='right'>ID: <?=$kverijs->id?></span></td>
                </tr>
                <tr>
                    <th><i class='glyphicon glyphicon-envelope glyphicon-right'></i>E-pasts:</th>
                    <td>
                        <form method='post' action='<?=HOME_URL?>/profile'>
                            <span id='emailInput'><?=$kverijs->email?></span>
                            <a href='javascript:' onclick='emailClick("<?=$kverijs->email?>");' id='emailClick' class='right'>Mainīt</a>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div class='panels'>
        <li><a href='<?=HOME_URL?>/site/add' class='btn btn-custom-profile'>Pievienot mājaslapu</a></li>
        <li><a href='<?=HOME_URL?>/site/add' class='btn btn-custom-profile'>Pievienot mājaslapu</a></li>
        <li><a href='<?=HOME_URL?>/site/add' class='btn btn-custom-profile'>Pievienot mājaslapu</a></li>
    </div>
</section>
<?php include '../partials/bottom.php'; ?>