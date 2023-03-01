<?php 
    require '../config.inc.php'; 
    include '../partials/top.php';
    if($web->isLoggedIn($db)) header('Location:'.HOME_URL);
?>
<section id='register' class='left'>
    <label class='label label-info'><i class='glyphicon glyphicon-right glyphicon glyphicon-chevron-right'></i>Reģistrēties<i class='glyphicon glyphicon-left glyphicon glyphicon-chevron-left'></i></label>
    <form method='post' action='<?=HOME_URL?>/register'>
        <?php 
            if(isset($_POST['register_submit'])) {
                $kverijs = $db->prepare('SELECT * FROM `users` WHERE `email` = ?;');
                $kverijs->bind_param('s', $_POST['register_email']);
                $kverijs->execute();
                $kverijs->store_result();
                $kverijs2 = $db->prepare('SELECT * FROM `users` WHERE `username` = ?;');
                $kverijs2->bind_param('s', $_POST['register_user']);
                $kverijs2->execute();
                $kverijs2->store_result();
                if($regblock == 1) echo '<label class="alert alert-danger">Atvainojiet, reģistrācija šobrīd ir atspējota!</label>';
                elseif($_POST['register_password'] != $_POST['register_password2']) echo '<label class="alert alert-danger"><i class="glyphicon glyphicon-right glyphicon-alert"></i>Paroles nesakrīt!</label>';
                elseif($kverijs2->num_rows == 1) {
                    echo '<label class="alert alert-danger"><i class="glyphicon glyphicon-right glyphicon-alert"></i>Šāds Lietotājvārds jau ir reģistrēts!</label>';
                    $kverijs2->close();
                }
                /*elseif($kverijs->num_rows == 1) {
                    echo '<label class="alert alert-danger"><i class="glyphicon glyphicon-right glyphicon-alert"></i>Šāds e-pasts jau ir reģistrēts!</label>';
                    $kverijs->close();
                }*/
                else {
                    $password = hash('sha256', $_POST['register_password']);
                    $email = base64_encode($_POST['register_email']);
                    $kverijs3 = $db->prepare('INSERT INTO `users` (`username`, `email`, `password`, `ip`, `joined`, `hash`) VALUES(?, ?, ?, ?, ?, ?);');
                    $kverijs3->bind_param('ssssis', $_POST['register_user'], $_POST['register_email'], $password, $ip, $time, $email);
                    $kverijs3->execute();
                    $kverijs3->close();
                    echo '<label class="alert alert-success"><i class="glyphicon glyphicon-right glyphicon-ok"></i>Jūs veiksmīgi reģistrējāties!</label>';
                    $message = '
                        Sveiks, '.$_POST['register_user'].'!<br /><br />

                        Lai aktivizētu profilu, lūdzu nospiediet uz → <a href="'.HOME_URL.'/activate?key='.$email.'">šo</a> ← adresi!<br /><br />

                        @WOLFTOP Administrācija.
                    ';
                    $headers  = 'MIME-Version: 1.0'."\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
                    $headers .= 'From: <WOLFTOP>'."\r\n";
                    $web->mail($_POST['register_email'], '<WOLFTOP> → E-Pasta apstiprināšana', $message, $headers);
                }
            }
        ?>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-user'></i>Lietotājvārds</label>
            <input class='form-control' type='text' name='register_user' required />
        </div>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-envelope'></i>E-Pasts</label>
            <input class='form-control' type='email' name='register_email' required />
        </div>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-lock'></i>Parole</label>
            <input class='form-control' type='password' name='register_password' required />
        </div>
        <div class='input-group'>
            <label><i class='glyphicon glyphicon-right glyphicon-lock'></i>Parole <small>(Atkārtoti)</small></label>
            <input class='form-control' type='password' name='register_password2' required />
        </div>
        <button class='btn btn-default' name='register_submit'>Reģistrēties</button>
        <a href='<?=HOME_URL?>/login' class='left'>Ienākt</a>
        <a href='#' class='right'>Aizmirsi paroli?</a>
    </form>
</section>
<?php include '../partials/bottom.php'; ?>