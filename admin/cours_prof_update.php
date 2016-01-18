<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {
    $odbc = odbc_connect("depweb", "user", "user");
    $id = $_POST["id"];
    $result = odbc_exec($odbc, "SELECT * FROM cours WHERE id_cours = $id");
    if (!odbc_fetch_row($result)) {
        access_denied();
    } else {
        $good = 0;
        $result2 = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant, prenom_enseignant;");
        odbc_fetch_row($result2, 0);
        while (odbc_fetch_row($result2)) {
            $ide = odbc_result($result2, "id_enseignant");
            if (!isset($_POST["teachers"])) {
                if (odbc_exec($odbc, "DELETE FROM cours_enseignants WHERE cours=$id;")) {
                    $good = 1;
                } else {
                    $good = 0;
                }
            } else {
                $checkes = $_POST["teachers"];
                $result3 = odbc_exec($odbc, "SELECT * FROM cours_enseignants WHERE cours=$id AND enseignant=$ide");
                foreach ($checkes as $check => $target_ide) {
                    if ($target_ide != $ide && odbc_fetch_row($result3)) {
                        if (odbc_exec($odbc, "DELETE FROM cours_enseignants WHERE enseignant=$ide AND cours=$id;")) {
                            $good = 1;
                        } else {
                            $good = 0;
                        }
                    } else if ($target_ide == $ide && !odbc_fetch_row($result3)) {
                        if (odbc_exec($odbc, "INSERT INTO cours_enseignants(cours, enseignant) values($id, $ide);")) {
                            $good = 1;
                        } else {
                            $good = 0;
                        }
                    }
                }
            }
        }
        if ($good === 1) {
            header("Location: /panel_cours.php?update=1");
            exit();
        } else {
            header("Location: /panel_cours.php?enserror=1&cid=$id");
            exit();
        }
    }
}
