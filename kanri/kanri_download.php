<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_syunin'])==false){
    print'ログインされていません';
    print'<p><a href="../kanri/kanri_login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}


require_once('../config/config.php');
?>

<form action="kanri_download_done.php" method="post">
<?php pulldown_year();?>
<?php pulldown_month();?>
<input type="submit" value="検索する">
</form>

