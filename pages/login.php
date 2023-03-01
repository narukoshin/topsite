<?php 
    require '../config.inc.php';
    include '../partials/top.php';
    if($web->isLoggedIn($db)) header('Location:'.HOME_URL);
?>
<section id='login' class='left'>
    <label class='label label-info'><i class='glyphicon glyphicon-right glyphicon glyphicon-chevron-right'></i>Ienākt sistēmā<i class='glyphicon glyphicon-left glyphicon glyphicon-chevron-left'></i></label>
    <form method='post'>
        <?php 
            if(isset($_POST['login_submit'])) {
                $password = hash('sha256', $_POST['login_password']);
                $kverijs = $db->prepare('SELECT `id`, `password`, `activated` FROM `users` WHERE `username` = ? AND `password` = ?;');
                $kverijs->bind_param('ss', $_POST['login_user'], $password);
                $kverijs->bind_result($id, $password, $activated);
                $kverijs->execute();
                $kverijs->store_result();
                $kverijs->fetch();
                if($kverijs->num_rows == 0) echo '<label class="alert alert-danger">Lietotājvārds un/vai parole nav pareizi!</label>';
                elseif($activated == 0) echo '<label class="alert alert-danger">'.$activated.'Profils nav aktivizēts! Pārbaudiet epastu!</label>';
                else {
                    setcookie('t_id', $id, time()+86400*30);
                    setcookie('t_hash', $password, time()+86400*30);
                    $kverijs->close;
                    header('Location:'.HOME_URL);
                }
            }
        ?>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-user'></i>Lietotājvārds</label>
            <input class='form-control' type='text' name='login_user' required />
        </div>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-lock'></i>Parole</label>
            <input class='form-control' type='password' name='login_password' required />
        </div>
        <button class='btn btn-primary' name='login_submit'><i class='glyphicon glyphicon-right glyphicon-log-in'></i>Ienākt</button>
        <a href='<?=HOME_URL?>/register' class='left'>Reģistrēties</a>
        <a href='#' class='right'>Aizmirsi paroli?</a>
    </form>
</section>
<?php include '../partials/bottom.php'; ?>