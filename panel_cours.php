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
            <div id="panel_cours" class="w3-modal fs" style='display: table !important;'>
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-theme">
                            <h2>
                                <a class="nou arrow-link" href="/panel.php">
                                    <img class="icon30" src="images/ic_arrow_back_white_18dp.png" alt=""/>
                                    Modules et stages
                                </a>
                            </h2>
                        </header>
                        <div class="w3-modal-main-container">
                            <table class='w3-bordered w3-striped w3-theme-l4'>
                                <tr class='w3-theme-d2 fixed-table-headers'>
                                    <th>Nom du module</th>
                                    <th>Nom générique</th>
                                    <th>Type de module</th>
                                    <th>Durée du cours</th>
                                    <th>Modifier</th>
                                </tr>
                                <?php
                                // connexion à la base de données
                                $odbc = odbc_connect("depweb", "user", "user");
                                $result1 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY id_cours;");
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    // récupère l'information pour la sortie
                                    $idc = odbc_result($result1, "id_cours");
                                    $nomc = utf8_encode(odbc_result($result1, "nom_cours"));
                                    $nidc = utf8_encode(odbc_result($result1, "nid_cours"));
                                    $typec = odbc_result($result1, "stage");
                                    $durc = odbc_result($result1, "dur_cours");
                                    $sdurc = odbc_result($result1, "stage_dur_semaine");
                                    echo "<tr><td><a href='/cours.php?c=$nidc'>$nomc (M$idc)</a></td><td>$nidc</td>";
                                    if($typec){
                                        echo "<td>Stage</td><td>$durc jours (".$sdurc."h/sem.)</td>";
                                    }else{
                                        echo "<td>Cours</td><td>$durc heures</td>";
                                    }
                                    echo "<td style='width: 1%;'><a class='full w3-btn w3-theme' href='javascript:void(0)' onclick='load_cours_edit($idc)'>Modifier</a></td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="cours_edit_container">

            </div>
            <script>
                window.onload = function () {
                    // messages d'information
    <?php
    if (array_key_exists("update", $_GET)) {
        echo "alert('La base de données des cours a été mise à jour avec succès.');";
    }
    if(array_key_exists("error", $_GET)){
        echo "alert(\"Erreur lors de l'enregistrement. La valeur saisie n'est pas un nombre valide.\");";
        if(isset($_GET["cid"])){
            if($_GET["cid"] != ""){
                echo "load_cours_edit(".$_GET["cid"].");";
            }
        }
    }
    ?>
                };
                function load_cours_edit(id) {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#cours_edit_container").load("/include/cours_edit.php", {
                        "dic": id
                    }, function () {
                        location.hash = "#cours_edit";
                    });
                }
            </script>

            <a href="javascript:void(0)" onclick="gototop()" title="Haut de la page" class="w3-animate-bottom w3-card-2 short top w3-btn-floating-large w3-theme-dark">
                <img src="images/ic_expand_less_white_18dp.png" alt=""/>
            </a>
        </body>
    </html>
    <?php
}
    