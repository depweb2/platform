<!DOCTYPE html>
<!--
    dep.web 2.0 - page de connexion au panneau d'administration
    par André-Luc Huneault
    14 décembre 2015
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>
        <?php
        require("./include/styles.php");
        require("./include/scripts.php");
        ?>
    </head>
    <body>
        <div id="login" class="w3-modal" style='display: table !important;' taindex="-1">
            <div class="w3-modal-dialog">
                <div class="w3-modal-content w3-android-modal w3-padding-8">
                    <div class="w3-container w3-center">
                        <h1>dep.web<sub>&nbsp;2.0</sub></h1>
                        <h3>Connexion administrateur</h3>
                    </div>
                    <div class="w3-container">
                        <form method="post" action="/admin/login.php" id="login" name="login">
                            <?php
                            if (array_key_exists("bad", $_GET)) {
                                echo "<span style='color: red; font-weight: bold; font-size: 18px;text-align: center;display: inline-block; width: 100%;padding-bottom: 7px;'>Identification incorrecte!</span>";
                            }
                            ?>
                            <input required autofocus placeholder="Nom d'utilisateur" class="w3-input w3-light-grey full" id="u" type="text" name="u"/><br>
                            <input required placeholder="Mot de passe" class="w3-input w3-light-grey full" id="p" type="password" name="p"/><br>
                            <input style="display: none;" type="submit" id="submit" name="submit" value="submit"/>
                        </form>
                    </div>
                    <footer class="w3-container w3-right-align w3-padding-8">
                        <a class="w3-modal-button" href="javascript:void(0);" onclick="document.getElementById('submit').click()">
                            Connexion
                        </a>
                        <a href="/" class="w3-modal-button">
                            Annuler
                        </a>
                    </footer>
                </div>
            </div>
        </div>
        <script>
            window.onload = function () {
                document.getElementById("u").focus();
            };
        </script>
    </body>
</html>
