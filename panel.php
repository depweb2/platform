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
        <dov id="panel" class="w3-modal fs" style='display: table !important;z-index: 1;'>
            <a href="/admin/logout.php" title="Fermer la session" class="w3-btn-floating-large short more w3-theme w3-card-2">
                <img src="images/ic_exit_to_app_white_18dp.png" alt="Logout"/>
            </a>
            <div class="w3-modal-dialog">
                <div class="w3-modal-content">
                    <header class="w3-container w3-theme">
                        <h2>                             
                            <a class="nou" href="/admin/logout.php">
                                Administration
                            </a>
                        </h2>
                    </header>
                    <div class="w3-padding w3-modal-main-container">
                        <div class="dep-settings-section">
                            <h2>Documents de cours</h2>
                            <div class="w3-container">
                                <div class="w3-quarter">
                                    <a class="full w3-btn w3-theme" href="panel_documents.php">Gérer les documents de cours</a>
                                </div>
                                <div class="w3-padding ib">
                                    Ajouter, modifier ou supprimer des entrées de la base de données des documents relisé au cours.
                                </div>
                            </div>
                        </div>
                        <div class="dep-settings-section">
                            <h2>Sites Web des élèves</h2>
                            <div class="w3-container">
                                <div class="w3-quarter">
                                    <form name="verify_sites" method="post" hidden action="sites_eleves.php">
                                        <input type="hidden" name="verify" value="yes"/>
                                    </form>
                                    <a class="full w3-btn w3-theme" href="#panel" onclick="verify_sites.submit()">Vérifier les sites Web</a>
                                </div>
                                <div class="w3-padding ib">
                                    Cela va vérifier l'existence des adresses Intranet dans la base de données DNS du serveur B-219.
                                </div>
                            </div>
                            <div class="w3-container">
                                <div class="w3-quarter">
                                    <a class="full w3-btn w3-theme" href="/panel_sites.php#panel_sites">Gérer les sites Web</a>
                                </div>
                                <div class="w3-padding ib">
                                    Gérer la base de données des sites Web
                                </div>
                            </div>
                        </div>
                        <div class="dep-settings-section">
                            <h2>Blogue de nouvelles</h2>
                            <div class="w3-container">
                                <div class="w3-quarter">
                                    <a class="full w3-btn w3-theme" href="panel_nouvelles.php">Gérer le blogue de nouvelles</a>
                                </div>
                                <div class="w3-padding ib">
                                    Gérer les entrée du blogue de nouvelle interne de dep.web. Le blogue de nouvelles s'affiche sur la page d'accueil dans l'onglet Nouvelles.
                                </div>
                            </div>
                        </div>
                        <div class="dep-settings-section">
                            <h2>Modules et stages</h2>
                            <div class="w3-container">
                                <div class="w3-quarter">
                                    <a class="full w3-btn w3-theme" href="panel_cours.php">Gérer les modules</a>
                                </div>
                                <div class="w3-padding ib">
                                    Afficher ou modifier les information relatives aux cours et aux stages
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </dov>
        <script>
            window.onload = function () {
    <?php
// affiche un message de bienvenue à la connexion
    if (isset($_GET["first"])) {
        echo "alert(\"Bienvenue sur le panneau d'administration dep.web. (expérimental)\\nVotre session est ouverte pour 30 minutes si le navigateur reste ouvert.\");";
    }
    ?>
            };
        </script>
    </body>
    </html>
    <?php
}
?>
