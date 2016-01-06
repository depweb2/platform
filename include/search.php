<?php
/*
 * algorithme de recherche pour la recherche instantanée de documents 
 * par andré-luc huneault
 * 14 décembre 2015
 */
// même algorithme que dans le fichier docsearch.php, la seule différence est que ce dernierr est chargé par XMLHTTP
if (array_key_exists("q", $_POST)) {
    if ($_POST["q"] != "") {
        $nb = 0;
        echo "<div class='w3-container-glass-green w3-padding-4 w3-card-2'>";
        $odbc = odbc_connect("depweb", "user", "user");
        $result1 = odbc_exec($odbc, "SELECT * FROM documents ORDER BY nom_doc;");
        odbc_fetch_row($result1, 0);
        while (odbc_fetch_row($result1)) {
            $dname = utf8_encode(odbc_result($result1, "nom_doc"));
            $dc = odbc_result($result1, "cours");
            $durl = utf8_encode(odbc_result($result1, "dir_doc"));
            $dtype = odbc_result($result1, "type_doc");
            $result2 = odbc_exec($odbc, "SELECT * FROM cours WHERE cours.id_cours = $dc;");
            while (odbc_fetch_row($result2)) {
                $cours = utf8_encode(odbc_result($result2, "nom_cours"));
                $nid_cours = utf8_encode(odbc_result($result2, "nid_cours"));
                $keys = ["é", "è", "ê", "à", "ù", "û", "â", "ç"];
                $keysr = ["e", "e", "e", "a", "u", "u", "a", "c"];
                $snr = "/" . mb_strtolower($_POST["q"]) . "/";
                $old_error = error_reporting(0);
                $values_to_replace = [$snr, $dname, $cours];
                for ($i = 0; $i < count($values_to_replace); $i++) {
                    for ($j = 0; $j < count($keys); $j++) {
                        $values_to_replace[$i] = mb_strtolower(str_ireplace($keys[$j], $keysr[$j], $values_to_replace[$i]));
                    }
                }
                if (preg_match($values_to_replace[0], $values_to_replace[1]) || preg_match($values_to_replace[0], $values_to_replace[2])) {
                    $haver = true;
                    $nb++;
                    if ($dtype != 1) {
                        echo "<div class='searchresult2 w3-container-glass-green w3-card-2 doc'><b><a href='var/docs/documents_notes/cours/$nid_cours/$durl'>$dname</a></b><i><a href='cours.php?c=$nid_cours'>$cours</a></i></div>";
                    } else {
                        echo "<div class='searchresult2 w3-container-glass-green w3-card-2 web'><b><a href='$durl'>$dname</a></b><i><a href='cours.php?c=$nid_cours'>$cours</a></i></div>";
                    }
                }
            }
        }
        error_reporting($old_error);
        switch ($nb) {
            case 0:
                echo "<h4 class'nbresults'>Aucun résultat</h4>";
                break;
            case 1:
                echo "<h4 class'nbresults'>$nb résultat</h4>";
                break;
            default:
                echo "<h4 class'nbresults'>$nb résultats</h4>";
                break;
        }
        echo "</div>";
    }
}

