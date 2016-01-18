<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {

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
}