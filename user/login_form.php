<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login_code'])){
    header('Location:../public/home.php');
    exit();
}

require_once('../config/common_function.php');
require_once('../config/config.php');
?>

<form action="login_form_check.php" method="post">
<!-- <p>電話番号：<input type="text" name="tel"></p> -->
<p>メールアドレス：<input type="email" name="email"></p>
<p>パスワード：<input type="password" name="password"></p>
<input type="hidden" name="token" value="<?php echo h(setToken()); ?>">
<input type="submit" value="ログイン">
</form>