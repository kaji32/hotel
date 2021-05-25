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

try{
    $dbh = dbConnect();
    $sql = 'SELECT * FROM dat_reservation ORDER BY arrival DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
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
    <th>到着日</th>
    <th>出発日</th>
    <th>部屋1</th>
    <th>部屋2</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
    <td><?=$res[$i]['name']; ?></td>
    <td><?=$res[$i]['arrival']; ?></td>
    <td><?=$res[$i]['departure']; ?></td>
    <td>
    <?php if($res[$i]['room1']==null){
        echo '未定';
    }else{
        echo $res[$i]['room1'];
    } ?></td>
    <td>
    <?php if($res[$i]['room2']==null){
        echo '未定';
    }else{
        echo $res[$i]['room2'];
    } ?></td>
    <td><a href="kanri_view_detail.php?code=<?=$res[$i]['code']; ?>">詳細</a></td>
    <td><a href="kanri_delete_conf.php?code=<?=$res[$i]['code']; ?>">削除</a></td>
</tr>
<?php endfor; ?>
</table>

<p><a href="kanri_home.php">管理ホーム画面へ</a></p>
