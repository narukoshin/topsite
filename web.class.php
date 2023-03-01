<?php
    class Web {
        public function isLoggedIn($db) {
            if(isset($_COOKIE['t_id']) && isset($_COOKIE['t_hash'])) {
                $kverijs = $db->query('SELECT * FROM `users` WHERE `id` = "'.$_COOKIE['t_id'].'" AND `password` = "'.$_COOKIE['t_hash'].'";');
                $test = $kverijs->num_rows ? true : false;
            }
            else $test = false;
            return $test;
        }
        public function mail($to, $subject, $message, $headers) {
            return mail($to, $subject, $message, $headers);
        }
    }
    $web = new Web($db);
?>