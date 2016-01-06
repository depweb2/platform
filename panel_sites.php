<?php
header('Cache-Control: no-cache, no-store, must-revalidate');

function access_denied() {
    header("Location: /admin/logout.php");
}

function erreur($msg) {
    echo "<script>alert(\"$msg\")</script>";
}

session_start();
$now = time(); // Checking the time now when home page starts.
if ($now > $_SESSION['expire']) {
    access_denied();
}
$login = $_SESSION["login"];
if (!$login == "yes") {
    access_denied();
} else {
    ?>
    <!DOCTYPE html>
    <!--
        dep.web 2.0 - panneau d'administration des sites web des élèves
        par andré-luc huneault
        14 décembre 2015
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Administration</title>
            <?php
            require("/include/styles.php");
            require("/include/scripts.php");
            ?>
            <style>
                body{
                    margin: 0 auto;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                    position: relative;
                }
                .dep-settings-section{
                    padding: 8px;
                }
                td{
                    padding: 5px;
                }
            </style>
        </head>
        <body>
            <?php
            require("./include/loading.php");
            ?>
            <div id="panel_sites" class="w3-modal fs" style='display: table !important;'>
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-theme">
                            <h2>
                                <a class="nou arrow-link" href="/panel.php">
                                    <img class="icon30" src="images/ic_arrow_back_white_18dp.png" alt=""/>
                                    Sites Web des élèves
                                </a>
                                <a class="w3-right w3-modal-confirm no-text" onclick="load_site_add()" href="javascript:void(0)">
                                    <img src="images/ic_add_white_18dp.png" alt="plus"/>
                                </a>
                            </h2>
                        </header>
                        <div class="w3-modal-main-container">
                            <table class='w3-bordered w3-striped w3-theme-l4'>
                                <tr class='w3-theme-d2 fixed-table-headers'>
                                    <?php
                                    // prépare les entêtes de colonnes à recevopir les liens de tri
                                    // tableau contenant les IDs et les noms de colonnes
                                    $sort_ids = [
                                        "nom_site" => "Nom du site Web",
                                        "prenom_eleve" => "Prénom de l'élève",
                                        "nom_eleve" => "Nom de l'élève",
                                        "url_site" => "URL du site Web",
                                        "groupe" => "Groupe"
                                    ];
                                    // dépendant du tri cette variable sera modifiée
                                    $sql_base = "SELECT * FROM sites_eleves";
                                    $is_order = 0;
                                    // cette variable sert juste à mettre temporairement le nom de la colonne triée à des raisons indicatives
                                    $tag_ordered = "";
                                    foreach ($sort_ids as $i => $tag) {
                                        // si il n'y a aucun tri
                                        if (isset($_GET["order_by"])) {
                                            // si le tri est actif
                                            if ($_GET["order_by"] == $i) {
                                                $tag_ordered = $tag;
                                                // la variable GET desc permet d'inverser le tri
                                                if (isset($_GET["desc"])) {
                                                    $is_order = 2;
                                                    echo "<th class='w3-theme-d3'><a href='panel_sites.php?order_by=$i'>$tag ▲</a></th>";
                                                    //  $i -> nom de colonne dans la base de données
                                                    $sql_base .= " ORDER BY $i DESC";
                                                } else {
                                                    $is_order = 1;
                                                    echo "<th class='w3-theme-d3'><a href='panel_sites.php?order_by=$i&desc=true'>$tag ▼</a></th>";
                                                    $sql_base .= " ORDER BY $i";
                                                }
                                            } else {
                                                echo "<th><a href='panel_sites.php?order_by=$i'>$tag</a></th>";
                                            }
                                        } else {
                                            echo "<th><a href='panel_sites.php?order_by=$i'>$tag</a></th>";
                                        }
                                    }
                                    ?>
                                    <th>PHP</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                <?php
                                // affiche un message avertissant du tri si il y en a un
                                switch ($is_order) {
                                    case 2: // si descendant
                                        echo "<tr class='w3-blue bold'><th colspan=8>Triage selon $tag_ordered en ordre décroissant. <a href='panel_sites.php'>Réinitialiser</a></th></tr>";
                                        break;
                                    case 1: // si ascendant
                                        echo "<tr class='w3-blue bold'><th colspan=8>Triage selon $tag_ordered en ordre croissant. <a href='panel_sites.php'>Réinitialiser</a></th></tr>";
                                        break;
                                    case 0: // aucun tri
                                    default:
                                        $sql_base = "SELECT * FROM sites_eleves ORDER BY nom_eleve, prenom_eleve, nom_site";
                                        break;
                                }
                                // connexion à la base de données
                                $odbc = odbc_connect("depweb", "user", "user");
                                $result1 = odbc_exec($odbc, $sql_base);
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    // récupère l'information pour la sortie
                                    $nom = utf8_encode(odbc_result($result1, "nom_eleve"));
                                    $prenom = utf8_encode(odbc_result($result1, "prenom_eleve"));
                                    $url_site = utf8_encode(odbc_result($result1, "url_site"));
                                    $nom_site = utf8_encode(odbc_result($result1, "nom_site"));
                                    $id_site = odbc_result($result1, "id_site");
                                    $id_current_groupe = odbc_result($result1, "groupe");
                                    echo "<tr><td>$nom_site</td><td>$prenom</td><td>$nom</td><td><a href='http://$url_site'>$url_site</a></td>";
                                    // affiche le groupe associé au site web
                                    $result2 = odbc_exec($odbc, "SELECT * FROM groupes ORDER BY nom_groupe DESC;");
                                    odbc_fetch_row($result2, 0);
                                    while (odbc_fetch_row($result2)) {
                                        $id_groupe = odbc_result($result2, "id_groupe");
                                        $nom_groupe = odbc_result($result2, "nom_groupe");
                                        // affiche uniquement le groupe associé au site Web
                                        if ($id_groupe == $id_current_groupe) {
                                            echo "<td>$nom_groupe</td>";
                                        }
                                    }
                                    $is_php = odbc_result($result1, "php");
                                    // la variable is_php est TRUE si cochée et NULL si décochée
                                    if ($is_php) {
                                        echo "<td>Oui</td>";
                                    } else {
                                        echo "<td>Non</td>";
                                    }
                                    echo "<td><a class='full w3-btn w3-theme' href='javascript:void(0)' onclick='load_site_edit($id_site)'>Modifier</a></td><td style='width: 1%;'><a class='full w3-btn w3-red' href='javascript:void(0)' onclick='confirm_delete($id_site,\"$nom_site\")'>Supprimer</a></td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="site_edit_container">

            </div>
            <script>
                window.onload = function () {
                    // messages d'information
    <?php
    if (array_key_exists("delete", $_GET)) {
        echo "alert('Site Web supprimé avec succès.');";
    }
    if (array_key_exists("update", $_GET)) {
        echo "alert('La base de données des sites Web a été mise à jour avec succès.');";
    }
    if (array_key_exists("add", $_GET)) {
        echo "alert('Site Web ajouté avec succès.');";
    }
    ?>
                };
                function load_site_edit(id) {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#site_edit_container").load("/include/site_edit.php", {
                        "sid": id
                    }, function () {
                        location.hash = "#site_edit";
                    });
                }
                function load_site_add() {
                    $("#site_edit_container").load("/include/site_add.php", {
                    }, function () {
                        location.hash = "#site_add";
                    });
                }
                function confirm_delete(id_site, nom_site) {
                    // affiche une confirmation avant la suppression
                    var deleting = confirm("Supprimer le site Web \"" + nom_site + "\"?\nCette opération est irréversible.");
                    if (deleting) {
                        // si l'utilisateur a cliqué Oui
                        location = "/admin/site_delete.php?sid=" + id_site + "";
                    }
                }
            </script>

            <a href="javascript:void(0)" onclick="gototop()" title="Haut de la page" class="w3-animate-bottom w3-card-2 short top w3-btn-floating-large w3-theme-dark">
                <img src="images/ic_expand_less_white_18dp.png" alt=""/>
            </a>
        </body>
    </html>
    <?php
}
    