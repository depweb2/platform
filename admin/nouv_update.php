<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {

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
}