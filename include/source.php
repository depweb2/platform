<?php ?>
<!DOCTYPE html>
<html>
    <head>
        <link href="../css/include/default.css" rel="stylesheet" type="text/css"/>
        <script src="../lib/include/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="../lib/include/highlight.pack.js" type="text/javascript"></script>
        <script>hljs.initHighlightingOnLoad($(".html"));</script>
    </head>
    <body>
        <pre><code class="html">
            <?php
//if (isset($_POST["link"]) && $_POST["link"] != "") {
            ini_set("allow_url_fopen", "On");
            // objet DOMDocument représente un document XML
            $doc = new DOMDocument();
            // si les messages d'erreur ne sont pas retirés ce code affiche un message Deprecated en raison de l'usage de HTTP au lieu d'HTTPS par le serveur de la CSSMI
            // si le serveur RSS de la CSSMI est accessible...
            if ($doc->loadHTMLFile("http://cfnt.qc.ca") !== false) {
                // le charger
                $doc->loadHTMLFile("http://cfnt.qc.ca");
                $doc->preserveWhiteSpace = FALSE;
                $html = $doc->saveHTML();
                $htmldoc = str_replace(">", "&gt;", str_replace("<", "&lt;", $html));
                echo $htmldoc;
            }
//}
            ?>
        </code></pre>
    </body>
</html>

