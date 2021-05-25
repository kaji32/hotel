<?php
session_start();
session_regenerate_id(true);
// ini_set('display_errors', 'On');
require_once('../config/common_function.php');

if(isset($_SESSION['login_code'])==false){
    print'ログインされていません';
    print'<p><a href="../user/login_form.php">ログイン画面へ</a></p>';
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


$arrival = h($_POST['arrival']);
$departure = h($_POST['departure']);
$breakfast =[];
$lunch =[];
$dinner =[];
$stay =[];

for($i=$arrival;$i<=$departure;$i++){
    $breakfast[$i] = h($_POST['breakfast'.$i]);
    $lunch[$i] = h($_POST['lunch'.$i]);
    $dinner[$i] = h($_POST['dinner'.$i]);
    $stay[$i] = h($_POST['stay'.$i]);   
}
try{
    $dbh = dbConnect(); 
    $sql = 'LOCK TABLES dat_reservation WRITE, dat_reservation_detail WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $sql = 'INSERT INTO dat_reservation(user_code, name, email, tel, kyokai, arrival, departure) VALUES(?,?, ?, ?, ?, ?,?)';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $_SESSION['login_code'];
    $data[] = $_SESSION['login_name'];
    $data[] = $_SESSION['login_email'];
    $data[] = $_SESSION['login_tel'];
    $data[] = $_SESSION['login_kyokai'];
    $data[] = $arrival;
    $data[] = $departure;
    $stmt->execute($data);

    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $lastcode = $res['LAST_INSERT_ID()'];


    for($i=$arrival;$i<=$departure;$i++){
        $sql = 'INSERT INTO dat_reservation_detail(code_reservation, date, breakfast, lunch, dinner, stay) VALUES(?, ?, ?, ?, ?,?)';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = $lastcode;
        $data[] = $i;
        $data[] = $breakfast[$i];
        $data[] = $lunch[$i];
        $data[] = $dinner[$i];
        $data[] = $stay[$i];
        $stmt->execute($data);   
    }
    
    $sql = 'UNLOCK TABLES';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    
    $dbh = null;
}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="../public/home.php">ホーム画面へ</a>';
    exit();
}
require_once('../config/config.php');
?>

<h1>予約完了しました。</h1>
<a href="../public/home.php">ホーム画面へ</a>
</body>
</html>
