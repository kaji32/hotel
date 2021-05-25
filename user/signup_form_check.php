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



$onamae = h($_POST['onamae']);
$email = h($_POST['email']);
$tel = h($_POST['tel']);

$password = h($_POST['password']);
$password2 = h($_POST['password2']);
require_once('../config/config.php');
?>

    <?php
    $flg = true;
    if(empty($onamae)){
        print '<p>お名前を入力してください。</p>';
        $flg = false;
    }
    if(empty($email)){
        print '<p>メールアドレスを入力してください。</p>';
        $flg = false;
    }

    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
        echo '正しいメールアドレスを入力してください。';
        $flg = false;
    }
    if(empty($tel)){
        print '<p>電話番号を入力してください。</p>';
        $flg = false;
    }

    // if(!preg_match("/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/", $tel)){
    //     echo '正しい電話番号を入力してください。';
    //     $flg = false;
    // }

    if(empty($password)){
        print '<p>パスワードを入力してください。</p>';
        $flg = false;
    }

    if(!preg_match("/\A[a-z\d]{8,30}+\z/i",$password)){
        $err[] = 'パスワードは英数字8文字以上30文字以下にしてください';
    }

    if($password!=$password2){
        print '<p>確認用パスワードが一致しません。</p>';
        $flg = false;
    }

    if($flg==false){
        print '<form>';
        print '<input type="button" onclick=history.back() value="戻る">';
        print '</form>';
        print '<a href="../public/home.php">ホーム画面へ</a>';
        exit();
    }

    ?>

    <h2>こちらの登録内容でお間違いありませんか？</h2>
    <p>お名前：<?php echo h($onamae); ?></p>
    <p>電話番号：<?php echo h($tel); ?></p>
    <p>メールアドレス：<?php echo h($email); ?></p>

    
    
    <form action="signup_form_done.php" method="post">
    <input type="hidden" name="onamae" value="<?=h($onamae);?>">
    <input type="hidden" name="email" value="<?=h($email);?>">
    <input type="hidden" name="tel" value="<?=h($tel);?>">
    <input type="hidden" name="password" value="<?=h($password);?>">
    <input type="hidden" name="token" value="<?php echo h(setToken())?>">
    <input type="button" onclick=history.back() value="戻る">    
    <input type="submit" value="登録">
    </form>
</body>
</html>
