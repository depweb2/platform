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
        ?>
        <div id="cours_edit" class="w3-modal">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-android-modal w3-padding-8">
                    <div class="w3-container w3-center">
                        <h3><?php echo $nomc; ?></h3>
                    </div>
                    <div class="w3-container">
                        <form method="post" enctype='multipart/form-data' action="/admin/cours_plan_upload.php" id="coursedit" name="coursedit">
                            <span class='bold'>Téléverser un plan de cours (format PDF)</span><br>
                            <input accept='.pdf' required type='file' id='plan' name='plan'/>
                            <input type='hidden' name='nidc' id='nidc' value='<?php echo $nidc;?>'/><br>
                            <input type='hidden' name='idc' id='idc' value='<?php echo $idc;?>'/><br>
                            <br>
                            <b>Chemin d'accès en sortie: </b><br>
                            <i class="w3-padding">/var/docs/plans_cours/<?php echo $nidc;?>.pdf</i>
                            
                            <br><br><small>Le fichier sera renommé par le nom générique du cours, peu importe le nom original, et sera placé sous "/var/docs/plans_cours".</small>                           
                            <input type='submit' id='submit2' name="submit2" style='display: none;' value='Enregistrer'/>
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
