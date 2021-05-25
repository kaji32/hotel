<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');

if(isset($_SESSION['login_code'])==false){
    print'ログインされていません';
    print'<p><a href="../user/login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}
require_once('../config/config.php');
?>
    <form action="reserve_form_check.php" method="post">
    <input type="date" name="arrival">
    <input type="date" name="departure">
    <input type="submit" value="次へ">
    </form>
</body>
</html>