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
    $sql = 'SELECT * FROM dat_reservation_detail WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $code;
    $stmt->execute($data);
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
    

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}
require_once('../config/config.php');

?>

<form action="kanri_edit_done.php" method="post">
<p>朝食：<input type="text" name="breakfast" value="<?=$res['breakfast'];?>">食</p>
<p>昼食：<input type="text" name="lunch" value="<?=$res['lunch'];?>">食</p>
<p>夕食：<input type="text" name="dinner" value="<?=$res['dinner'];?>">食</p>
<p>宿泊：<input type="text" name="stay" value="<?=$res['stay'];?>">人</p>
<input type="hidden" name="code" value="<?=$code;?>">
<input type="hidden" name="token" value="<?=h(setToken());?>">
<input type="submit"  value="変更する">
</form>