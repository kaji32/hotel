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

$arrival = $_POST['arrival'];
$departure = $_POST['departure'];
$today = date('Y-m-d');
$flg = true;
$breakfast =[];
$lunch =[];
$dinner =[];
$stay =[];
for($i=$arrival;$i<=$departure;$i++){
    $breakfast[$i] = h($_POST['breakfast'.$i]);
    $lunch[$i] = h($_POST['lunch'.$i]);
    $dinner[$i] = h($_POST['dinner'.$i]);
    $stay[$i] = h($_POST['stay'.$i]);   
    
    
    if(!preg_match('/^([0-9]{1,2})$/', $breakfast[$i])||!preg_match('/^([0-9]{1,2})$/', $lunch[$i])||!preg_match('/^([0-9]{1,2})$/', $dinner[$i])||!preg_match('/^([0-9]{1,2})$/', $stay[$i])){
        echo '正しい数字を入力してください。<br>';
        print'<a href="./reserve_form.php">戻る</a>';
        exit();
    }
    
  
}

require_once('../config/config.php');
?>

<h1><?=h($_SESSION['login_name']); ?>様</h1>
<h1>こちらの予約内容でお間違いありませんか？</h1>


<h2>到着日：<?=$arrival;?></h2>
<h2>出発日：<?=$departure;?></h2>

<?php for($i=$arrival;$i<$departure;$i++):?>
        <h3><?=$i;?></h3> 
        <p>朝食：<?=$breakfast[$i]; ?>食</p>
        <p>昼食：<?=$lunch[$i]; ?>食</p>
        <p>夕食：<?=$dinner[$i]; ?>食</p>
        <p>宿泊：<?=$stay[$i]; ?>人</p>
<?php endfor; ?>
        <h3><?=$departure;?></h3> 
        <p>朝食：<?=$breakfast[$departure]; ?>食</p>
        <p>昼食：<?=$lunch[$departure]; ?>食</p>
        <p>夕食：<?=$dinner[$departure]; ?>食</p>
        <p>メールアドレス:<?php echo h($_SESSION['login_email']);?></p>

<form action="reserve_form_done.php" method="post">
    <?php for($i=$arrival;$i<$departure;$i++):?>
    <input type="hidden" name="breakfast<?=$i;?>" value="<?=$breakfast[$i];?>">
    <input type="hidden" name="lunch<?=$i;?>" value="<?=$lunch[$i];?>">
    <input type="hidden" name="dinner<?=$i;?>" value="<?=$dinner[$i];?>">
    <input type="hidden" name="stay<?=$i;?>" value="<?=$stay[$i]; ?>"><br>
    <?php endfor; ?>
    <input type="hidden" name="breakfast<?=$departure; ?>" value="<?=$breakfast[$departure];?>">
    <input type="hidden" name="lunch<?=$departure; ?>" value="<?=$lunch[$departure]; ?>">
    <input type="hidden" name="dinner<?=$departure; ?>" value="<?=$dinner[$departure];?>">
    <input type="hidden" name="stay<?=$departure; ?>" value="0"><br>
    <input type="hidden" name="arrival" value="<?=$arrival; ?>"><br>
    <input type="hidden" name="departure" value="<?=$departure; ?>"><br>
    <input type="hidden" name="token" value="<?php echo h(setToken()); ?>">
    
    <input type="submit" value="予約する"><br>
    </form>
<a href="./reserve_form.php">戻る</a>
    
</body>
</html>