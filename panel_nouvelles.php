<?php
ob_start();
require("/admin/verify_login.php");
if ($IS_LOGGED_IN) {
    ?>
    <!DOCTYPE html>
    <!--
        dep.web 2.0 - panneau d'administration du blogue de nouvelles
        par andré-luc huneault
        14 décembre 2015
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Administration</title>
            <?php
            require("/include/styles.php");
            require("/include/scripts.php");
            ?>
            <style>
                body{
                    margin: 0 auto;
                    padding: 0;
                    width: 100%;
                    height: 100%;
                    position: relative;
                }
                .dep-settings-section{
                    padding: 8px;
                }
                td{
                    padding: 5px;
                }
                textarea{
                    height: 200px;
                }
                #news_add input, #news_add textarea{
                    padding: 4px;
                    padding-left: 0;
                    margin-left: 0;
                }
                .w3-modal{
                    z-index: -1;
                }
            </style>
        </head>
        <body>
            <?php
            require("./include/loading.php");
            require("/include/panel_sidebar.php");
            ?>
            <div id="panel_nouvelles" class="w3-modal fs" style='display: table !important;'>
                <div class="w3-modal-dialog">
                    <div class="w3-modal-content">
                        <header class="w3-container w3-theme">
                            <h2>
                                <a class="nou menu-link" href="javascript:void(0)" onclick='w3_toggle()'>
                                    Nouvelles
                                </a>
                                <a class="w3-right w3-modal-confirm no-text" onclick="open_add_news()" href="javascript:void(0)">
                                    <img src="images/ic_add_white_18dp.png" alt="plus"/>
                                </a>
                            </h2>
                        </header>
                        <div class="w3-modal-main-container">
                            <div id="news_add" style="display: none;">
                                <div class="w3-container w3-margin w3-margin-bottom w3-theme-d2 w3-padding w3-card-2">
                                    <form method="post" action="/admin/nouv_add.php">
                                        <h3>
                                            <input type="text" name="titre2" id="titre2" required class="w3-theme-d2 full w3-input" placeholder="Entrez le titre de la nouvelle ici"/>
                                        </h3>
                                        <i id="datea"></i>
                                        <input type="text" style="display: none;" name="daten2" id="daten2" value=""/><br>
                                        <textarea required class="w3-margin-8 w3-input w3-theme-d2 full " id="message2" name="message2" placeholder="Entrez le texte de la nouvelle ici..."></textarea>
                                        <div class="w3-left-align ib">
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('b');" title="Gras"><b>B</b></a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('i');" title="Italique"><i>I</i></a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('u');" title="Souligné"><u>U</u></a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('h1');">Titre 1</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('h2');">Titre 2</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('h3');">Titre 3</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="formatText('h4');">Titre 4</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="insertLink();">Lien...</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="insertImage();">Image...</a>
                                            <a class="w3-btn w3-white" href="javascript:void(0)" onclick="insertColor();">Couleur...</a>
                                        </div>
                                        <div class="w3-right-align">
                                            <a class='w3-btn w3-theme' href="javascript:void(0);"  onclick="document.getElementById('submit3').click()">Enregistrer</a>
                                            <a class='w3-btn w3-theme' href="javascript:void(0);" onclick="close_add_news()">Annuler</a>
                                        </div>
                                        <input type="reset" style="display: none;" id="reset"/>
                                        <input style="display: none;" type="submit" id="submit3" name="submit" value="submit"/>
                                        <script>
                                            function formatDate2() {
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
                                            $("#datea").html("publié le " + formatDate2() + "");
                                            $("#daten2").attr("value", "" + formatDate2() + "");
                                        </script>
                                    </form>
                                </div>
                            </div>

                            <?php
                            $odbc = odbc_connect("depweb", "user", "user", SQL_CUR_USE_ODBC);
                            $result1 = odbc_exec($odbc, "SELECT * FROM nouvelles ORDER BY date_nouv DESC;");
                            odbc_fetch_row($result1, 0);
                            while (odbc_fetch_row($result1)) {
                                $idn = odbc_result($result1, "id_nouv");
                                $titre = utf8_encode(odbc_result($result1, "titre_nouv"));
                                $message = utf8_encode(odbc_result($result1, "message_nouv"));
                                $date = date_format(date_create(odbc_result($result1, "date_nouv")), "Y-m-d");
                                ?>
                                <div class="w3-container w3-margin w3-margin-bottom w3-theme-d2 w3-padding w3-card-2">
                                    <h3><?php echo $titre; ?></h3>
                                    <i>publié le <?php echo $date ?></i>
                                    <p>
                                        <?php echo $message; ?>
                                    </p>
                                    <div class="w3-right-align">
                                        <a class='w3-btn w3-theme' href="javascript:void(0);" onclick="load_news_edit(<?php echo $idn ?>);">Modifier</a>
                                        <a class='w3-btn w3-red' href="javascript:void(0);" onclick='confirm_delete(<?php echo $idn; ?>, "<?php echo $titre ?>");'>Supprimer</a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="nouv_edit_container">

            </div>
            <script>
                window.onload = function () {
                    // messages d'information
    <?php
    if (array_key_exists("delete", $_GET)) {
        echo "alert('Nouvelle supprimée avec succès.');";
    }
    if (array_key_exists("update", $_GET)) {
        echo "alert('La base de données du bloque a été mise à jour avec succès.');";
    }
    if (array_key_exists("add", $_GET)) {
        echo "alert('Nouvelle ajoutée avec succès.');";
    }
    ?>
                };

                var elem = document.getElementById("message2");


                function insertImage() {
                    var url = prompt("Entrez l'URL de l'image à utiliser: ", "/images/");
                    if (url != null) {
                        var desc = prompt("Entrez une description à l'image: ");
                        if (desc != null) {
                            elem.value = elem.value + "<img src='" + url + "' alt=\"" + desc + "\" title=\"" + desc + "\"/>";
                        }
                    }
                }
                function insertLink() {
                    var link = prompt("Entrez un lien valide: ", "http://");
                    if (link != null) {

                        var start = elem.selectionStart;
                        var end = elem.selectionEnd;
                        var len = elem.value.length;
                        var sel_txt = elem.value.substring(start, end);

                        if (sel_txt != "") {
                            var begin_tag = "<a href='" + link + "'>";
                            var close_tag = "</a>";
                            var replace = begin_tag + sel_txt + close_tag;
                            elem.value = elem.value.substring(0, start) + replace + elem.value.substring(end, len);
                        }
                    }
                }
                function insertColor() {
                    var color = prompt("Entrez une couleur HTML valide (peut être RGB, RGBA, HSLA ou hexadécimal avec le signe #: ");
                    if (color != null) {

                        var start = elem.selectionStart;
                        var end = elem.selectionEnd;
                        var len = elem.value.length;
                        var sel_txt = elem.value.substring(start, end);

                        if (sel_txt != "") {
                            var begin_tag = "<span style='color: " + color + "'>";
                            var close_tag = "</span>";
                            var replace = begin_tag + sel_txt + close_tag;
                            elem.value = elem.value.substring(0, start) + replace + elem.value.substring(end, len);
                        }
                    }
                }
                function formatText(key) {


                    /*start of selection area*/
                    var start = elem.selectionStart;
                    var end = elem.selectionEnd;
                    var len = elem.value.length;
                    var sel_txt = elem.value.substring(start, end);

                    if (sel_txt != "") {
                        var begin_tag = "<" + key + ">";
                        var close_tag = "</" + key + ">";
                        var replace = begin_tag + sel_txt + close_tag;
                        elem.value = elem.value.substring(0, start) + replace + elem.value.substring(end, len);
                    }
                }
                function open_add_news() {
                    document.getElementById('reset').click();
                    $("#news_add").slideDown(200);
                }
                function close_add_news() {
                    $("#news_add").slideUp(200);
                }
                function load_news_edit(id) {
                    // charge par XMLHTTP le foumulaure d'édition et l'affiche
                    // si aucun id n'est trouvé une erreur 403 se produit (c'est voulu)
                    $("#nouv_edit_container").load("/include/nouv_edit.php", {
                        "nid": id
                    }, function () {
                        location.hash = "#nouv_edit";
                    });
                }
                function load_news_add() {
                    $("#nouv_edit_container").load("/include/nouv_add.php", {
                    }, function () {
                        location.hash = "#nouv_add";
                    });
                }
                function confirm_delete(id_nouv, nom_nouv) {
                    // affiche une confirmation avant la suppression
                    var deleting = confirm("Supprimer la nouvelle \"" + nom_nouv + "\" ?\nCette opération est irréversible.");
                    if (deleting) {
                        // si l'utilisateur a cliqué Oui
                        location = "/admin/nouv_delete.php?nid=" + id_nouv + "";
                    }
                }
            </script>

            <a href="javascript:void(0)" onclick="gototop()" title="Haut de la page" class="w3-animate-bottom w3-card-2 short top w3-btn-floating-large w3-theme-dark">
                <img src="images/ic_expand_less_white_18dp.png" alt=""/>
            </a>
        </body>
    </html>
    <?php
}
$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"];

if (headers_sent())
    $encoding = false;
else if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false)
    $encoding = 'x-gzip';
else if (strpos($HTTP_ACCEPT_ENCODING, 'gzip') !== false)
    $encoding = 'gzip';
else
    $encoding = false;

if ($encoding) {
    $contents = ob_get_clean();
    $_temp1 = strlen($contents);
    if ($_temp1 < 2048) {
        print($contents);
    } else {
        header('Content-Encoding: ' . $encoding);
        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
        $contents = gzcompress($contents, 9);
        $contents = substr($contents, 0, $_temp1);
        print($contents);
    }
} else {
    ob_end_flush();
}
?>