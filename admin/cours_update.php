<?php
require("verify_login.php");
if ($IS_LOGGED_IN) {
    $odbc = odbc_connect("depweb", "user", "user");
    $id = $_POST["id"];
    if (!preg_match('/^[0-9]/', $_POST["durc"])) {
        header("Location: /panel_cours.php?error=1&cid=$id");
    } else {
        odbc_exec($odbc, "UPDATE cours SET durc='$durc_cleaned' WHERE id_cours=$id;");
        header("Location: /panel_cours.php?update=1");
    }
}
