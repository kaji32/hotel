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




require_once('../config/config.php');

$flg = true;
if(empty($arrival)){
    echo '到着日を選択してください<br>';
    $flg = false;
}

if(empty($departure)){ 
    echo '出発日を選択してください<br>';  
    $flg = false;

}

if($today > $arrival || $today > $departure || $arrival > $departure){
    echo '正しい日付を選択してください<br>';
    $flg = false;
}


?>

<?php if($flg==false): ?>
    <a href="./reserve_form.php">戻る</a>


<?php else: ?>
    <form action="reserve_form_conf.php" method="post">
        <?php for($i=$arrival;$i<$departure;$i++):?>
        <?=$i;?> 朝食<input type="text" name="breakfast<?=$i; ?>">
        昼食<input type="text" name="lunch<?=$i; ?>">
        夕食<input type="text" name="dinner<?=$i; ?>">
        宿泊<input type="text" name="stay<?=$i; ?>"><br>
        <?php endfor; ?>
    <?=$departure; ?>
    朝食<input type="text" name="breakfast<?=$departure; ?>">
    昼食<input type="text" name="lunch<?=$departure; ?>">
    夕食<input type="text" name="dinner<?=$departure; ?>">
    <input type="hidden" name="stay<?=$departure; ?>" value="0"><br>
    <input type="hidden" name="arrival" value="<?=$arrival; ?>"><br>
    <input type="hidden" name="departure" value="<?=$departure; ?>"><br>
    <input type="submit" value="確認画面へ"><br>
    </form>
   
<?php endif; ?>
<a href="./reserve_form.php">戻る</a>
</body>
</html>