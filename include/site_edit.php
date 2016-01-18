<?php
session_start();
$now = time(); // Checking the time now when home page starts.
if ($now > $_SESSION['expire']) {
        session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
}
$login = $_SESSION["login"];
if (!$login) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
}
if (!isset($_POST["sid"])) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
} else {
    // récupère l'id su site depuis POST
    $page_id = $_POST["sid"];
    // si le id n'est pas égal à 0 il ne s'agit pas d'un ajout
    if ($page_id != 0) {
        //connexion à la base de données
        $odbc = odbc_connect("depweb", "user", "user");
        $result = odbc_exec($odbc, "SELECT * FROM sites_eleves WHERE id_site=$page_id;");
        if (odbc_fetch_row($result)) {
            $id_site = odbc_result($result, "id_site");
            $nom_site = utf8_encode(odbc_result($result, "nom_site"));
            $prenom_eleve = utf8_encode(odbc_result($result, "prenom_eleve"));
            $nom_eleve = utf8_encode(odbc_result($result, "nom_eleve"));
            $url_site = utf8_encode(odbc_result($result, "url_site"));
            $groupe = odbc_result($result, "groupe");
            $php = odbc_result($result, "php");
            ?>
            <div id="site_edit" class="w3-modal" taindex="-1">
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content w3-android-modal w3-padding-8">
                        <div class="w3-container w3-center">
                            <h3>Modifier un site</h3>
                        </div>
                        <div class="w3-container w3-android-modal-container">
                            <form method="post" action="/admin/site_update.php" id="site_edit" name="site_edit">
                                <input type="hidden" name="id_site" id="id_site" value="<?php echo $id_site; ?>"
                                       <label for="nom_site">
                                    Nom du site Web
                                </label>
                                <input value="<?php echo $nom_site; ?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 100 caractères' required name="nom_site" id="nom_site" size="100"/>
                                <label for="prenom_eleve">
                                    Prénom de l'élève
                                </label>
                                <input value="<?php echo $prenom_eleve; ?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="prenom_eleve" id="prenom_eleve" size="40"/>
                                <label for="nom_eleve">
                                    Nom de l'élève
                                </label>
                                <input value="<?php echo $nom_eleve; ?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="nom_eleve" id="nom_eleve" size="40"/>
                                <label for="url_site">
                                    URL du site Web
                                </label>
                                <input value="<?php echo $url_site; ?>" class="w3-input w3-light-grey full" type="text" placeholder='sans le préfixe http://' required name="url_site" id="url_site" size="40"/>
                                <label for='groupe'>
                                    Groupe
                                </label>
                                <select name='groupe' id='groupe' class='full w3-light-grey w3-input'>
                                    <?php
                                    // liste les groupes
                                    $result1 = odbc_exec($odbc, "SELECT * FROM groupes ORDER BY nom_groupe DESC;");
                                    odbc_fetch_row($result1, 0);
                                    while (odbc_fetch_row($result1)) {
                                        $id_groupe = odbc_result($result1, "id_groupe");
                                        $nom_groupe = odbc_result($result1, "nom_groupe");
                                        if ($groupe == $id_groupe) {
                                            // si le groupe du site est celui dans la liste le sélectionner
                                            echo "<option selected value='$id_groupe'>$nom_groupe</option>";
                                        } else {
                                            echo "<option value='$id_groupe'>$nom_groupe</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <fieldset>
                                    <legend>Options</legend>
                                    <table>
                                        <tr>
                                            <td>
                                                <label for='php'>Site propulsé par PHP</label>
                                            </td>
                                            <td>
                                                <?php
                                                if ($php) {
                                                    echo "<input type='checkbox' name='php' checked id='php' value='$id_site'>";
                                                } else {
                                                    echo "<input type='checkbox' name='php' id='php' value='$id_site'>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>            
                                </fieldset>
                                <input style="display: none;" type="submit" id="submit" name="submit" value="submit"/>
                            </form>
                        </div>
                        <footer class="w3-container w3-right-align w3-padding-8">
                            <br>
                            <a class="w3-modal-button" href="javascript:void(0);" onclick="document.getElementById('submit').click()">
                                Enregistrer
                            </a>
                            <a href="#" class="w3-modal-button">
                                Annuler
                            </a>
                        </footer>
                    </div>
                </div>
            </div>
            <script>
            </script>
            <?php
        }
    }    
}