<div class="sidebar-block"></div>
<div id="sidebar" class="sideclosed w3-sidenav w3-theme">
    <header class="w3-theme-d1 w3-container">
        <h2 title="Modules (cliquer pour fermer)" onclick="w3_toggle()" >
            <img class="icon30" src="images/ic_arrow_back_white_18dp.png" alt=""/>
            Modules
        </h2>
    </header>
    <div class="classes">
        <div class="classes-container">
            <ul class="w3-ul">
                <?php
                $olderr = error_reporting(0);
                // connexion à la base de données
                $odbc = odbc_connect("depweb", "user", "user");
                if (!$odbc) {
                    // si la connexion échoue affi9cher un message d'erreur
                    error_reporting($olderr);
                    echo "<p>Impossible d'afficher la liste des cours car une erreur est survenue lors de la lecture à la base de données.</p>";
                    echo "<script>alert('Erreur lors du chargement du module com.si.cfnt.depweb.sidebar. Lien symbolique ODBC manquant ou endommagé.\\nVeuillez contacter votre administrateur système.');</script>";
                } else {
                    error_reporting($olderr);
                    $result1 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY id_cours;");
                    odbc_fetch_row($result1, 0);
                    while (odbc_fetch_row($result1)) {
                        $cname = utf8_encode(odbc_result($result1, "nom_cours"));
                        $cdes = utf8_encode(odbc_result($result1, "des_cours"));
                        $cid = utf8_encode(odbc_result($result1, "nid_cours"));
                        if (array_key_exists("c", $_GET)) {
                            // si le cours de la liste est celui sélectionné sur la page de cours alors le mettre en surbrillance
                            if ($_GET["c"] == $cid) {
                                echo "<li><a class='bold current' href='cours.php?c=$cid' title=\"$cdes\">$cname</a></li>";
                            } else {
                                echo "<li><a href='cours.php?c=$cid' title=\"$cdes\">$cname</a></li>";
                            }
                        } else {
                            echo "<li><a href='cours.php?c=$cid' title=\"$cdes\">$cname</a></li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>