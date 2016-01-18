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
$odbc = odbc_connect("depweb", "user", "user");
$result = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant, prenom_enseignant");
odbc_fetch_row($result, 0);
while (odbc_fetch_row($result)) {
    $idp = odbc_result($result, "id_enseignant");
    if ($idp == $_POST["dip"]) {
        $prenom = utf8_encode(odbc_result($result, "prenom_enseignant"));
        $nom = utf8_encode(odbc_result($result, "nom_enseignant"));
        $email = utf8_encode(odbc_result($result, "email_enseignant"));
        $perm = odbc_result($result, "perm_email");
        $photo = utf8_encode(odbc_result($result, "photo_url"));
        ?>
        <div id="prof_edit" class="w3-modal">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-android-modal w3-padding-8">
                    <div class="w3-container w3-center">
                        <h3>Modifier un enseignant</h3>
                    </div>
                    <div class="w3-container w3-android-modal-container">
                        <form method="post" enctype="multipart/form-data" action="/admin/prof_update.php" id="docadd" name="docadd">
                            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                            <input type='hidden' name='id' id='id' value='<?php echo $idp?>'/>
                            <label for="nom_doc">
                                Prénom
                            </label>
                            <input value="<?php echo $prenom?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="prenom" id="prenom" size="40"/>
                            <label for="type">
                                Nom
                            </label>
                                    <input value="<?php echo $nom ?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 40 caractères' required name="nom" id="nom" size="40"/> 
                                    <label for="type">
                                        Adresse courriel
                                    </label>
                                    <span class='w3-right'><label for='perm_email'>Autorisé</label>
                                        <?php
                                        if ($perm == 1) {
                                            ?>
                                            <input type="checkbox" name="perm_email" id='perm_email' checked/>
                                            `<?php
                                        } else {
                                            ?>
                                            <input type="checkbox" name="perm_email" id='perm_email'/>
                                            <?php
                                        }
                                        ?>
                            </span>
                            <input value="<?php echo $email ?>" class="w3-input w3-light-grey full" type="email" placeholder='max. 100 caractères' required name="email" id="email" size="100"/>                    
                            <fieldset>
                                <legend>Téléverser une photo (format JPG)</legend>
                                <input type='file' onchange='readURL(this)' name='photo' id='photo'/>
                                <table><tr><td><div id='apercu_c' class='ib'><img id='apercu' alt='Aucune image sélectionnée' style='text-align: center;width: 96px;height:96px;margin: 0 auto;' src="/images/profs/<?php echo $photo ?>"/></div></td><td>L'image sera redimensionnée avec une taille de 96x96 pixels. Si aucune image n'est choisie, celle-ci contre sera conservée.</td></tr></table>
                                <script>
                                    function readURL(input) {

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                $('#apercu').attr('src', e.target.result);
                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                        //$("#apercu_c").html("Ce navigateur ne supporte pas la fonction d'aperçu.");
                                    }
                                </script>
                            </fieldset>
                            <input type="submit" value="Envoyer" id="submit2" name="submit2" style="display:none;"/>
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
        <?php
    }
}