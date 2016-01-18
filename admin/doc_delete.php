<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {
    if (array_key_exists("did", $_GET)) {
        if ($_GET["did"] != "") {
            $odbc = odbc_connect("depweb", "user", "user");
            $result1 = odbc_exec($odbc, "SELECT id_doc FROM documents ORDER BY id_doc");
            $haver = false;
            // ceci permet de vérifier si la requete passé par GET est bien un nombre, sinon retourne une chaîne vide
            $id_doc_delete = preg_replace("[^0-9]", "", $_GET["did"]);
            if ($id_doc_delete == "") {
                access_denied();
            }
            odbc_fetch_row($result1, 0);
            while (odbc_fetch_row($result1)) {
                $id_doc = odbc_result($result1, "id_doc");
                if ($id_doc == $id_doc_delete) {
                    $result_delete = odbc_exec($odbc, "DELETE FROM documents WHERE id_doc = $id_doc_delete;") || error("Erreur lors de l'exécution du module com.cfnt.si.depweb.admin_site_delete. \n Problème d'interaction avec la base de données.");
                    header('Status: 301 Moved Permanently', false, 301);
                    header('Location: /panel_documents.php?delete=1');
                }
            }
        } else {
            access_denied();
        }
    } else {
        access_denied();
    }
}
