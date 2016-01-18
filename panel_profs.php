<?php
ob_start();
require("/admin/verify_login.php");
if ($IS_LOGGED_IN) {
    ?>
    <!DOCTYPE html>
    <!--
        dep.web 2.0 - panneau d'administration des enseignants
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
                .photo_prev{
                    position: relative;
                    display: inline-block;
                }
                .photo_prev > .pv{
                    display: none;
                    position: absolute;
                    top: -40px;
                    left: 100%;
                    height: 106px;
                    width: 106px;
                    background: rgba(255,255,255,0.95);
                    border-radius: 5px;
                    padding: 5px;
                    z-index: 999999;
                }
            </style>

        </head>
        <body>
            <?php
            require("./include/loading.php");
            require("/include/panel_sidebar.php");
            ?>
            <div id="panel_profs" class="w3-modal fs" style='display: table !important;'>
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-theme">
                            <h2>
                                <a class="nou menu-link" href="javascript:void(0)" onclick='w3_toggle()'>
                                    Enseignants
                                </a>
                                <a class="w3-right w3-modal-confirm no-text" onclick="load_prof_add()" href="javascript:void(0)">
                                    <img src="images/ic_add_white_18dp.png" alt="plus"/>
                                </a>
                            </h2>
                        </header>
                        <div class="w3-modal-main-container">
                            <table class='w3-bordered w3-striped w3-theme-l4'>
                                <tr class='w3-theme-d2 fixed-table-headers'>
                                    <th>Nom de l'enseignant</th>
                                    <th>Courriel</th>
                                    <th>Courriel activé</th>
                                    <th>Fichier photo</th>
                                    <th>Modifier</th>
                                    <th>Supprimer</th>
                                </tr>
                                <?php
                                // connexion à la base de données
                                $odbc = odbc_connect("depweb", "user", "user");
                                $result1 = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant, prenom_enseignant;");
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    // récupère l'information pour la sortie
                                    $idp = odbc_result($result1, "id_enseignant");
                                    $nom = utf8_encode(odbc_result($result1, "nom_enseignant"));
                                    $prenom = utf8_encode(odbc_result($result1, "prenom_enseignant"));
                                    $email = utf8_encode(odbc_result($result1, "email_enseignant"));
                                    $perm_email = odbc_result($result1, "perm_email");
                                    $photo = odbc_result($result1, "photo_url");
                                    echo "<tr><td>$prenom $nom</td><td><a href=\"mailto:$email\">$email</a></td>";
                                    if ($perm_email) {
                                        echo "<td>Oui</td>";
                                    } else {
                                        echo "<td>Non</td>";
                                    }
                                    echo "<td><div class='photo_prev'>$photo<div class='pv w3-card-4'><img src='/images/profs/$photo'/></div></div></td><td style='width: 1%;'><a class='full w3-btn w3-theme' href='javascript:void(0)' onclick='load_prof_edit($idp)'>Modifier</a><td style='width: 1%;'><a class='full w3-btn w3-red' href='javascript:void(0)' onclick='confirm_delete($idp, \"$prenom $nom\")'>Supprimer</a></td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="prof_edit_container">

            </div>
            <script>
                window.onload = function () {
                    // messages d'information
    <?php
    if (array_key_exists("update", $_GET)) {
        echo "alert('La base de données des enseignants a été mise à jour avec succès.');";
    }
    if (array_key_exists("add", $_GET)) {
        echo "alert('Enseignant ajouté avec succès.');";
    }
    if (array_key_exists("uploaderror", $_GET)) {
        echo "alert(\"Une erreur est survenue pendant le téléversement. Veuillez réessayer.\");";
        if (isset($_GET["cid"])) {
            if ($_GET["cid"] != "") {
                echo "load_prof_add(()";
            }
        }
    }
    if (array_key_exists("uploaderror2", $_GET)) {
        echo "alert(\"Une erreur est survenue pendant le téléversement. Veuillez réessayer.\");";
        if (isset($_GET["cid"])) {
            if ($_GET["cid"] != "") {
                echo "load_prof_edit(" . $_GET["cid"] . ");";
            }
        }
    }
    ?>
                };
                $(".photo_prev").on("mouseenter", function () {
                    $(this).children(".pv").fadeIn(100);
                });
                $(".photo_prev").on("mouseleave", function () {
                    $(this).children(".pv").fadeOut(100);
                });
                function load_prof_edit(id) {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#prof_edit_container").load("/include/prof_edit.php", {
                        "dip": id
                    }, function () {
                        location.hash = "#prof_edit";
                    });
                }
                function load_prof_add() {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#prof_edit_container").load("/include/prof_add.php", function () {
                        location.hash = "#prof_add";
                    });
                }
                function confirm_delete(id_prof, nom_prof) {
                    // affiche une confirmation avant la suppression
                    var deleting = confirm("Supprimer \"" + nom_prof + "\" de la base de données?\nCette opération est irréversible.");
                    if (deleting) {
                        // si l'utilisateur a cliqué Oui
                        location = "/admin/prof_delete.php?pid=" + id_prof + "";
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
    