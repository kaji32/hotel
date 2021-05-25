<?php
session_start();
session_regenerate_id(true);


require_once('../config/common_function.php');

$token = $_POST['token'];

if(empty($token)||empty($_SESSION['token'])||$token!=$_SESSION['token']){
    echo '不正なリクエストです';
    print '<form>';
    print '<input type="button" onclick=history.back() value="戻る">';
    print '</form>';
    print '<a href="../public/home.php">ホーム画面へ</a>';
    exit();
}
unset($_SESSION['token']);


// $tel = h($_POST['tel']);
$email = h($_POST['email']);
$password = h($_POST['password']);

if(empty($email)||empty($password)){
    echo 'メールアドレスとパスワードを入力してログインしてください。';
    print '<form>';
    print '<input type="button" onclick=history.back() value="戻る">';
    print '</form>';
    exit();
}
try{
    $dbh = dbConnect();
    $sql = 'SELECT code, name, password, email, tel FROM dat_users WHERE email=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $email;
    $stmt->execute($data);
    $dbh = null;
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$user){
    echo 'ユーザーが存在しません。';
    print '<form>';
    print '<input type="button" onclick=history.back() value="戻る">';
    print '</form>';
    exit();
}

if(password_verify($password, $user['password'])){
    session_regenerate_id(true);
    $_SESSION['login_code'] = $user['code'];
    $_SESSION['login_name'] = $user['name'];
    $_SESSION['login_email'] = $user['email'];
    $_SESSION['login_tel'] = $user['tel'];
}else{
    echo 'ログインに失敗しました<br>';
    print '<form>';
    print '<input tyep="button" onclick="history.back()" value="戻る">';
    print '</form>';
    exit();
}
}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    print '<form>';
    print '<input tyep="button" onclick="history.back()" value="戻る">';
    print '</form>';
    exit();
}



require_once('../config/config.php');
?>
<p>ログインに成功しました。</p>
<a href="../public/home.php">ホーム画面へ</a>
</form>
