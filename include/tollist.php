<?php
/*
 * dep.web 2.0 - informations sur l'enseignant
 * par André-Luc Huneault
 * 14 décembre 2015
 */
// si l'ID du prof n'est pas là on termine le chargement
if(!array_key_exists("t", $_GET)){
    die("<script>alert('Impossible de charger le module. Argument GET manquant.')</script>");
}else if($_GET["t"] == ""){
    die("<script>alert('Impossible de charger le module. Argument GET manquant.')</script>");
}else{
    // sinon on connecte la base de données
    $odbc = odbc_connect("depweb", "user", "user");
    $result1 = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant, prenom_enseignant;");
    odbc_fetch_row($result1, 0);
    while(odbc_fetch_row($result1)){
        $pid = odbc_result($result1, "id_enseignant");
        // si l'ID de l'enseignant dans la BD est celui sélectionné
        if ($pid == $_GET["t"]) {
            // on récupère les infos
            $pname = utf8_encode(odbc_result($result1, "nom_enseignant"));
            $pfname = utf8_encode(odbc_result($result1, "prenom_enseignant"));
            $pemail = utf8_encode(odbc_result($result1, "email_enseignant"));
            $pcan = odbc_result($result1, "perm_email");
            echo "<header class='w3-container w3-theme'>
                <a href='#' class='w3-closebtn'>&times;</a>
                <h2>
                    <a class='nou arrow-link' href='#teachers'>
                        $pfname $pname
                    </a>                              
                </h2>
            </header>";
            $purl = utf8_encode(odbc_result($result1, "photo_url"));
            echo "<div class='w3-container w3-padding w3-modal-main-container'>"
            . "<div class='w3-third w3-padding to-mail'>"
                    . "<img src='/images/profs/$purl' alt='$pfname $pname'/>";
            if ($pcan == 1) {
                echo "<a title=\"Envoyer un courriel à $pfname $pname ($pemail)\" class='w3-btn w3-theme bold mail-title' href='mailto:$pemail'>Envoyer un courriel à $pfname $pname</a>";
            } else {
                echo "<a title=\"Envoyer un courriel à $pfname $pname\" class='w3-btn w3-theme bold mail-title' href='#tcr'>Envoyer un courriel à $pfname $pname</a>";
            }
             echo "</div><div class='w3-padding w3-twothird'><h3>Cours donnés.</h3>";
             echo "<ul>";
             // liste des cours dont le prof donne
             $result2 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY nom_cours;");
             odbc_fetch_row($result2, 0);
             while(odbc_fetch_row($result2)){
                 $cid = odbc_result($result2, "id_cours");
                 $result3 = odbc_exec($odbc, "SELECT * FROM cours_enseignants WHERE cours_enseignants.cours = $cid AND cours_enseignants.enseignant = $pid ORDER BY cours_enseignants.cours;");
                 odbc_fetch_row($result3, 0);
                 while(odbc_fetch_row($result3)){
                     $cname = utf8_encode(odbc_result($result2, "nom_cours"));
                     $ccid = utf8_encode(odbc_result($result2, "nid_cours"));
                     echo "<li><a href=\"/cours.php?c=$ccid\">$cname</a></li>";
                 }
             }
            echo "</ul></div></div>";
        }
    }
}

