<?php
session_start();
$_SESSION=array();
if(isset($_COOCKIE[session_name()])==true){

    setcookie(session_name(), '', time()-42000,'/');

}

session_destroy();

require_once('../config/config.php');
?>


    ログアウトしました<br/>
    <br/>
    <a href="./kanri_login_form.php">ログイン画面へ</a>
    <a href="../public/home.php">ホーム画面へ</a>
</body>
</html>