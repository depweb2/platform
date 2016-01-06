<div class="tl">
    <?php
    $olderr = error_reporting(0);
    // connexion à la base de données
    $odbc = odbc_connect("depweb", "user", "user");
    if (!$odbc) {
        // si ça échoue afficher un message d'erreur
        error_reporting($olderr);
        echo "<p>Impossible d'afficher la liste des enseignants car une erreur est survenue lors de la lecture à la base de données.</p>";
        echo "<script>alert('Erreur lors du chargement du module com.si.cfnt.depweb.teacherslist. Lien symbolique ODBC manquant ou endommagé.\\nVeuillez contacter votre administrateur système.');</script>";
    } else {
        error_reporting($olderr);
        $result1 = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant;");
        odbc_fetch_row($result1, 0);
        while (odbc_fetch_row($result1)) {
            // récupère les informations sur l'enseignant
            $pid = odbc_result($result1, "id_enseignant");
            $pfname = utf8_encode(odbc_result($result1, "prenom_enseignant"));
            $pname = utf8_encode(odbc_result($result1, "nom_enseignant"));
            $pemail = utf8_encode(odbc_result($result1, "email_enseignant"));
            $ptrue = odbc_result($result1, "perm_email");
            $ppurl = utf8_encode(odbc_result($result1, "photo_url"));
            // puis l'affiche
            echo "<a class='tooltip' href='#teacher' onclick='teacher($pid);' title=\"Voir les infos de $pfname $pname\"><img src='images/profs/$ppurl' alt=''/><b></b>$pfname $pname</a>";
        }
    }
    ?>
</div>
<div class="contact">
    Pour contacter le département: <a href="tel:4504335480">(450) 433-5480 poste 5872</a>
</div>