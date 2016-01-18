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
if (!isset($_POST["nid"])) {
    session_unset();
    session_destroy();
    header('HTTP/1.0 403 Forbidden');
} else {
    $id = $_POST["nid"];
    $odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
    $result1 = odbc_exec($odbc, "SELECT * FROM nouvelles WHERE id_nouv = $id;");
    if (!odbc_fetch_row($result1)) {
        session_unset();
        session_destroy();
        header('HTTP/1.0 403 Forbidden');
    } else {
        $idn = odbc_result($result1, "id_nouv");
        $titre = utf8_encode(odbc_result($result1, "titre_nouv"));
        $message = utf8_encode(odbc_result($result1, "message_nouv"));
        $date = date_format(date_create(odbc_result($result1, "date_nouv")), "Y-m-d");
        ?>
        <div id="nouv_edit" class="w3-modal">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-animate-bottom">
                    <header class="w3-container w3-theme">
                        <h2>
                            <a class="nou close-link" href="#">
                                Modifier
                            </a>       
                            <a class="w3-right w3-modal-confirm no-text w3-context-open" onclick="open_context('.save_nouv')" href="javascript:void(0)">
                                <img src="images/ic_done_white_18dp.png" alt="plus"/>
                            </a>
                        </h2>
                        <div class="save_nouv w3-context right">
                            <a href="javascript:void(0)" onclick="document.getElementById('submit2').click()">
                                Enregistrer
                            </a>
                            <a href="#">
                                Annuler
                            </a>
                        </div>
                    </header>
                    <div class="w3-container w3-modal-main-container w3-padding">
                        <form method="post" action="/admin/nouv_update.php" id="nouvadd" name="nouvadd">
                            <label for="titre">
                                Titre de la nouvelle
                            </label>
                            <input class="w3-input w3-theme-l4 full" type="text" placeholder='max. 100 caractères' required name="titre" id="titre" size="100" value="<?php echo $titre; ?>"/>
                            <label for="message">
                                Message
                            </label>
                            <textarea class="w3-input w3-theme-l4 full" type="text" placeholder='Écrivez votre nouvelle ici (HTML/CSS/JS autorisé)' required name="message" id="message"><?php echo $message; ?></textarea>
                            <label for='daten'>
                                Date de modification
                            </label>
                            <br>
                            <small>La précédente date de modification/publication est écrasée lors de l'enregistrement.</small>
                            <input class="w3-input w3-theme-l4 full" type="date" required readonly="" name="daten" id="daten" value=""/>
                            <script>
                                function formatDate() {
                                    var d = new Date(),
                                            month = '' + (d.getMonth() + 1),
                                            day = '' + d.getDate(),
                                            year = d.getFullYear();

                                    if (month.length < 2)
                                        month = '0' + month;
                                    if (day.length < 2)
                                        day = '0' + day;

                                    return [year, month, day].join('-');
                                }
                                $("#daten").attr("value", "" + formatDate() + "");
                            </script>
                            <input type="hidden" name="idn" id="idn" value="<?php echo $idn; ?>"/>
                            <input style="display: none;" type="submit" id="submit2" name="submit" value="submit"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

