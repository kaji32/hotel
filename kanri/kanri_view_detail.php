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


$code = h($_GET['code']);
if(empty($code)){
    echo '正しい予約情報を選択してください';
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}

try{
    $dbh = dbConnect();
    $sql = 'SELECT 
    dat_reservation.code, 
    dat_reservation.name, 
    dat_reservation.user_code, 
 
    dat_reservation.room1, 
    dat_reservation.room2, 
    dat_reservation_detail.code AS detail_code, 
    dat_reservation_detail.code_reservation, 
    dat_reservation_detail.date, 
    dat_reservation_detail.breakfast, 
    dat_reservation_detail.lunch,
    dat_reservation_detail.dinner,
    dat_reservation_detail.stay
    FROM dat_reservation, dat_reservation_detail
    WHERE
    dat_reservation.code=dat_reservation_detail.code_reservation
    AND dat_reservation.code = ?';
    $stmt = $dbh->prepare($sql);
    $data = []; 
    $data[] = $code;
    
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    $count = count($res);
}catch(PDOExceptin $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    print '<form>';
    print '<input tyep="button" onclick="history.back()" value="戻る">';
    print '</form>';
    exit();
}
require_once('../config/config.php');
?>

<table border=1>
<tr>
<th>名前</th>

<th>日付</th>
<th>朝食</th>
<th>昼食</th>
<th>夕食</th>
<th>宿泊数</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?= $res[$i]['name']?></td>

<td><?= $res[$i]['date']?></td>
<td><?= $res[$i]['breakfast']?></td>
<td><?= $res[$i]['lunch']?></td>
<td><?= $res[$i]['dinner']?></td>
<td><?= $res[$i]['stay']?></td>
<td><a href="kanri_edit_form.php?code=<?= $res[$i]['detail_code']?>">編集</a></<td>
</tr>
<?php endfor; ?>
</table>
<p>部屋：
<?php if($res[0]['room1']==null){
        echo '<a href="kanri_room_edit.php?code='.$code.'">未定</a>';
    }else{
        echo $res[0]['room1'];
    } ?>
    <?php if($res[0]['room2']){
            echo $res[0]['room2'];
    } ?></p>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>


</body>
</html>
