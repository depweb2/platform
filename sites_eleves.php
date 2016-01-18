<?php
ob_start();
?>
<!DOCTYPE html>
<!--
    dep.web 2.0 - page de présentation des sites web des élèves
    par André-Luc Huneault
    14 décembre 2015
-->
<html data-placeholder-focus="false">
    <head>
        <title>Sites Web des élèves - dep.web</title>
        <?php
        // requiert des requêtes UTF-8
        mb_internal_encoding('UTF-8');
        require("./include/styles.php");
        require("./include/cstyle.php");
        require("./include/scripts.php");
        ?>
        <link href="css/siteseleves.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        require("./include/fallback.php");
        ?>
        <div id="compatible">
            <?php
            require('./include/prerequisites.php');
            ?>
            <div id="search_dialog" class="w3-modal">
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content w3-android-modal w3-padding-8">
                        <div class="w3-container">
                            <h2 class="">
                                Rechercher dans les sites
                            </h2>
                        </div>
                        <div class="w3-container w3-padding">
                            <!-- formulaire de recherche-->
                            <form method="get" action="sites_eleves.php" name="search2" id="search_window_field">
                                <input id='q2' required tabindex="0" placeholder="Tapez ce que vous cherchez.." name='q' class='full w3-input w3-light-grey' type='text'/>
                                <input id="s2" style="display: none;" type="submit" value="Envoyer"/>
                            </form>
                            <div class="w3-padding">
                                <u>Vous pouvez utiliser comme mots clés...</u>
                                <ul>
                                    <li>
                                        le nom d'un site
                                    </li>
                                    <li>
                                        le nom d'un élève
                                    </li>
                                    <li>
                                        un groupe
                                    </li>
                                </ul>
                                <small>
                                    Vous pouvez utiliser plusieurs critères de recherche en concaténant les expressions par une barre verticale. (« | »)
                                </small>
                            </div>
                        </div>
                        <footer class="w3-container w3-right-align w3-padding-8">
                            <a href="javascript:void(0);" onclick="document.getElementById('s2').click();" class="w3-modal-button">
                                Rechercher
                            </a>
                            <a href="#" class="w3-modal-button">
                                Annuler
                            </a>
                        </footer>
                    </div> 
                </div>
            </div>
            <?php
            if (isset($_GET["q"]) && $_GET["q"] != "") {
                ?>
                <script>
                    function load_site_sort(col) {
                        $("#col").attr("value", col);
                        document.getElementById("site_sort").submit();
                    }
                    function load_site_sort_desc(col) {
                        $("#col").attr("value", col);
                        $("#col_desc").removeAttr("disabled");
                        document.getElementById("site_sort").submit();
                    }
                </script>
                <form method="post" action="sites_eleves.php" id="site_sort">
                    <input type="hidden" name="col" id="col" value="">
                    <input type="hidden" name="col_desc" id="col_desc" value="" disabled/>
                </form>
                <script>
                    $("#site_sort").attr("action", location.href);
                </script>
                <a href="javascript:void(0)" onclick="open_context('.site_sort')" title="Trier les résultats de recherche..." class="w3-context-open w3-animate-bottom w3-card-2 short search_toggle w3-btn-floating-large w3-theme-dark">
                    <img src="images/ic_sort_white_18dp.png" alt="Trier..."/>
                </a>
                <div class="w3-context fixed site_sort right top-bottom">
                    <div class="w3-context-title w3-center w3-theme-d2">Trier par...</div>
                    <?php
                    $cols = [
                        "nom_site" => "nom du site Web",
                        "prenom_eleve" => "prénom de l'élève",
                        "nom_eleve" => "nom de l'élève",
                        "nom_complet" => "nom complet de l'élève",
                        "url_site" => "URL du site Web",
                        "groupe" => "groupe"
                    ];
                    foreach ($cols as $col => $title) {
                        echo "<a href='javascript:void(0)' onclick='load_site_sort(\"$col\")'>$title</a>";
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <a href="#search_dialog" onclick="search_focus()" title="Rechercher dans les sites Web" class="w3-animate-bottom w3-card-2 short top search_toggle w3-btn-floating-large w3-theme-dark">
                    <img src="images/ic_search_white_18dp.png" alt="Rechercher..."/>
                </a>
                <?php
            }
            ?>
            <main id="main">
                <div class="w3-container w3-theme-d3 searchbar w3-padding">
                    <form class="w3-form search_field" name="ss" method="get" action="sites_eleves.php">
                        <a class='w3-left' title='Retour' href="#" onclick="history.back();">
                            <img src="images/ic_arrow_back_white_18dp.png" alt="Retour"/>
                        </a>
                        <?php
                        // affiche le champ de recherche dépendemment du contexte
                        $title = "Rechercher parmi les sites Web des élèves (nom du site, de l'auteur ou du groupe)";
                        if (array_key_exists("q", $_GET)) {
                            if ($_GET["q"] != "") {
                                // si il y a une recherche active afficher les termes de recherche comme placeholder
                                echo "<input tabindex='0' title=\"$title\" id='q' placeholder=\"" . $_GET["q"] . "\" name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                            } else {
                                echo "<input tabindex='0' title=\"$title\" id='q' placeholder=\"$title\" name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                            }
                        } else {
                            echo "<input tabindex='0' title=\"$title\" id='q' placeholder=\"$title\" name='q' class='w3-input w3-left w3-theme-d1' type='text'/>";
                        }
                        ?>
                        <a class="w3-left" href="javascript:ss.submit()" title="Lancer la recherche">
                            <img src="images/ic_search_white_18dp.png" alt="Lancer la recherche"/>
                        </a>
                    </form>
                </div>
                <?php
                if (isset($_POST["col"]) && $_POST["col"] != "") {
                    ?>
                    <div class="site_order_bar w3-blue w3-center full cname w3-padding">
                        <b>
                            <?php
                            $cols = [
                                "nom_site" => "nom du site Web",
                                "prenom_eleve" => "prénom de l'élève",
                                "nom_eleve" => "nom de l'élève",
                                "nom_complet" => "nom complet de l'élève",
                                "url_site" => "URL du site Web",
                                "groupe" => "groupe"
                            ];
                            foreach ($cols as $col => $title) {
                                if ($col == $_POST["col"]) {
                                    echo "Tri des sites selon $title en ordre ";
                                    if (!isset($_POST["col_desc"])) {
                                        echo "croissant. <a class='' href='javascript:void(0)' onclick='load_site_sort_desc(\"$col\")'>Tri décroissant</a> ";
                                    } else {
                                        echo "décroissant. <a class='' href='javascript:void(0)' onclick='load_site_sort(\"$col\")'>Tri croissant</a> ";
                                    }
                                    echo " <a class='' href='javascript:void(0)' onclick='location = location.href;'>Réinitialiser</a>";
                                }
                            }
                            ?>
                        </b>
                    </div>
                    <?php
                }
                // si il y a une recherche masquer l'entête
                if (array_key_exists("q", $_GET)) {
                    if ($_GET["q"] != "") {
                        echo "<!--";
                    }
                }
                ?>
                <div class="sites_title w3-margin w3-card-4 w3-container w3-container-glass">
                    <img src="images/sites.png" alt="Sites des élèves"/>
                </div>
                <div class="w3-margin w3-card-4 w3-container w3-container-glass w3-padding">
                    <p>Voici les sites Web faits par les élèves du département de Soutien informatique
                        au fil des années. Ces sites Web ont été créés dans le cadre des cours Moyens de
                        télécommunications et Programmation d'un utilitaire en tant que projets finaux.</p>
                    <p>
                        Note: oui on le sait que League of Legends revient souvent, on est au courant. ;)
                    </p>
                </div>
                <?php

                function list_sites() {
                    $haver = true;
                    // préparation au cas où il y aurait eu un appel au script de vérification
                    $s4 = "Sites introuvables: ";
                    // connexion à la base de données
                    $odbc = odbc_connect("depweb", "user", "user");
                    $result1 = odbc_exec($odbc, "SELECT * FROM periodes ORDER BY annee DESC, periode;");
                    odbc_fetch_row($result1, 0);
                    while (odbc_fetch_row($result1)) {
                        // il y a des résultats donc haver est vrai
                        $haver = true;
                        $pid = odbc_result($result1, "id_periode");
                        $periode = utf8_encode(odbc_result($result1, "periode"));
                        $annee = odbc_result($result1, "annee");
                        echo "<div class='w3-container w3-margin w3-container-glass w3-padding w3-card-4'><div class='sites_contaisner'><div class='annee'><h3>$periode $annee</h3>";
                        // sélectionne les groupes de chaque site
                        $result2 = odbc_exec($odbc, "SELECT * FROM groupes WHERE groupes.periode = $pid ORDER BY nom_groupe DESC, periode;");
                        odbc_fetch_row($result2, 0);
                        while (odbc_fetch_row($result2)) {
                            $idgr = odbc_result($result2, "id_groupe");
                            $ngr = utf8_encode(odbc_result($result2, "nom_groupe"));
                            echo "<div class='w3-container-glass-2 w3-margin-top w3-margin-bottom w3-padding w3-card-4 groupe'><h4 class='bold'>Groupe $ngr</h4>";
                            // liste les sites pour le groupe et la période
                            $result3 = odbc_exec($odbc, "SELECT * FROM sites_eleves WHERE sites_eleves.groupe = $idgr ORDER BY nom_eleve, prenom_eleve, nom_site, id_site;");
                            odbc_fetch_row($result3, 0);
                            $haver = false;
                            while (odbc_fetch_row($result3)) {
                                $haver = true;
                                $name = utf8_encode(odbc_result($result3, "nom_eleve"));
                                $fname = utf8_encode(odbc_result($result3, "prenom_eleve"));
                                $sname = utf8_encode(odbc_result($result3, "nom_site"));
                                $surl = utf8_encode(odbc_result($result3, "url_site"));
                                // si l'administrateur a appelé la vérification
                                if (array_key_exists("verify", $_POST)) {
                                    $file = "http://$surl";
                                    // récupère l'entête du site web
                                    $file_headers = @get_headers($file);
                                    // si l'entête est vde donc l'entrée DNS est manquante
                                    if ($file_headers[0] == "") {
                                        $exists = false;
                                        $s4 .= "\\n$sname par $fname $name";
                                    } else {
                                        $exists = true;
                                    }
                                }
                                $isphp = odbc_result($result3, "php");
                                if (!$isphp) {
                                    // si le site n'est pas php l'afficher normalement
                                    echo "<a href='http://$surl' class='site_eleve w3-card-4 w3-container-glass-2' title=\"&laquo;&nbsp;$sname&nbsp;&raquo; par $fname $name\"><i>$sname</i><b>par $fname $name</b></a>";
                                } else {
                                    // sinon mettre une mention php sur la bannière du site
                                    echo "<a href='http://$surl' class='php site_eleve w3-card-4 w3-container-glass-2' title=\"&laquo;&nbsp;$sname&nbsp;&raquo; par $fname $name\"><i class='php'>$sname</i><b>par $fname $name</b><span><b>php</b></span></a>";
                                }
                            }
                            if (!$haver) {
                                // si il n'y a pas de site dans ce groupe l'afficher
                                echo "<p>Aucun site publié par ce groupe pour l'instant.</p>";
                            }
                            echo "</div>";
                        }
                        echo "</div></div></div>";
                    }
                    // afficher le réultat de la vériofication
                    if (array_key_exists("verify", $_POST)) {
                        echo "<script>alert(\"$s4\")</script>";
                    }
                }

                // effectuer la recherche si il y a des termes à rechercher
                if (array_key_exists("q", $_GET)) {
                    if ($_GET["q"] != "") {
                        $nb = 0;
                        echo "-->";
                        echo "<div class='w3-container w3-margin w3-container-glass w3-padding w3-card-2'><h2>Résultats pour \"" . $_GET["q"] . "\"</h2>";
                        echo "<div class='w3-container-glass-2 w3-margin-top w3-margin-bottom w3-padding w3-card-4 groupe'>";
                        $haver = false;
                        // idem que pour précédemment
                        $odbc = odbc_connect("depweb", "user", "user");
                        if (isset($_POST["col"]) && $_POST["col"] != "") {
                            if (isset($_POST["col_desc"])) {
                                $colp = $_POST["col"];
                                if ($colp == "nom_complet") {
                                    $colp = "nom_eleve DESC, prenom_eleve DESC";
                                } else {
                                    $colp .= " DESC";
                                }
                            } else {
                                $colp = $_POST["col"];
                                if ($colp == "nom_complet") {
                                    $colp = "nom_eleve, prenom_eleve";
                                }
                            }
                            $result1 = odbc_exec($odbc, "SELECT * FROM groupes INNER JOIN sites_eleves ON groupes.id_groupe = sites_eleves.groupe ORDER BY $colp;");
                        } else {
                            $result1 = odbc_exec($odbc, "SELECT * FROM groupes INNER JOIN sites_eleves ON groupes.id_groupe = sites_eleves.groupe ORDER BY nom_site, nom_eleve, prenom_eleve, groupe;");
                        }
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {

                            $ngr = utf8_encode(odbc_result($result1, "nom_groupe"));
                            $name = utf8_encode(odbc_result($result1, "nom_eleve"));
                            $fname = utf8_encode(odbc_result($result1, "prenom_eleve"));
                            $sname = utf8_encode(odbc_result($result1, "nom_site"));
                            $surl = utf8_encode(odbc_result($result1, "url_site"));
                            // même algorithme de recherche que la recherche de documents
                            # $old_error = error_reporting(0);
                            $keys = ["é", "è", "ê", "à", "ù", "û", "â", "ç"];
                            $keysr = ["e", "e", "e", "a", "u", "u", "a", "c"];
                            $snr = "/" . mb_strtolower($_GET["q"]) . "/";
                            $nr = mb_strtolower($name);
                            $fnr = mb_strtolower($fname);
                            $snnr = mb_strtolower($sname);
                            $ngrr = mb_strtolower($ngr);
                            $values_to_replace = [$snr, $nr, $fnr, $snnr, $ngrr];
                            for ($i = 0; $i < count($values_to_replace); $i++) {
                                for ($j = 0; $j < count($keys); $j++) {
                                    $values_to_replace[$i] = str_ireplace($keys[$j], $keysr[$j], $values_to_replace[$i]);
                                }
                            }
                            if (preg_match($values_to_replace[0], $values_to_replace[1]) || preg_match($values_to_replace[0], $values_to_replace[2]) || preg_match($values_to_replace[0], $values_to_replace[3]) || preg_match($values_to_replace[0], $values_to_replace[4])) {
                                $haver = true;
                                $nb++;
                                $isphp = odbc_result($result1, "php");
                                if (!$isphp) {
                                    echo "<a href='http://$surl' class='site_eleve w3-card-4 w3-container-glass-2' title=\"&laquo;&nbsp;$sname&nbsp;&raquo; par $fname $name du groupe $ngr\"><i>$sname</i><b>par $fname $name</b><b>Groupe $ngr</b></a>";
                                } else {
                                    echo "<a href='http://$surl' class='php site_eleve w3-card-4 w3-container-glass-2' title=\"&laquo;&nbsp;$sname&nbsp;&raquo; par $fname $name du groupe $ngr\"><i class='php'>$sname</i><b>par $fname $name</b><b>Groupe $ngr</b><span><b>php</b></span></a>";
                                }
                            }
                        }
                        # error_reporting($old_error);
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
                        echo "</div>";
                    } else {
                        list_sites();
                    }
                } else {
                    list_sites();
                }
                ?>
            </main>
        </div>
    </body>
</html>
<?php
$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];

if (headers_sent())
    $encoding = false;
else if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false)
    $encoding = 'x-gzip';
else if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false)
    $encoding = 'gzip';
else
    $encoding = false;

if ($encoding) {
    $contents = ob_get_clean();
    $_temp1 = strlen($contents);
    if ($_temp1 < 2048) {
        print($contents);
    } else {
        header('Content-Encoding: ' . $encoding);
        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
        $contents = gzcompress($contents, 9);
        $contents = substr($contents, 0, $_temp1);
        print($contents);
    }
} else {
    ob_end_flush();
}
?>