<?php
$u = $_POST["u"];
$p = $_POST["p"];
$odbc = odbc_connect("depweb", "user", "user");
$result1 = odbc_exec($odbc, "SELECT * FROM admin ORDER BY user;");
odbc_fetch_row($result1, 0);
$haver = false;
while(odbc_fetch_row($result1)){
    $user = utf8_encode(odbc_result($result1, "user"));
    $passwd = utf8_encode(odbc_result($result1, "password"));
    if($u == $user && $p == $passwd){
        $haver = true;
        continue;
    }
}
if ($haver) {
    session_start();
    $_SESSION["login"] = "yes";
    $_SESSION['start'] = time(); // Taking now logged in time.
    // Ending a session in 30 minutes from the starting time.
    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ../panel.php?first=1');
}else{
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: /admin.php?bad=1');
}

