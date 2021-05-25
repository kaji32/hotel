<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_code'])==false){
    print'ログインされていません';
    print'<p><a href="../user/login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}

try{
    $dbh = dbConnect();
    $sql = 'SELECT * FROM dat_reservation WHERE user_code=? ORDER BY arrival DESC';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $_SESSION['login_code'];
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    $count = count($res);
}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="../public/home.php">ホーム画面へ</a>';
    exit();
}

require_once('../config/config.php');
?>

<h2>アカウント情報</h2>
<p>お名前：<?php echo $_SESSION['login_name'];?></p>
<p>メールアドレス：<?php echo $_SESSION['login_email'];?></p>
<p>電話番号：<?php echo $_SESSION['login_tel'];?></p>

<h2>予約情報</h2>
<?php for($i=0;$i<$count;$i++): ?>
<p>到着日：<?=$res[$i]['arrival'];?></p>
<p>出発日：<?=$res[$i]['departure'];?></p>
<?php if($res[$i]['room1']!=null): ?>
    <p>部屋番号：<?=$res[$i]['room1'];?>,
        <?php if($res[$i]['room2']!=null): ?>
            <?=$res[$i]['room2'];?>
        <?php endif; ?>
    </p>
<?php endif; ?>
<p><a href="mypage_detail.php?code=<?=$res[$i]['code']?>">詳細</a></p>
<?php endfor; ?>


<a href="../user/logout.php">ログアウト</a>
</body>
</html>
