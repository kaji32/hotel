<?php
ini_set('display_errors', 'On');
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_code'])){
    header('Location:../public/home.php');
    exit();
}
require_once('../config/config.php');
?>


    <form action="signup_form_check.php" method="post">
    <p>お名前</p>
    <input type="text" name="onamae">   

    <p>電話番号</p>
    <input type="text" name="tel">
    <p>メールアドレス</p>
    <input type="email" name="email">
 
    <p>パスワード</p>
    <input type="password" name="password">
    <p style="font-size:5px; color:red;">パスワードは8文字以上30文字以下の英数字にしてください</p>
    <p>確認用パスワード</p>
    <input type="password" name="password2">
    <input type="hidden" name="token" value="<?php echo h(setToken())?>">    
    <input type="submit" value="次へ">
    </form>
    
</body>
</html>
