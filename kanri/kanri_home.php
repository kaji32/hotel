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
?>



<h3><a href="kanri_view_all.php">予約一覧</a></h3>
<h3><a href="kanri_food_stay.php">食数・宿泊数確認</a></h3>
<h3><a href="kanri_download.php">予約情報ダウンロード</a></h3>
<h3><a href="kanri_user_view.php">ユーザー一覧</a></h3>
<h3><a href="kanri_blog_form.php">ブログ投稿</a></h3>

<p><a href="kanri_logout.php">ログアウト</a></p>
<p><a href="kanri_home.php">管理ホーム画面へ</a></p>
