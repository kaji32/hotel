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
require_once('../config/config.php');


try{
    $sql = 'SELECT * FROM dat_users';

    $dbh = dbConnect();
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dbh = null;
    $count = count($res);

}catch(PDOException $e){
    echo 'ただいま障害により大変ご迷惑をおかけしております。'.$e->getMessage();
    echo '<a href="kanri_edit_form.php">戻る</a>';
    exit();
}

?>

<table border=1>
<tr>
    <th>コード</th>
    <th>名前</th>

    
    
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
    <td><?=$res[$i]['code']; ?></td>
    <td><?=$res[$i]['name']; ?></td>
 
   
</tr>
<?php endfor; ?>
</table>


<p><a href="kanri_home.php">管理ホーム画面へ</a></p>
