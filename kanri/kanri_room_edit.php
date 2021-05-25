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
    $sql = 'SELECT room1, room2 FROM dat_reservation WHERE code=?';
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

<form action="kanri_room_edit_done.php" method="post">
<p>部屋1：
<input type="text" name="room1" value="<?=$res['room1'];?>"></p>
<p>部屋2：
<input type="text" name="room2" value="<?=$res['room2'];?>"></p>
<input type="hidden" name="code" value="<?=$code;?>">
<input type="hidden" name="token" value="<?=h(setToken());?>">
<input type="submit" value="変更する">
</form>