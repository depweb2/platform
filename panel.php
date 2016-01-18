<?php
ob_start();
require("/admin/verify_login.php");
if ($IS_LOGGED_IN) {
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
                .dep-panels{
                    display: inline-block;
                    width: 100%;
                }
                .dep-panel-link{
                    text-decoration: none;
                    color: white;
                    display: block;
                    float: left;
                    width: 200px;
                    height: 200px;
                    margin: 4px;
                    padding: 10px;
                    text-align: center;
                    font-weight: bold;
                    background-color: #388E3C;
                    -webkit-transition: all 100ms ease;
                    -moz-transition: all 100ms ease;
                    -ms-transition: all 100ms ease;
                    transition: all 100ms ease;
                }
                .dep-panel-link:hover{
                    background-color: #2E7D32;
                }
                .dep-panel-link:active{
                    background-color: #1B5E20;
                }
                .dep-panel-link .dep-panel-link-image{
                    margin: 0 auto;
                }
                .dep-panel-link-title{
                    font-size: 18px;
                    display: block;
                }
                .dep-panel-link-des{
                    font-weight: normal;
                    font-size: 11px;
                }
            </style>
        </head>
        <body>
            <?php
            require("/include/panel_sidebar.php");
            ?>
        <dov id="panel" class="w3-modal fs" style='display: table !important;z-index: 1;'>
            <a href="/admin/logout.php" title="Fermer la session" class="w3-btn-floating-large short more w3-theme w3-card-2">
                <img src="images/ic_exit_to_app_white_18dp.png" alt="Logout"/>
            </a>
            <div class="w3-modal-dialog">
                <div class="w3-modal-content">
                    <header class="w3-container w3-theme">
                        <h2>
                            <a class="nou menu-link" href="javascript:void(0)" onclick='w3_toggle()'>
                                Administration
                            </a>
                        </h2>
                    </header>
                    <div class="w3-padding w3-modal-main-container">
                        
                        <div class="w3-panels">
                            <a class="w3-card-2 dep-panel-link" href="panel_documents.php">
                                <img class="dep-panel-link-image" src="/images/ic_description_white_36dp.png"/>
                                <span class="dep-panel-link-title">Documents</span>
                                <span class="dep-panel-link-des">Gestion des documents, notes de cours et liens des modules</span>
                            </a>
                            <a class="w3-card-2 dep-panel-link" href="panel_cours.php">
                                <img class="dep-panel-link-image" src="/images/ic_school_white_36dp.png"/>
                                <span class="dep-panel-link-title">Modules</span>
                                <span class="dep-panel-link-des">Gestion des modules, plan de cours et enseignants désignés</span>
                            </a>
                            <a class="w3-card-2 dep-panel-link" href="panel_profs.php">
                                <img class="dep-panel-link-image" src="/images/ic_group_white_36dp.png"/>
                                <span class="dep-panel-link-title">Enseignants</span>
                                <span class="dep-panel-link-des">Gestion des informations des enseignants</span>
                            </a>
                            <a class="w3-card-2 dep-panel-link" href="panel_nouvelles.php">
                                <img class="dep-panel-link-image" src="/images/ic_whatshot_white_36dp.png"/>
                                <span class="dep-panel-link-title">Nouvelles</span>
                                <span class="dep-panel-link-des">Gestion du blogue de nouvelles</span>
                            </a>
                            <a class="w3-card-2 dep-panel-link" href="panel_sites.php">
                                <img class="dep-panel-link-image" src="/images/ic_public_white_36dp.png"/>
                                <span class="dep-panel-link-title">Sites Web</span>
                                <span class="dep-panel-link-des">Gestion des créations de sites Web des élèves</span>
                            </a>
                            <a class="w3-card-2 dep-panel-link" href="javascript:void(0)" onclick="verify_sites.submit()">
                                <img class="dep-panel-link-image" src="/images/ic_check_circle_white_36dp.png"/>
                                <span class="dep-panel-link-title">Tester les sites Web</span>
                                <span class="dep-panel-link-des">Valider les sites Web des élèves par l'envoi d'une requête ping</span>
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </body>
    </html>
    <?php
}
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
