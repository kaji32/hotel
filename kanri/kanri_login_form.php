<?php
session_start();
session_regenerate_id(true);
require_once('../config/common_function.php');
if(isset($_SESSION['login_syunin'])){
    header('Location:../kanri/kanri_home.php');
    exit();
}
require_once('../config/config.php');
?>

<form action="kanri_login_check.php" method="post">
<input type="text" name="syuninId"><br>
<input type="password" name="syuninPassword"><br>
<input type="hidden" name="token" value="<?php echo h(setToken()); ?>">
<input type="submit" value="ログイン">
</form>

</body>
</html>