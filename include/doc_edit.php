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
if (!isset($_POST["did"])) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
} else {
    $page_id = $_POST["did"];
    $odbc = odbc_connect("depweb", "user", "user");
    $result = odbc_exec($odbc, "SELECT * FROM documents WHERE id_doc=$page_id");
    if (odbc_fetch_row($result)) {
        $idd = odbc_result($result, "id_doc");
        $nomd = utf8_encode(odbc_result($result, "nom_doc"));
        $typed = odbc_result($result, "type_doc");
        $coursd = odbc_result($result, "cours");
        $urld = utf8_encode(odbc_result($result, "dir_doc"));
        ?>
        <div id="doc_edit" class="w3-modal">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-android-modal w3-padding-8">
                    <div class="w3-container w3-center">
                        <h3>Modifier un document</h3>
                    </div>
                    <div class="w3-container w3-android-modal-container">
                        <form method="post" action="/admin/doc_update.php" id="siteadd" name="siteadd">
                            <input type='hidden' name='id' id='id' value='<?php echo $idd; ?>'/>
                            <label for="nom_doc">
                                Nom du document
                            </label>
                            <input value="<?php echo $nomd; ?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 100 caractères' required name="nom_doc" id="nom_doc" size="100"/>
                            <label for="type">
                                Type de document
                            </label>
                            <select name='type' id='type' class='full w3-light-grey w3-input'>
                                <?php
                                // dresse une liste des groupes
                                $odbc = odbc_connect("depweb", "user", "user");
                                $result1 = odbc_exec($odbc, "SELECT * FROM type_documents ORDER BY type_doc;");
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    $id_type = odbc_result($result1, "id_type_doc");
                                    $type = odbc_result($result1, "type_doc");
                                    if ($id_type == $typed) {
                                        echo "<option selected value='$id_type'>$type</option>";
                                    } else {
                                        echo "<option value='$id_type'>$type</option>";
                                    }
                                }
                                ?>
                            </select>
                            <small>"document" et "lien" s'affichent dans la section Documents et liens, tandis que "notes" s'affichent dans Notes de cours et exercices.</small>
                            <label for="cours">
                                Cours associé
                            </label>
                            <select name='cours' id='cours' class='full w3-light-grey w3-input'>
                                <?php
                                // dresse une liste des groupes
                                $odbc = odbc_connect("depweb", "user", "user");
                                $result1 = odbc_exec($odbc, "SELECT * FROM cours ORDER BY id_cours;");
                                odbc_fetch_row($result1, 0);
                                while (odbc_fetch_row($result1)) {
                                    $id_cours = odbc_result($result1, "id_cours");
                                    $nom_cours = utf8_encode(odbc_result($result1, "nom_cours"));
                                    $nid_cours = odbc_result($result1, "nid_cours");
                                    if ($id_cours == $coursd) {
                                        echo "<option selected value='$id_cours'>$nom_cours ($nid_cours)</option>";
                                    } else {
                                        echo "<option value='$id_cours'>$nom_cours ($nid_cours)</option>";
                                    }
                                }
                                ?>
                            </select>
                            <label for='dir_doc'>
                                Nom du fichier ou URL
                            </label>
                            <input value="<?php echo $urld;?>" class="w3-input w3-light-grey full" type="text" placeholder='max. 255 caractères' required name="dir_doc" id="dir_doc" size="255"/>
                            <small>Si le type est lien, ce champ doit contenir une adresse Web. Sinon, uniquement mettre le nom du fichier (ex Fichier.pdf) dans son répertoire de cours attribué par le nom générique du cours.</small>
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
        <?php
    }
}
