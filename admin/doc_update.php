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

$odbc = odbc_connect("depweb", "user", "user");
$id = $_POST["id"];
$nom_doc = utf8_decode(appostrophe($_POST["nom_doc"]));
$type_doc = $_POST["type"];
$cours = $_POST["cours"];
$dir_doc = utf8_decode(appostrophe($_POST["dir_doc"]));
odbc_exec($odbc, "UPDATE documents SET nom_doc='$nom_doc', type_doc=$type_doc, cours=$cours, dir_doc='$dir_doc' WHERE id_doc=$id;");
header("Location: /panel_documents.php?update=1");
