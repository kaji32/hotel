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

$code = h($_POST['code']);
if(empty($code)){
    echo '正しい予約情報を選択してください';
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}

$breakfast = h($_POST['breakfast']);
$lunch = h($_POST['lunch']);
$dinner = h($_POST['dinner']);
$stay = h($_POST['stay']);

if($breakfast==null||$lunch==null||$dinner==null||$stay==null){
    echo '正しい数字を記入してください';
}

try{
    $dbh = dbConnect();
    $sql = 'UPDATE dat_reservation_detail SET breakfast=?, lunch=?, dinner=?, stay=? WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $breakfast;
    $data[] = $lunch;
    $data[] = $dinner;
    $data[] = $stay;
    $data[] = $code;
    $stmt->execute($data);
    
    $dbh = null;
    

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}
require_once('../config/config.php');


?>
<h3>変更完了しました。</h3>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>