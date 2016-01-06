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
$idn = $_POST["idn"];
$odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
$titre = utf8_decode(appostrophe($_POST["titre"]));
$message = utf8_decode(appostrophe($_POST["message"]));
$date = utf8_decode(appostrophe($_POST["daten"]));

odbc_exec($odbc, "UPDATE nouvelles SET titre_nouv='$titre', message_nouv='$message', date_nouv='$date' WHERE id_nouv=$idn;");
header("Location: /panel_nouvelles.php?update=1");
