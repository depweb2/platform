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
if (!isset($_POST["dic"])) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
} else {
    $page_id = $_POST["dic"];
    $odbc = odbc_connect("depweb", "user", "user");
    $result = odbc_exec($odbc, "SELECT * FROM cours WHERE id_cours=$page_id");
    if (odbc_fetch_row($result)) {
        $idc = odbc_result($result, "id_cours");
        $nomc = utf8_encode(odbc_result($result, "nom_cours"));
        $nidc = utf8_encode(odbc_result($result, "nid_cours"));
        $typec = odbc_result($result, "stage");
        $durc = odbc_result($result, "dur_cours");
        $sdurc = odbc_result($result, "stage_dur_semaine");
        ?>
        <div id="cours_edit" class="w3-modal">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-android-modal w3-padding-8">
                    <div class="w3-container w3-center">
                        <h3><?php echo $nomc; ?></h3>
                    </div>
                    <div class="w3-container">
                        <form method="post" action="/admin/cours_update.php" id="coursedit" name="coursedit">
                            <input type='hidden' name='id' id='id' value='<?php echo $idc; ?>'/>

                            <?php
                            if ($typec) {
                                ?>
                                <label for='durc'>Durée du stage (en jours)</label>
                                <input value="<?php echo $durc; ?>" class="w3-input w3-light-grey full" type="number" placeholder="nombre de jours" required name="durc" id="durc" size="3"/>
                                <?php
                            } else {
                                ?>
                                <label for='durc'>Durée du cours (en heures)</label>
                                <input value="<?php echo $durc; ?>" class="w3-input w3-light-grey full" type="number" placeholder="nombre d'heures" required name="durc" id="durc" size="3"/>
                                <?php
                            }
                            ?>
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
