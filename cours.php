<!DOCTYPE html>
<!--
    dep.web 2.0 - page de cours
    par André-Luc Huneault
    14 décembre 2015
-->
<html>
    <head>
        <!-- cette fonction va afficher le nom du cours sélectionné dans la barre de titre -->
        <title>

            <?php
            // connexion à la base de données
            $odbc2 = odbc_connect("depweb", "user", "user");
            $result0 = odbc_exec($odbc2, "SELECT * FROM cours;");
            odbc_fetch_row($result0, 0);
            while (odbc_fetch_row($result0)) {
                $cn = utf8_encode(odbc_result($result0, "nom_cours"));
                $idc = utf8_encode(odbc_result($result0, "nid_cours"));
                // si l'id du cours est présent
                if (array_key_exists("c", $_GET)) {
                    // et si l'ID représente un nom de cours
                    if ($_GET["c"] == "$idc") {
                        // l'afficher
                        echo $cn . " - dep.web";
                    }
                }
            }
            ?>
        </title>
        <?php
        require("./include/styles.php");
        require("./include/cstyle.php");
        require("./include/scripts.php");
        ?>
        <link href="css/cours2.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        require("./include/fallback.php");
        ?>
        <div id="compatible">
            <?php
            require('./include/prerequisites.php');
            ?>
            <main id="main" class="">
                <div id="cname" class="ctitle fixed w3-container w3-theme-d3 course_name">
                    <h2>
                        <?php
                        // mettre fin à l'exécution si l'ID du cours est absent
                        if (!array_key_exists("c", $_GET)) {
                            die("<script>alert('Erreur lors du chargement du module com.si.cfnt.depweb.coursepage. Argument GET manquant.');</script>");
                        }
                        $odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
                        $result1 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY id_cours;");
                        odbc_fetch_row($result1, 0);
                        // haver2 est faux tant qu'il n'y a pas d'enregistrements
                        $haver2 = false;
                        while (odbc_fetch_row($result1)) {
                            $cid = utf8_encode(odbc_result($result1, "nid_cours"));
                            if ($_GET["c"] == $cid) {
                                // si l'ID du cours est trouvé l'afficher sur la page avec le numéro du module
                                $haver2 = true;
                                $nid = odbc_result($result1, "id_cours");
                                $cname = utf8_encode(odbc_result($result1, "nom_cours"));
                                $cdes = utf8_encode(odbc_result($result1, "des_cours"));
                                $objc = utf8_encode(odbc_result($result1, "obj_cours"));
                                $dureec = odbc_result($result1, "dur_cours");
                                $stage = odbc_result($result1, "stage");
                                $nb_hrs = odbc_result($result1, "stage_dur_semaine");
                                echo "$cname (M$nid)";
                                continue;
                            }
                        }
                        // si il n'y a pas de cours trouvé avec l'ID fin de l'exécution
                        if (!$haver2) {
                            die("<script>alert(\"Erreur lors du chargement du module com.si.cfnt.depweb.coursepage. Identifiant du cours introuvable dans la base de données: '" . $_GET["c"] . "'.\");</script>");
                        }
                        ?>
                    </h2>
                </div>
                <div id="cinfo" class="w3-container w3-margin w3-theme-dark w3-card-2 w3-padding">
                    <p title='Objectif du module' class="course_obj">
                        <?php
                        // objectif du cours
                        echo $cdes;
                        ?>
                    </p>
                    <p title='Compétences visées' class="course_comp">
                        <?php
                        echo $objc;
                        ?>
                    </p>
                    <h3 title='Durée du module' class="course_duration">
                        <?php
                        if ($stage) {
                            echo "" . $dureec . " jours (" . $nb_hrs . " heures par semaine)";
                        } else {
                            echo "" . $dureec . " heures";
                        }
                        ?>
                    </h3>
                    <h3>
                        Enseignants attitrés: 
                    </h3>
                    <ul>
                        <?php
                        $haver = false;
                        $result2 = odbc_exec($odbc, "SELECT * FROM enseignants INNER JOIN cours_enseignants ON enseignants.id_enseignant = cours_enseignants.enseignant WHERE cours_enseignants.cours = $nid");
                        odbc_fetch_row($result2, 0);
                        while (odbc_fetch_row($result2)) {
                            $haver = true;
                            $prenomt = utf8_encode(odbc_result($result2, "prenom_enseignant"));
                            $nomt = utf8_encode(odbc_result($result2, "nom_enseignant"));
                            $emailt = utf8_encode(odbc_result($result2, "email_enseignant"));
                            $pemail = odbc_result($result2, "perm_email");
                            if (!$pemail) {
                                echo "<li class='course_teacher'>$prenomt $nomt (contacter en personne)</li>";
                            } else {
                                echo "<li class='course_teacher'>$prenomt $nomt (<a href='mailto:$emailt'>$emailt</a>)</li>";
                            }
                        }
                        if (!$haver) {
                            echo "<p>Aucun enseignant attitré pour ce module.</p>";
                        }
                        ?>
                    </ul>
                </div>
                <div id="plan" class="w3-theme-d4 w3-container w3-margin w3-card-2">
                    <ul>
                        <li>
                            <?php
                            // affiche le plan de cours (lien)
                            odbc_fetch_row($result1, 0);
                            while (odbc_fetch_row($result1)) {
                                $cid = utf8_encode(odbc_result($result1, "nid_cours"));
                                if ($_GET["c"] == $cid) {
                                    echo "<a href='var/docs/plans_cours/$cid.pdf' title=\"Plan de cours de $cname\">Plan de cours</a>";
                                }
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <div id="docs" class="doclist w3-theme-d1 w3-container w3-margin w3-card-2">
                    <h3>
                        Documents et liens
                    </h3>
                    <ul>

                        <?php
                        // dresse une liste des documents du cours
                        // tant qu'il y a des documents haver est faux
                        $haver = true;
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {
                            $cid = odbc_result($result1, "nid_cours");
                            // si l'ID du cours est trouvé on continue
                            if ($_GET["c"] == $cid) {
                                $haver = false;
                                $cid2 = odbc_result($result1, "id_cours");
                                $result2 = odbc_exec($odbc, "SELECT * FROM documents WHERE documents.cours = $cid2 AND documents.type_doc <> 3 ORDER BY id_doc;");
                                odbc_fetch_row($result2, 0);
                                while (odbc_fetch_row($result2)) {
                                    $haver = true;
                                    $ndoc = odbc_result($result2, "nom_doc");
                                    $udoc = odbc_result($result2, "dir_doc");
                                    $tdoc = odbc_result($result2, "type_doc");
                                    // si le document est un lien l'afficher comme un lien internet
                                    if ($tdoc == 1) {
                                        echo "<li><a class='web' href=\"$udoc\" target='_blank'>$ndoc</a></li>";
                                    } else if ($tdoc == 2) {
                                        // sinon si le document est un document de cours l'afficher
                                        echo "<li><a class='document' href=\"var/docs/documents_notes/cours/$cid/$udoc\">$ndoc</a></li>";
                                    }
                                }
                                if (!$haver) {
                                    echo "<p>Aucun document disponible dans cette section.</p>";
                                }
                                continue;
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div id="exercices" class="doclist w3-theme-d2 w3-container w3-margin w3-card-2">
                    <h3>
                        Notes de cours et exercices
                    </h3>
                    <ul>

                        <?php
                        // idem que pour documents mais pour les notes de cours et exercices
                        $haver = true;
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {
                            $cid = odbc_result($result1, "nid_cours");
                            if ($_GET["c"] == $cid) {
                                $haver = false;
                                $cid2 = odbc_result($result1, "id_cours");
                                $result2 = odbc_exec($odbc, "SELECT * FROM documents WHERE documents.cours = $cid2 AND documents.type_doc = 3 ORDER BY id_doc;");
                                odbc_fetch_row($result2, 0);
                                while (odbc_fetch_row($result2)) {
                                    $haver = true;
                                    $ndoc = odbc_result($result2, "nom_doc");
                                    $udoc = odbc_result($result2, "dir_doc");
                                    $tdoc = odbc_result($result2, "type_doc");
                                    echo "<li><a class='document' href=\"var/docs/documents_notes/cours/$cid/$udoc\">$ndoc</a></li>";
                                }
                                if (!$haver) {
                                    echo "<p>Aucun document disponible dans cette section.</p>";
                                }
                                continue;
                            }
                        }
                        ?>
                    </ul>
                </div>
            </main>
        </div>
    </body>
</html>