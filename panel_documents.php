<?php
ob_start();
require("/admin/verify_login.php");
if ($IS_LOGGED_IN) {
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
            require("/include/panel_sidebar.php");
            ?>
            <div id="panel_sites" class="w3-modal fs" style='display: table !important;'>
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-theme">
                            <h2>
                                <a class="nou menu-link" href="javascript:void(0)" onclick='w3_toggle()'>
                                    Documents
                                </a>
                                <a class="w3-right w3-modal-confirm no-text" onclick="load_doc_add()" href="javascript:void(0)">
                                    <img src="images/ic_add_white_18dp.png" alt="plus"/>
                                </a>
                            </h2>
                        </header>
                        <div class="w3-modal-main-container">
                            <div class="w3-theme-d2 w3-padding-top w3-padding-bottom">
                                <select id="scours" class="w3-input w3-theme-d1 full" name="scours">
                                    <option>Afficher les documents pour un cours uniquement...</option>
                                    <?php
                                    $sort = false;
                                    $sql = "SELECT * FROM type_documents INNER JOIN (cours INNER JOIN documents ON cours.id_cours = documents.cours) ON type_documents.id_type_doc = documents.type_doc;";
                                    $odbc = odbc_connect("depweb", "user", "user");
                                    $result1 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY id_cours");
                                    odbc_fetch_row($result1, 0);
                                    while (odbc_fetch_row($result1)) {
                                        $cid = odbc_result($result1, "id_cours");
                                        $ncid = utf8_encode(odbc_result($result1, "nom_cours"));
                                        if (isset($_GET["cid"])) {
                                            if ($_GET["cid"] == $cid) {
                                                $sort = true;
                                                $sql = "SELECT * FROM type_documents INNER JOIN (cours INNER JOIN documents ON cours.id_cours = documents.cours) ON type_documents.id_type_doc = documents.type_doc WHERE documents.cours = $cid;";

                                                echo "<option selected value='$cid'>$ncid</option>";
                                            } else {
                                                echo "<option value='$cid'>$ncid</option>";
                                            }
                                        } else {
                                            echo "<option value='$cid'>$ncid</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <script>
                                $('#scours').on('change', function () {
                                    var id = $(this).val(); // get selected value
                                    if (id) { // require a id
                                        window.location = "panel_documents.php?cid=" + id; // redirect
                                    }
                                    return false;
                                });
                            </script>
                            <table class='w3-bordered w3-striped w3-theme-l4'>
                                <?php
                                if ($sort) {
                                    echo "<tr class='w3-blue w3-center bold'><td colspan='6'>Affichage des documents pour un seul cours. <a href='panel_documents.php'>Réinitialiser</a></td></tr>";
                                }
                                ?>
                                <tr class='w3-theme-d2 fixed-table-headers'>
                                    <th>Nom du ducoment</th>
                                    <th>Type</th>
                                    <th>Cours</th>
                                    <th>URL</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                <?php
                                // connexion à la base de données

                                $result1 = odbc_exec($odbc, $sql);
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    // récupère l'information pour la sortie
                                    $idd = odbc_result($result1, "id_doc");
                                    $nomd = utf8_encode(odbc_result($result1, "nom_doc"));
                                    $typed = utf8_encode(odbc_result($result1, "type_doc"));
                                    $coursd = utf8_encode(odbc_result($result1, "nom_cours"));
                                    $nidcoursd = utf8_encode(odbc_result($result1, "nid_cours"));
                                    $urld = utf8_encode(odbc_result($result1, "dir_doc"));
                                    $idcoursd = odbc_result($result1, "cours");
                                    if ($typed == "lien") {
                                        echo "<tr><td>$nomd</td><td>$typed</td><td>$coursd</td><td><a href=\"$urld\">$urld</a></td>";
                                    } else {
                                        echo "<tr><td>$nomd</td><td>$typed</td><td>$coursd</td><td><a href=\"/var/docs/documents_notes/cours/$nidcoursd/$urld\">$urld</a></td>";
                                    }
                                    echo "<td><a class='full w3-btn w3-theme' href='javascript:void(0)' onclick='load_doc_edit($idd)'>Modifier</a></td><td style='width: 1%;'><a class='full w3-btn w3-red' href='javascript:void(0)' onclick='confirm_delete($idd,\"$nomd\")'>Supprimer</a></td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="doc_edit_container">

            </div>
            <script>
                window.onload = function () {
                    // messages d'information
    <?php
    if (array_key_exists("uploaderror", $_GET)) {
        echo "alert('Une erreur est survenue lors du transfert de fichier sur le réseau.');load_doc_add();";
    }
    if (array_key_exists("fileerror", $_GET)) {
        echo "alert('Erreur d'E/S du fichier téléversé.');load_doc_add();";
    }
    if (array_key_exists("filealreadyexists", $_GET)) {
        echo "alert('Impossible de téléverser le fichier, car un fichier du même nom existe déjà.');load_doc_add();";
    }
    if (array_key_exists("missing", $_GET)) {
        echo "alert('Certains champs requis sont manquants.');load_doc_add();";
    }
    if (array_key_exists("filetoolarge", $_GET)) {
        echo "alert('La taille du fichier dépasse la limite des 10 Mo autorisés.');load_doc_add();";
    }
    if (array_key_exists("delete", $_GET)) {
        echo "alert('Document supprimé avec succès.');";
    }
    if (array_key_exists("update", $_GET)) {
        echo "alert('La base de données des documents a été mise à jour avec succès.');";
    }
    if (array_key_exists("add", $_GET)) {
        echo "alert('Document ajouté avec succès.');";
    }
    ?>
                };
                function load_doc_edit(id) {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#doc_edit_container").load("/include/doc_edit.php", {
                        "did": id
                    }, function () {
                        location.hash = "#doc_edit";
                    });
                }
                function load_doc_add() {
                    $("#doc_edit_container").load("/include/doc_add.php", {
                    }, function () {
                        location.hash = "#doc_add";
                    });
                }
                function confirm_delete(id_doc, nom_doc) {
                    // affiche une confirmation avant la suppression
                    var deleting = confirm("Supprimer le document \"" + nom_doc + "\"?\nCette opération est irréversible.");
                    if (deleting) {
                        // si l'utilisateur a cliqué Oui
                        location = "/admin/doc_delete.php?did=" + id_doc + "";
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
    