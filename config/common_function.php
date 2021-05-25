<?php
function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function setToken(){
    $token = bin2hex(random_bytes(32));
    $_SESSION['token'] = $token;
    return $token;
}

function dbConnect(){
    $dsn = 'mysql:dbname=***;host=localhost;charset=utf8';
    $user = '***';
    $password = '***';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}


function pulldown_year(){
    print '<select name="year" id="">';
    print '<option value="2017">2017</option>';
    print '<option value="2018">2018</option>';
    print '<option value="2019">2019</option>';
    print '<option value="2020">2020</option>';
    print '<option value="2021">2021</option>';
    print '</select>';
}

function pulldown_month(){
    print '<select name="month" id="">';
    print '<option value="01">01</option>';
    print '<option value="02">02</option>';
    print '<option value="03">03</option>';
    print '<option value="04">04</option>';
    print '<option value="05">05</option>';
    print '<option value="06">06</option>';
    print '<option value="07">07</option>';
    print '<option value="08">08</option>';
    print '<option value="09">09</option>';
    print '<option value="10">10</option>';
    print '<option value="11">11</option>';
    print '<option value="12">12</option>';
    print '</select>';
}

function pulldown_day(){

print '<select name="day" id="">';
print '<option value="01">01</option>';
print '<option value="02">02</option>';
print '<option value="03">03</option>';
print '<option value="04">04</option>';
print '<option value="05">05</option>';
print '<option value="06">06</option>';
print '<option value="07">07</option>';
print '<option value="08">08</option>';
print '<option value="09">09</option>';
print '<option value="10">10</option>';
print '<option value="11">11</option>';
print '<option value="12">12</option>';
print '<option value="13">13</option>';
print '<option value="14">14</option>';
print '<option value="15">15</option>';
print '<option value="16">16</option>';
print '<option value="17">17</option>';
print '<option value="18">18</option>';
print '<option value="19">19</option>';
print '<option value="20">20</option>';
print '<option value="21">21</option>';
print '<option value="22">22</option>';
print '<option value="23">23</option>';
print '<option value="24">24</option>';
print '<option value="25">25</option>';
print '<option value="26">26</option>';
print '<option value="27">27</option>';
print '<option value="28">28</option>';
print '<option value="29">29</option>';
print '<option value="30">30</option>';
print '<option value="31">31</option>';
print '</select>';
}
?>
