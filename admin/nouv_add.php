<?php

header('Cache-Control: no-cache, no-store, must-revalidate');

function access_denied() {
    header("Location: /admin/logout.php");
}

function erreur($msg) {
    echo "<script>alert(\"$msg\")</script>";
}

session_start();
$now = time(); // Checking the time now when home page starts.
if ($now > $_SESSION['expire']) {
    access_denied();
}
$login = $_SESSION["login"];
if (!$login == "yes") {
    access_denied();
}

function appostrophe($chaine) {
    //double les appostrophes pour les chaines de caractères   
    $chaine = str_replace("'", "''", $chaine);
    return $chaine;
}
function appostrophe2($chaine){
    $chaine = str_replace("'", "''", $chaine);
    $chaine = str_replace("\"", "", $chaine);
    return $chaine;
}

$odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
$titre = utf8_decode(appostrophe2($_POST["titre2"]));
$message = utf8_decode(appostrophe($_POST["message2"]));
$date = utf8_decode(appostrophe($_POST["daten2"]));
odbc_exec($odbc, "INSERT INTO nouvelles(titre_nouv, message_nouv, date_nouv) values('$titre', '$message','$date')");
header("Location: /panel_nouvelles.php?add=1");

