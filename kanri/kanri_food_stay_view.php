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

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];

if(empty($year)||empty($month)||empty($day)){
    echo '正しい日付を選択してください';
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}


try{
    $sql = 'SELECT 
    dat_reservation.code, 
    dat_reservation.name, 
    dat_reservation.user_code, 
    dat_reservation.kyokai, 
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
    AND substr(date, 1, 4) = ?
    AND substr(date, 6, 2) = ?
    AND substr(date, 9, 2) = ?';

    $dbh = dbConnect();
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $year;
    $data[] = $month;
    $data[] = $day;
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;

    $count = count($res);
    $total_breakfast = 0;
    $total_lunch = 0;
    $total_dinner = 0;
    $total_stay = 0;
    
    for($i=0;$i<$count;$i++){
        $total_breakfast += $res[$i]['breakfast'];
        $total_lunch += $res[$i]['lunch'];
        $total_dinner += $res[$i]['dinner'];
        $total_stay += $res[$i]['stay'];
    }

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
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
<th>宿泊</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
<td><?php echo $res[$i]['name']; ?></td>
<td><?php echo $res[$i]['date']; ?></td>
<td><?php echo $res[$i]['breakfast']; ?></td>
<td><?php echo $res[$i]['lunch']; ?></td>
<td><?php echo $res[$i]['dinner']; ?></td>
<td><?php echo $res[$i]['stay']; ?></td>
</tr>
<?php endfor; ?>

<tr>
<td>合計</td>
<td></td>
<td><?php echo $total_breakfast; ?></td>
<td><?php echo $total_lunch; ?></td>
<td><?php echo $total_dinner; ?></td>
<td><?php echo $total_stay; ?></td>

</tr>
</table>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>
</body>
</html>