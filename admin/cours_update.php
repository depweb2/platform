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
$odbc = odbc_connect("depweb", "user", "user");
$id = $_POST["id"];
if (!preg_match('/^[0-9]/', $_POST["durc"])) {
    header("Location: /panel_cours.php?error=1&cid=$id");
} else {
    odbc_exec($odbc, "UPDATE cours SET durc='$durc_cleaned' WHERE id_cours=$id;");
    header("Location: /panel_cours.php?update=1");
}
