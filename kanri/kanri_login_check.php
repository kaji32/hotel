<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_syunin'])){
    header('Location:../kanri/kanri_home.php');
    exit();
}

$postId = h($_POST['id']);
$postPassword = h($_POST['pass']);


$token = h($_POST['token']);


if(empty($token)||empty($_SESSION['token'])||$token!=$_SESSION['token']){
    echo '不正なリクエストです';
    print '<form>';
    print '<input type="button" onclick=history.back() value="戻る">';
    print '</form>';
    print '<a href="../public/home.php">ホーム画面へ</a>';
    exit();
}
unset($_SESSION['token']);

$syuninId = '****';
$password = '****';

if(empty($postId)||empty($postPassword)||$postId!=$syuninId||$password!=$postPassword){
    print'ログインに失敗しました。';
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
    exit();

}else{
    $_SESSION['login_name'] = 'syunin';
    $_SESSION['login_code'] = 0;
    $_SESSION['login_syunin'] = true;
    $_SESSION['login_email'] = null;
    $_SESSION['login_tel'] = null;
    $_SESSION['login_kyokai'] = null;
    print '<p>ログインに成功しました。</p>';
    print '<p><a href="kanri_home.php">管理者画面へ</a></p>';
    exit();
}

require_once('../config/config.php');

?>


</body>
</html>
