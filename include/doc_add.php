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
<div id="doc_add" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-android-modal w3-padding-8">
            <div class="w3-container w3-center">
                <h3>Ajouter un document</h3>
            </div>
            <div class="w3-container w3-android-modal-container">
                <form method="post" onsubmit='location.hash = "#upload"' enctype="multipart/form-data" action="/admin/doc_add.php" id="docadd" name="docadd">
                    <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="123" />
                    <label for="nom_doc">
                        Nom du document
                    </label>
                    <input class="w3-input w3-light-grey full" type="text" placeholder='max. 100 caractères' required name="nom_doc" id="nom_doc" size="100"/>
                    <label for="type">
                        Type de document
                    </label>
                    <select name='type' id='type' onchange="swipe_field(this.value);" class='full w3-light-grey w3-input'>
                        <?php
// dresse une liste des groupes
                        $odbc = odbc_connect("depweb", "user", "user");
                        $result1 = odbc_exec($odbc, "SELECT * FROM type_documents ORDER BY type_doc;");
                        odbc_fetch_row($result1, 0);
                        while (odbc_fetch_row($result1)) {
                            $id_type = odbc_result($result1, "id_type_doc");
                            $type = odbc_result($result1, "type_doc");
                            echo "<option value='$id_type'>$type</option>";
                        }
                        ?>
                    </select>
                    <small>"document" et "lien" s'affichent dans la section Documents et liens, tandis que "notes" s'affichent dans Notes de cours et exercices.</small>
                    <br><label for="cours">
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
                            echo "<option value='$id_cours'>$nom_cours ($nid_cours)</option>";
                        }
                        ?>
                    </select>
                    <div id="fileupload">
                        <label for="doc">Téléverser un fichier</label><br>
                        <input type="file" name="doc" id="doc"/><br>
                        <label for="dir_doc2"><b>OU</b> Nom du fichier (si déjà présent)</label>
                        <input class="w3-input w3-light-grey full" type="text" placeholder='max. 255 caractères' name="dir_doc2" id="dir_doc2" size="255"/>
                        <small>Si vous choisissez de téléverser un fichier et tapez un nom de fichier quand même, le fichier téléversé sera renommé avec le nom choisi.</small>
                    </div>
                    <div id="link">
                        <label for='dir_doc'>
                            URL du lien 
                        </label>
                        <input class="w3-input w3-light-grey full" type="text" placeholder='max. 255 caractères' required name="dir_doc" id="dir_doc" size="255"/>
                        <small>Doit commencer par http:// le cas échéant.</small>
                    </div>
                    <input style="display: none;" type="submit" id="submit2" name="submit" value="submit"/>
                    <script>
                        $("#dir_doc").removeAttr("required");
                        $("#fileupload").show();
                        $("#link").hide();
                        $("#doc").removeAttr("disabled");
                        function swipe_field(value) {
                            if (value == 1) {
                                $("#doc, #dir_doc2").attr("disabled", "disabled").removeAttr("required");
                                $("#fileupload").slideUp(200, function () {
                                    $("#link").slideDown(200);
                                });
                                $("#dir_doc").attr("required", "required");
                            } else {
                                $("#dir_doc").removeAttr("required");
                                $("#link").slideUp(200, function () {
                                    $("#fileupload").slideDown(200);
                                });
                                $("#doc, #dir_doc2").removeAttr("disabled");
                            }
                        }
                    </script>
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
