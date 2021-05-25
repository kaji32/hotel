<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login_code'])==false){
    print'ログインされていません';
    print'<p><a href="../user/login_form.php">ログイン画面へ</a></p>';
    print'<p><a href="../public/home.php">ホーム画面へ</a></p>';
    exit();
}
$code = $_GET['code'];
if(empty($code)){
    print'予約情報がありません。';
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
    exit();
}
require_once('../config/common_function.php');


try{
    $dbh = dbConnect();
    $sql = 'SELECT * FROM dat_reservation_detail WHERE code_reservation=?';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $code;
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh=null;
    $count = count($res);
}catch(PDOException $e){

}


require_once('../config/config.php');
?>



<table border=1>
<tr>
<th>日付</th>
<th>朝食</th>
<th>昼食</th>
<th>夕食</th>
<th>宿泊</th>
</tr>

<?php for($i=0;$i<$count;$i++):?>
<tr>
<th><?=$res[$i]['date']?></th>
<th><?=$res[$i]['breakfast']?>食</th>
<th><?=$res[$i]['lunch']?>食</th>
<th><?=$res[$i]['dinner']?>食</th>
<th><?=$res[$i]['stay']?>人</th>
</tr>
<?php endfor;?>
</table>

<form>
<input type="button" onclick="history.back()" value="戻る">
</form>
</body>
</html>