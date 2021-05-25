<?php
ini_set('display_errors', 'On');
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
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

$onamae = h($_POST['onamae']);
$email = h($_POST['email']);
$tel = h($_POST['tel']);

$password = h($_POST['password']);

try{
    $dbh = dbConnect();
    $sql = 'INSERT INTO dat_users(name, email, tel, password, ) VALUES(?, ?, ?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $onamae;
    $data[] = $email;
    $data[] = $tel;
    $data[] = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute($data);

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    exit();
}
require_once('../config/config.php');
?>

<p>登録完了しました。</p>
<a href="../public/home.php">ホーム画面へ</a>
