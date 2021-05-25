<?php 

session_start();
session_regenerate_id(true);
ini_set('display_errors', 'On');
require_once('../config/common_function.php');
if(isset($_SESSION['login_syunin'])==false){
    print'ログインされていません';
    print'<p><a href="../kanri/kanri_login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}

$code = h($_GET['code']);
if(empty($code)){
    echo '正しい予約情報を選択してください';
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}

try{
    $dbh = dbConnect();
    $sql = 'DELETE FROM dat_reservation WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data = []; 
    $data[] = $code;
    
    $stmt->execute($data);
    $sql = 'DELETE FROM dat_reservation_detail WHERE code_reservation=?';
    $stmt = $dbh->prepare($sql);
    $data = []; 
    $data[] = $code;
    
    $stmt->execute($data);
    
    $dbh = null;
    
}catch(PDOExceptin $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}
require_once('../config/config.php');

?>

<h1>削除完了しました。</h1>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>

</body>
</html>