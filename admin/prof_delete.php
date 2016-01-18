<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {
    if (array_key_exists("pid", $_GET)) {
        if ($_GET["pid"] != "") {
            $odbc = odbc_connect("depweb", "user", "user");
            $result1 = odbc_exec($odbc, "SELECT id_enseignant FROM enseignants ORDER BY id_enseignant");
            $haver = false;
            // ceci permet de vérifier si la requete passé par GET est bien un nombre, sinon retourne une chaîne vide
            $id_prof_delete = preg_replace("[^0-9]", "", $_GET["pid"]);
            if ($id_prof_delete == "") {
                access_denied();
            }
            odbc_fetch_row($result1, 0);
            while (odbc_fetch_row($result1)) {
                $id_prof = odbc_result($result1, "id_enseignant");
                if ($id_prof == $id_prof_delete) {
                    $result_delete = odbc_exec($odbc, "DELETE FROM enseignants WHERE id_enseignant = $id_prof_delete;") || error("Erreur lors de l'exécution du module com.cfnt.si.depweb.admin_site_delete. \n Problème d'interaction avec la base de données.");
                    header('Location: /panel_profs.php?delete=1');
                }
            }
        } else {
            access_denied();
        }
    } else {
        access_denied();
    }
}
