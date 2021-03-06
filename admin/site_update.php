<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {

    function appostrophe($chaine) {
        //double les appostrophes pour les chaines de caractères   
        $chaine = str_replace("'", "''", $chaine);
        return $chaine;
    }

    $odbc = odbc_connect("depweb", "user", "user");
    $id = $_POST["id_site"];
    $nom_site = utf8_decode(appostrophe($_POST["nom_site"]));
    $prenom_eleve = utf8_decode(appostrophe($_POST["prenom_eleve"]));
    $nom_eleve = utf8_decode(appostrophe($_POST["nom_eleve"]));
    $url_site = utf8_decode(appostrophe($_POST["url_site"]));
    $groupe = $_POST["groupe"];
    if (isset($_POST["php"])) {
        $php = $_POST["php"];
        if ($php) {
            $php = 1;
        } else {
            $php = 0;
        }
    } else {
        $php = 0;
    }
    odbc_exec($odbc, "UPDATE sites_eleves SET nom_site='$nom_site', nom_eleve='$nom_eleve', prenom_eleve='$prenom_eleve', url_site='$url_site', groupe=$groupe, php=$php WHERE id_site=$id;");
    header("Location: /panel_sites.php?update=1");
}