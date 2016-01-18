<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {

    function appostrophe($chaine) {
        //double les appostrophes pour les chaines de caractères   
        $chaine = str_replace("'", "''", $chaine);
        return $chaine;
    }

    function appostrophe2($chaine) {
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
}