<?php
ob_start();
?>
<!DOCTYPE html>
<!--
    dep.web 2.0 - page des méritants pour l'assiduité
    par André-Luc Huneault
    14 décembre 2015
-->
<html>
    <head>
        <title>Méritants pour l'assiduité - dep.web</title>
        <?php
        require("./include/styles.php");
        require("./include/cstyle.php");
        require("./include/scripts.php");
        ?>
        <link href="css/assiduite.css" rel="stylesheet" type="text/css"/>
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
                <div id="cname" class="ctitle w3-container w3-theme-d3">
                    <h2>Méritants pour l'assiduité</h2>
                </div>
                <div class='ass_container w3-container w3-margin w3-padding w3-container-glass-black w3-card-8'>
                    <?php
                    // connexion à la base de données
                    $odbc = odbc_connect("depweb", "user", "user");
                    $result1 = odbc_exec($odbc, "SELECT * FROM periode_ass ORDER BY id_periode_ass DESC;");
                    odbc_fetch_row($result1, 0);
                    while (odbc_fetch_row($result1)) {
                        // haver est faux tant qu'il n'y a pas d'enregistrements
                        $haver = false;
                        $paid = odbc_result($result1, "id_periode_ass");
                        $pad = utf8_encode(odbc_result($result1, "date_debut"));
                        $paf = utf8_encode(odbc_result($result1, "date_fin"));
                        echo "<h3>Élèves ayant eu 0% d'absence du $pad au $paf</h3>";
                        $result2 = odbc_exec($odbc, "SELECT * FROM groupes ORDER BY nom_groupe;");
                        odbc_fetch_row($result2, 0);
                        while (odbc_fetch_row($result2)) {
                            // il y a des enregistrements donc haver est vrai
                            $haver = true;
                            // haver2 permet d'afficher uniquement la catégorie si il y a des enregistrements ainsi seules les périodes
                            // avec des élèves assidus seront affichés
                            $haver2 = false;
                            $idgr = odbc_result($result2, "id_groupe");
                            $ngr = utf8_encode(odbc_result($result2, "nom_groupe"));
                            $result3 = odbc_exec($odbc, "SELECT * FROM assiduite WHERE groupe=$idgr AND periode_ass = $paid");
                            odbc_fetch_row($result3,0);
                            if(odbc_fetch_row($result3)) {
                                odbc_fetch_row($result3,0);
                                echo "<h4>Groupe $ngr</h4><ul class='ass_list'>";
                                while (odbc_fetch_row($result3)) {
                                    $haver2 = true;
                                    // récupère et affiche l'élève
                                    $fna = utf8_encode(odbc_result($result3, "prenom_eleve"));
                                    $na = utf8_encode(odbc_result($result3, "nom_eleve"));
                                    echo "<li>$fna $na</li>";
                                }
                            }
                            echo "</ul>";
                        }
                        if(!$haver){
                            // si aucun élève marquer une note le disant
                            echo "<h4>Aucun groupe ou élève pour cette date.</h4>";
                        }
                    }
                    ?>
                </div>
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