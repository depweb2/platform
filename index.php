<!DOCTYPE html>
<!--
    dep.web 2.0 - page d'accueil
    par André-Luc Huneault
    14 décembre 2015
-->
<html>
    <head>
        <title>dep.web</title>
        <?php
        require("./include/styles.php");
        require("./include/scripts.php");
        ?>
        <script src="lib/index.js" type="text/javascript"></script>
        <link href="css/index.css" rel="stylesheet" type="text/css"/>
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
                <?php
                require("./include/slides.php");
                ?>
                <div id="cname" class="si-ctitle-c ctitle w3-container">
                    <h2 class="si-ctitle bold">
                        Soutien informatique (5229)
                    </h2>
                </div>
                <!--<div id="cname" class="ctitle w3-container w3-white w3-center w3-padding">
                    <img class="w3-centered cfnt2" src="images/cfnt.png" alt=""/>
                </div>-->
                <div id="index_tabs" class="w3-white">
                    <?php
                    if (!array_key_exists("s", $_GET) || (array_key_exists("s", $_GET) && $_GET["s"] == "pres")) {
                        ?>
                        <div id="index_nav" class="index_nav w3-theme-d3">
                            <h2 class="w3-left w3-padding-right w3-padding-left">Accueil</h2>
                            <a title="Message de bienvenue et description du programme" class="current" href="index.php?s=pres">
                                Présentation
                            </a>
                            <a title="Affiche le calendrier du mois et l'heure" href="index.php?s=cal">
                                Calendrier et horloge
                            </a>
                            <a title="Flux RSS connectés" href="index.php?s=res">
                                Nouvelles
                            </a>
                        </div>
                        <div id="index_tab" class="w3-white">
                            <div id="pres">
                                <!--<div class="beta-warning w3-blue w3-card-2 w3-margin-top w3-margin-bottom w3-padding-medium">
                                    <div>

                                    </div>
                                    <div>
                                        <h3>Nous attendons vos idées!</h3>
                                        <p>
                                            dep.web 2.0 est maintenant prêt à l'emploi. Cependant, vos idées nous permettront d'ajouter les fonctionnalités que vous désirez. Envoyez vos commentaires, suggestions et avis de bogues et <b>courez la chance de gagner un prix gracieusité du département SI!</b> 
                                            Nous vous invitons à donner vos commentaires sur cette plateforme à l'adresse courriel <b>depweb20@gmail.com</b><br>
                                            <a class='w3-white w3-btn w3-margin' href='mailto:depweb20@gmail.com'>Envoyer un commentaire...</a> 
                                            <a class='w3-white w3-btn w3-margin' href='changelog.php'>Historique des mises à jour</a> 
                                            <span class="ib">Numéro de version actuelle: <b>build 3060 stable</b></span>
                                        </p>
                                    </div>
                                </div>-->
                                <div class="w3-margin w3-theme-d4 w3-card-2 w3-padding-medium">
                                    <h3>Bienvenue sur dep.web 2.0</h3>
                                    <?php
                                        echo odbc_errormsg();
                                    ?>
                                    <b>dep.web est le site Intranet du département de Soutien informatique du Centre de formation des Nouvelles-Technologies. 
                                        Il vous donne accès aux plans de cours, exercices, liens et autres documents utiles à la réussite du D.E.P. <br/>
                                        <br></b>
                                    Choisisez un onglet ci-haut pour commencer.
                                </div>
                                <div class="w3-margin w3-card-2">
                                    <div class='w3-row'>
                                        <div class="w3-half w3-padding-small w3-theme-d3">
                                            <h2>Objectifs du programme</h2>
                                            <p>
                                                Le programme Soutien informatique permettra à l'élève...
                                            </p>
                                            <ul>
                                                <li>d’appliquer une méthode de résolution de problèmes, de recherche d’information et de gestion du temps;</li>
                                                <li>d’utiliser de façon optimale des logiciels : mettre à profit les possibilités des systèmes d’exploitation de technologies vieillissante et de technologies de pointe, exploiter les possibilités des logiciels d’application, créer et exploiter une base de données, exploiter les possibilités des moyens de télécommunication;</li>
                                                <li>d’interagir adéquatement dans des situations variées et de fournir l’assistance à la clientèle à partir d’un centre d’appels;</li>
                                                <li>d’exécuter des tâches sur des postes informatiques autonomes ou reliés en réseau : d’analyser l’architecture et le fonctionnement de systèmes informatiques, en rétablir le fonctionnement ou en optimiser le rendement;</li>
                                                <li>de communiquer adéquatement en milieu de travail et au service à la clientèle;</li>
                                                <li>de s’intégrer au milieu de travail.</li>
                                            </ul>
                                        </div>
                                        <div class="w3-half w3-padding-small w3-theme-d2">
                                            <h2>
                                                Qualité et aptitudes requises
                                            </h2>                  
                                            <ul>
                                                <li>Faire preuve de persévérance pour résoudre un problème</li>
                                                <li>Avoir une capacité d’adaptation et de concentration élevés pour passer d’un problème à un autre</li>
                                                <li>Faire preuve d’autonomie</li>
                                                <li>Avoir un raisonnement logique</li>
                                                <li>Avoir de la facilité en français et en anglais</li>
                                                <li>Avoir de l’intérêt et de l’habilité pour le service à la clientèle</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class='w3-row'>
                                        <div class="w3-half w3-padding-small w3-theme-d2">
                                            <h2>
                                                Marché du travail
                                            </h2>
                                            <p>La profession consiste à fournir du soutien aux utilisateurs de l'informatique. Le travail comporte les aspects suivants:</p>
                                            <ul>
                                                <li>préparation, installation et adaptation des éléments en environnement informatique en fonction de besoins des usagers;</li>
                                                <li>information auprès des usagers quant au mode d'utilisation de leur système informatique;</li>
                                                <li>dépannage au moment de problèmes liés à l'utilisation des équipements et des programmes informatiques;</li>
                                                <li>renvoi de demandes de service aux personnes-ressources appropriées.</li>
                                            </ul>
                                            <p>Selon les entreprises dans lesquelles elles travaillent, les personnes peuvent effectuer d,autres tâches comme préparer des documents, des procédures d'instruction ou d'entretien, ou encore, conseiller les utilisateurs au sujet de l'achat de logiciels ou d'équipements informatiques.</p>
                                        </div>
                                        <div class="w3-half w3-padding-small w3-theme-d3">
                                            <h2>Lieux de travail:</h2>
                                            <ul>
                                                <li>Entreprises privées et publiques</li>
                                                <li>Municipalités</li>
                                                <li>Établissements d’enseignement</li>
                                                <li>Toute entreprise ayant un système informatique</li>
                                            </ul>
                                            <hr>
                                            <h2>Professions visées:</h2>
                                            <ul>
                                                <li>Soutien technique en micro-informatique</li>
                                                <li>Responsable du support informatique aux usagers</li>
                                                <li>Opérateur informatique</li>
                                            </ul>
                                            <p>Certains diplômés choisissent d'être travailleurs autonomes,</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else if ($_GET["s"] == "cal") {
                        ?>

                        <div id="index_nav" class="index_nav w3-theme-d3">
                            <h2 class="w3-left w3-padding-right w3-padding-left">Accueil</h2>
                            <a title="Message de bienvenue et description du programme" href="index.php?s=pres">
                                Présentation
                            </a>
                            <a class="current" title="Affiche le calendrier du mois et l'heure" href="index.php?s=cal">
                                Calendrier et horloge
                            </a>
                            <a title="Flux RSS connectés" href="index.php?s=res">
                                Nouvelles
                            </a>
                        </div>
                        <div id="index_tab" class="w3-white">
                            <div id="cal" class="w3-margin-4 w3-center">
                                <div class="w3-half">
                                    <h2>Horloge</h2>
                                    <canvas class="w3-border w3-theme-d3" id="clock" height="300" width="300">
                                        Impossible de charger le module org.w3schools.canvasClock. Navigateur non compatible.\nPour afficher l'horloge, vous devez disposer d'un navigateur supportant les canvas vectoriels SVG version 1.1 ou version ultérieure.
                                    </canvas>
                                    <script>
                                        // affiche l'horloge par SVG à toutes les secondes
                                        var canvas = document.getElementById("clock");
                                        var ctx = canvas.getContext("2d");
                                        var radius = canvas.height / 2;
                                        ctx.translate(radius, radius);
                                        radius = radius * 0.90;
                                        setInterval(drawClock, 1000);

                                        function drawClock() {
                                            drawFace(ctx, radius);
                                            drawNumbers(ctx, radius);
                                            drawTime(ctx, radius);
                                        }

                                        function drawFace(ctx, radius) {
                                            var grad;
                                            ctx.beginPath();
                                            ctx.arc(0, 0, radius, 0, 2 * Math.PI);
                                            ctx.fillStyle = '#4CAF50';
                                            ctx.fill();
                                            grad = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
                                            grad.addColorStop(0, 'white');
                                            grad.addColorStop(0.5, 'white');
                                            grad.addColorStop(1, 'white');
                                            ctx.strokeStyle = grad;
                                            ctx.lineWidth = radius * 0.1;
                                            ctx.stroke();
                                            ctx.beginPath();
                                            ctx.arc(0, 0, radius * 0.1, 0, 2 * Math.PI);
                                            ctx.fillStyle = 'white';
                                            ctx.fill();
                                        }

                                        function drawNumbers(ctx, radius) {
                                            var ang;
                                            var num;
                                            ctx.font = radius * 0.15 + "px Roboto";
                                            ctx.textBaseline = "middle";
                                            ctx.textAlign = "center";
                                            for (num = 1; num < 13; num++) {
                                                ang = num * Math.PI / 6;
                                                ctx.rotate(ang);
                                                ctx.translate(0, -radius * 0.85);
                                                ctx.rotate(-ang);
                                                ctx.fillText(num.toString(), 0, 0);
                                                ctx.rotate(ang);
                                                ctx.translate(0, radius * 0.85);
                                                ctx.rotate(-ang);
                                            }
                                        }

                                        function drawTime(ctx, radius) {
                                            var now = new Date();
                                            var hour = now.getHours();
                                            var minute = now.getMinutes();
                                            var second = now.getSeconds();
                                            //hour
                                            hour = hour % 12;
                                            hour = (hour * Math.PI / 6) +
                                                    (minute * Math.PI / (6 * 60)) +
                                                    (second * Math.PI / (360 * 60));
                                            drawHand(ctx, hour, radius * 0.5, radius * 0.07);
                                            //minute
                                            minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
                                            drawHand(ctx, minute, radius * 0.8, radius * 0.07);
                                            // second
                                            second = (second * Math.PI / 30);
                                            drawHand(ctx, second, radius * 0.9, radius * 0.02);
                                        }

                                        function drawHand(ctx, pos, length, width) {
                                            ctx.beginPath();
                                            ctx.lineWidth = width;
                                            ctx.lineCap = "round";
                                            ctx.moveTo(0, 0);
                                            ctx.rotate(pos);
                                            ctx.lineTo(0, -length);
                                            ctx.stroke();
                                            ctx.rotate(-pos);
                                        }
                                    </script>
                                </div>
                                <div class="w3-half" style="display: block;">
                                    <h2>Calendrier</h2>
                                    <?php
                                    // fonction permet d'afficher le calendrier
                                    // sans cette ligne le code produit un avertissement Deprecated pour la commande getdate
                                    $olderr = error_reporting(0);
                                    $year = getdate()["year"];
                                    $month = date("n");
                                    $month2 = date("m");
                                    // draw_calendar est situé dans /ibclude/calendar.php
                                    echo draw_calendar($month, $month2, $year);
                                    error_reporting($olderr);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>

                        <div id="index_nav" class="index_nav w3-theme-d3">
                            <h2 class="w3-left w3-padding-right w3-padding-left">Accueil</h2>
                            <a title="Message de bienvenue et description du programme" href="index.php?s=pres">
                                Présentation
                            </a>
                            <a title="Affiche le calendrier du mois et l'heure" href="index.php?s=cal">
                                Calendrier et horloge
                            </a>
                            <a class="current" title="Flux RSS connectés" href="index.php?s=res">
                                Nouvelles
                            </a>
                        </div>
                        <div id="index_tab" class="w3-white">
                            <div id="res">
                                <h3 class="w3-margin">Nouvelles du département SI</h3>
                                <?php
                                // connexion à la base de données
                                // SQL_CUR_USE_ODBC permet de faire passer les champs Mémo sans problème
                                $odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
                                // obtient la liste des enregistrements pour le blogue de nouvelles
                                $result1 = odbc_exec($odbc, "SELECT * FROM nouvelles ORDER BY date_nouv DESC;");
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    $tnew = utf8_encode(odbc_result($result1, "titre_nouv"));
                                    $mnew = utf8_encode(odbc_result($result1, "message_nouv"));
                                    $dnew = date_format(date_create(odbc_result($result1, "date_nouv")), "Y-m-d");
                                    // pour chaque enregistrement ajouter une carte contenant la nouvelle
                                    echo "<div class='w3-card-2 w3-theme-d1 w3-margin w3-padding'><h4 style='background: url(/images/ic_arrow_forward_white_18dp.png) no-repeat 0 center; padding: 5px;padding-left: 45px;margin: 0;' class='bold'>$tnew</h4>";
                                    echo "<i style='position: relative; padding-top: -10px;padding-left: 45px;'>Publié le $dnew</i><br>";
                                    echo "<p class='w3-margin'>$mnew</p></div>";
                                }
                                ?>
                                <?php
                                // lecteur de flux RSS
                                // ---------------------
                                // cette ligne permet de toujours permettre l'ouverture d'URL externes sur n'importe quel serveur
                                ini_set("allow_url_fopen", "On");
                                // objet DOMDocument représente un document XML
                                $xmlDoc = new DOMDocument();
                                // si les messages d'erreur ne sont pas retirés ce code affiche un message Deprecated en raison de l'usage de HTTP au lieu d'HTTPS par le serveur de la CSSMI
                                $olderr = error_reporting(0);
                                // si le serveur RSS de la CSSMI est accessible...
                                if ($xmlDoc->load("http://www.cssmi.qc.ca/rss-nouvelles") !== false) {
                                    // le charger
                                    $xmlDoc->load("http://www.cssmi.qc.ca/rss-nouvelles");
                                    // ce code est typique d'un lecteur RSS
                                    $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
                                    echo "<h3 class='w3-margin' >Nouvelles de la CSSMI</h3>";
                                    $x = $xmlDoc->getElementsByTagName('item');
                                    echo "<ul class='rss-feed ib w3-container full'>";
                                    for ($i = 0; $i < 10; $i++) {
                                        // récupère le titre de la nouvelle
                                        $item_title = $x->item($i)->getElementsByTagName('title')
                                                        ->item(0)->childNodes->item(0)->nodeValue;
                                        // recupère le lien
                                        $item_link = $x->item($i)->getElementsByTagName('link')
                                                        ->item(0)->childNodes->item(0)->nodeValue;
                                        // récupère la date
                                        $item_date = $x->item($i)->getElementsByTagName('pubDate')
                                                        ->item(0)->childNodes->item(0)->nodeValue;
                                        // modifie la date avec un format plus lisible
                                        $item_date = mb_substr($item_date, 5, 20);
                                        echo ("<li class='w3-theme w3-card-2 w3-padding w3-margin-bottom full w3-container'><a class='bold' style='display: block;float: left;width: 66%;background: url(/images/ic_arrow_forward_white_18dp.png) no-repeat 0 center; padding: 5px;padding-left: 45px;' href='" . $item_link
                                        . "'>" . $item_title . "</a>");
                                        echo ("<i style='float: left;text-align: right;display: block; width: 33%; padding: 5px;'>" . $item_date . "</i>");
                                        echo ("</li>");
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p class='full w3-center'>Impossible de charger les actualités, car la connexion Internet semble interrompue.</p><script>alert(\"Erreur lors du chargement du module org.w3schools.phpRSSLoader. Aucune connexion Internet.\\nVérifiez l'état de la connexion puis réessayez.\")</script>";
                                }
                                // réactive les messages d'erreur
                                error_reporting($olderr);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </main>
        </div>
    </body>
</html>