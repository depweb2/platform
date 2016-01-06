<!DOCTYPE html>
<!--
    dep.web 2.0 - recherche de documents
    par André-Luc Huneault
    14 décembre 2015
-->
<html data-placeholder-focus='false'>
    <head>
        <title>
            <?php
            // affiche le titre ou les mots-clés de la recherche dans la barre de titre
            // permet de supporter les URL UTF-8
            mb_internal_encoding('UTF-8');
            // nodoc est faux si il n'y a pas de recherche active
            $nodoc = false;
            // si il y a des termes de recherche
            if (array_key_exists("q", $_GET)) {
                if ($_GET["q"] != "") {
                    echo "Résultats pour \"" . $_GET['q'] . "\" - dep.web";
                } else {
                    echo "Recherche de documents - dep.web";
                    $nodoc = true;
                }
            } else {
                echo "Recherche de documents - dep.web";
                $nodoc = true;
            }
            ?>
        </title>
        <?php
        require("./include/styles.php");
        require("./include/cstyle.php");
        require("./include/scripts.php");
        // si aucune recherche ajouter les composants pour la fonction d'autocomplétion
        if ($nodoc) {
            echo "<link href='css/docsearch.css' rel='stylesheet' type='text/css'/>";
            echo "<script src='lib/search.js' type='text/javascript'></script>";
        }
        ?>
        <!-- permet de rendre la recherche de documents fonctionne à même le navigateur sans accéder au site -->
        <link rel="search" type="application/opensearchdescription+xml" title="Recherche de documents sur dep.web" href="/opensearchdescription.xml">
    </head>
    <body>
        <?php
        require("./include/fallback.php");
        ?>
        <div id="compatible">
            <?php
            require('./include/prerequisites.php');
            ?>
            <main id="main">
                <!-- cette section n'est plus utilisée-->
                <!--<div id="cname" class="ctitle w3-container w3-theme-d3">
                    <h2>
                <?php
                if (array_key_exists("q", $_GET)) {
                    if ($_GET["q"] != "") {
                        echo "Résultats pour \"" . $_GET['q'] . "\"";
                    } else {
                        echo "Recherche de documents";
                    }
                } else {
                    echo "Recherche de documents";
                }
                ?>
                    </h2>
                </div>-->
                <div class="w3-container w3-theme-d3 searchbar w3-padding">
                    <!-- barre de recherche-->
                    <form name='doc_query' class="w3-form" method="get" action="docsearch.php?">
                        <a class='w3-left' title='Retour' href="#" onclick="history.back();">
                            <img src="images/ic_arrow_back_white_18dp.png" alt="Retour" title="Retour"/>
                        </a>
                        <?php
                        // si des termes de recherche sont sélectionnés les mettre comme placeholder
                        if (array_key_exists("q", $_GET)) {
                            if ($_GET["q"] != "") {
                                echo "<input autocomplete='off' title='Rechercher dans les documents, liens, notes de cours et exercices' id='q' placeholder=\"" . $_GET["q"] . "\" name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                            } else {
                                echo "<input autofocus autocomplete='off' title='Rechercher dans les documents, liens, notes de cours et exercices' id='q' placeholder='Rechercher dans les documents, liens, notes de cours et exercices' name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                            }
                        } else {
                            echo "<input autofocus autocomplete='off' title='Rechercher dans les documents, liens, notes de cours et exercices' id='q' placeholder='Rechercher dans les documents, liens, notes de cours et exercices' name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                        }
                        ?>
                        <a class="w3-left" href="javascript:doc_query.submit()" title="Lancer la recherche">
                            <img src="images/ic_search_white_18dp.png" alt=""/>
                        </a>
                        <!--<input title='Lancer la recherche' id="qs" class="w3-btn w3-left w3-theme-d1" type="submit" value="Lancer"/>-->
                    </form>
                </div>
                <?php
                $haver = false;
                // si il y a des termes de recherche imprimer les résltats de recherche
                if (array_key_exists("q", $_GET)) {
                    if ($_GET["q"] != "") {
                        $nb = 0;
                        echo "<div class='w3-container w3-margin w3-theme w3-padding w3-card-2'>";
                        $odbc = odbc_connect("depweb", "user", "user");
                        $result1 = odbc_exec($odbc, "SELECT * FROM documents ORDER BY nom_doc;");
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {
                            $dname = utf8_encode(odbc_result($result1, "nom_doc"));
                            $dc = odbc_result($result1, "cours");
                            $durl = utf8_encode(odbc_result($result1, "dir_doc"));
                            $dtype = odbc_result($result1, "type_doc");
                            // classe les documents par cours
                            $result2 = odbc_exec($odbc, "SELECT * FROM cours WHERE cours.id_cours = $dc;");
                            while (odbc_fetch_row($result2)) {
                                $cours = utf8_encode(odbc_result($result2, "nom_cours"));
                                $nid_cours = utf8_encode(odbc_result($result2, "nid_cours"));
                                // prepare l'expression régulière pour la comparaison
                                $snr = "/" . mb_strtolower($_GET["q"]) . "/";
                                $keys = ["é", "è", "ê", "à", "ù", "û", "â", "ç"];
                                $keysr = ["e", "e", "e", "a", "u", "u", "a", "c"];
                                $old_error = error_reporting(0);
                                // cette varieble contient les éléments à comparer
                                $values_to_replace = [$snr, $dname, $cours];
                                // effectue l'harmonisation des termes de recherche pour la comparaison
                                for ($i = 0; $i < count($values_to_replace); $i++) {
                                    // pour chaque caractère remplaçable
                                    for ($j = 0; $j < count($keys); $j++) {
                                        $values_to_replace[$i] = mb_strtolower(str_ireplace($keys[$j], $keysr[$j], $values_to_replace[$i]));
                                    }
                                }
                                // effectue la comparsiaon et retourne un résultat
                                if (preg_match($values_to_replace[0], $values_to_replace[1]) || preg_match($values_to_replace[0], $values_to_replace[2])) {
                                    // haver est vrai si la comparaison est bonne
                                    $haver = true;
                                    // compte le nombre de documents
                                    $nb++;
                                    // met l'icône en conséquence selon le type de document
                                    if ($dtype != 1) {
                                        echo "<div class='searchresult w3-theme-d3 w3-card-2 doc'><b><a href='var/docs/documents_notes/cours/$nid_cours/$durl'>$dname</a></b><i><a href='cours.php?c=$nid_cours'>$cours</a></i></div>";
                                    } else {
                                        echo "<div class='searchresult w3-theme-d3 w3-card-2 web'><b><a href='$durl'>$dname</a></b><i><a href='cours.php?c=$nid_cours'>$cours</a></i></div>";
                                    }
                                }
                            }
                        }
                        error_reporting($old_error);
                        // affiche le nombre de résultats
                        switch ($nb) {
                            case 0:
                                echo "<h3>Aucun résultat</h3>";
                                break;
                            case 1:
                                echo "<h3>$nb résultat</h3>";
                                break;
                            default:
                                echo "<h3>$nb résultats</h3>";
                                break;
                        }
                        echo "</div>";
                    } else {
                        // sinon préparer la page pour la recherche instantanée
                        echo "<div id='predict'></div>";
                    }
                } else {
                    echo "<div id='predict'></div>";
                }
                // lien de recherche Google pour les termes de recherche
                if (array_key_exists("q", $_GET)) {
                    if ($_GET["q"] != "") {
                        echo "<div class='google-search w3-container w3-margin w3-padding w3-theme-d2 w3-card-2'><a href=\"http://www.google.ca/search?q=" . $_GET["q"] . "\" title=\"Rechercher &laquo;&nbsp;" . $_GET["q"] . "&nbsp;&raquo; sur Google\">Rechercher &laquo;&nbsp;" . $_GET["q"] . "&nbsp;&raquo; sur Google</a></div>";
                    }
                }
                ?>
            </main>
        </div>
    </body>
</html>