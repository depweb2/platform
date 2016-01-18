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
                        <form method="post" action="/admin/cours_prof_update.php" id="coursedit" name="coursedit">
                            <span class="bold">Enseignants donnant le cours</span><br>
                            <input type='hidden' name='id' id='id' value='<?php echo $idc; ?>'/>
                            <?php
                            $result2 = odbc_exec($odbc, "SELECT * FROM enseignants ORDER BY nom_enseignant, prenom_enseignant;");
                            odbc_fetch_row($result2, 0);
                            while (odbc_fetch_row($result2)) {
                                $pid = odbc_result($result2, "id_enseignant");
                                $pprof = utf8_encode(odbc_result($result2, "prenom_enseignant"));
                                $nprof = utf8_encode(odbc_result($result2, "nom_enseignant"));
                                $result3 = odbc_exec($odbc, "SELECT * FROM cours_enseignants WHERE cours = $idc AND enseignant = $pid;");
                                if (odbc_fetch_row($result3)) {
                                    echo "<input value='$pid' class='course-teacher-check' type='checkbox' name='teachers[]' checked/><div class='course-teacher'>$pprof $nprof</div><br>";
                                } else {
                                    echo "<input value='$pid' class='course-teacher-check' type='checkbox' name='teachers[]'/><div class='course-teacher'>$pprof $nprof</div><br>";
                                }
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
