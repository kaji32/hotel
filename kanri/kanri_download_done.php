<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_syunin'])==false){
    print'ログインされていません';
    print'<p><a href="../kanri/kanri_login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}

$year = $_POST['year'];
$month = $_POST['month'];


if(empty($year)||empty($month)){
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
    AND substr(date, 6, 2) = ?';

    $dbh = dbConnect();
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $year;
    $data[] = $month;
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;

    $count = count($res);

    $csv = '予約コード,名前,教会名,日付,朝食数,昼食数,夕食数,宿泊数,部屋1,部屋2';
    $csv .= "\n";
    
    for($i=0;$i<$count;$i++){
       $csv .= $res[$i]['code'];
       $csv .= ',';
       $csv .= $res[$i]['name'];
       $csv .= ',';
       $csv .= $res[$i]['date'];
       $csv .= ',';
       $csv .= $res[$i]['breakfast'];
       $csv .= ',';
       $csv .= $res[$i]['lunch'];
       $csv .= ',';
       $csv .= $res[$i]['dinner'];
       $csv .= ',';
       $csv .= $res[$i]['stay'];
       $csv .= "\n";
    }

    $file = fopen('./reservation.csv', 'w');
    $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
    fputs($file, $csv);
    fclose($file);

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}
require_once('../config/config.php');
?>

<a href="reservation.csv">予約情報をダウンロードする</a>
