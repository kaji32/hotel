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
    $sql = 'SELECT * FROM dat_reservation WHERE dat_reservation.code = ?';
    $stmt = $dbh->prepare($sql);
    $data = []; 
    $data[] = $code;
    
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    $count = count($res);
    var_dump($res);
}catch(PDOExceptin $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}
require_once('../config/config.php');
?>
<h1>こちらの予約情報を削除しますか？</h1>
予約者：<?= $res[0]['name']?><br>
到着日：<?= $res[0]['arrival']?><br>
出発日：<?= $res[0]['departure']?>




<form action="kanri_delete_done.php" method="get">
<input type="hidden" name="code" value="<?=$code;?>">
<input type="submit" value="削除する">
</form>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>

</body>
</html>