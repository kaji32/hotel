<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIN HOTEL</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body>
<?php print '<p>ようこそ';
if(isset($_SESSION['login_name'])){
    print $_SESSION['login_name'];
}else{
    print 'ゲスト';
}
print '様</p>';
?>
<a href="../public/home.php"><h1>甲府詰所</h1></a>