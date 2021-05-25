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

<h3>日にちを選択してください</h3>
<form action="kanri_food_stay_view.php" method="post">
<?php pulldown_year();?>
<?php pulldown_month();?>
<?php pulldown_day(); ?>
<input type="submit" value="検索">
</form>
<p><a href="kanri_home.php">管理ホーム画面へ</a></p>
</body>
</html>