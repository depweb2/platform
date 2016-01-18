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
?>
<div id="nouv_add" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content">
            <header class="w3-container w3-theme">
                <h2>Ajouter une nouvelle</h2>
            </header>
            <div class="w3-container">
                <form method="post" action="/admin/nouv_add.php" id="nouvadd" name="nouvadd">
                    <label for="titre">
                        Titre de la nouvelle
                    </label>
                    <input class="w3-input w3-theme-l4 full" type="text" placeholder='max. 100 caractères' required name="titre" id="titre" size="100"/>
                    <label for="message">
                        Message
                    </label>
                    <textarea class="w3-input w3-theme-l4 full" type="text" placeholder='Écrivez votre nouvelle ici (HTML/CSS/JS autorisé)' required name="message" id="message"></textarea>
                    <label for='daten'>
                        Date de publication
                    </label>
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
                        $("#daten").attr("value", ""+formatDate()+"");
                    </script>
                    <input style="display: none;" type="submit" id="submit2" name="submit" value="submit"/>
                </form>
            </div>
            <footer class="w3-container w3-right-align w3-padding-8">
                <a class="w3-btn w3-theme" href="javascript:void(0)" onclick="document.getElementById('submit2').click()">
                    Enregistrer
                </a>
                <a href="#" class="w3-btn w3-theme">
                    Annuler
                </a>
            </footer>
        </div>
    </div>
</div>

