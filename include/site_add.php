<?php
session_start();
$now = time(); // Checking the time now when home page starts.
if ($now > $_SESSION['expire']) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
}
$login = $_SESSION["login"];
if (!$login == "yes") {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
}
?>
<div id="site_add" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-android-modal w3-padding-8">
            <div class="w3-container w3-center">
                <h3>Ajouter un site</h3>
            </div>
            <div class="w3-container w3-android-modal-container">
                <form method="post" action="/admin/site_add.php" id="siteadd" name="siteadd">
                    <label for="nom_site">
                        Nom du site Web
                    </label>
                    <input class="w3-input w3-light-grey full" type="text" placeholder='max. 100 caractères' required name="nom_site" id="nom_site" size="100"/>
                    <label for="prenom_eleve">
                        Prénom de l'élève
                    </label>
                    <input class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="prenom_eleve" id="prenom_eleve" size="40"/>
                    <label for="nom_eleve">
                        Nom de l'élève
                    </label>
                    <input class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="nom_eleve" id="nom_eleve" size="40"/>
                    <label for="url_site">
                        URL du site Web
                    </label>
                    <input class="w3-input w3-light-grey full" type="text" placeholder='sans le préfixe http://' required name="url_site" id="url_site" size="40"/>
                    <label for='groupe'>
                        Groupe
                    </label>
                    <select name='groupe' id='groupe' class='full w3-light-grey w3-input'>
                        <?php
                        // dresse une liste des groupes
                        $odbc = odbc_connect("depweb", "user", "user");
                        $result1 = odbc_exec($odbc, "SELECT * FROM groupes ORDER BY nom_groupe DESC;");
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {
                            $id_groupe = odbc_result($result1, "id_groupe");
                            $nom_groupe = odbc_result($result1, "nom_groupe");
                            echo "<option value='$id_groupe'>$nom_groupe</option>";
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
                                    <input type='checkbox' name='php' id='php'>
                                </td>
                            </tr>
                        </table>            
                    </fieldset>
                    <input style="display: none;" type="submit" id="submit2" name="submit" value="submit"/>
                </form>
            </div>
            <footer class="w3-container w3-right-align w3-padding-8">
                <br>
                <a class="w3-modal-button" href="javascript:void(0)" onclick="document.getElementById('submit2').click()">
                    Enregistrer
                </a>
                <a href="#" class="w3-modal-button">
                    Annuler
                </a>
            </footer>
        </div>
    </div>
</div>
