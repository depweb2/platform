<!DOCTYPE html>
<html>
    <head>
        <title>dep.web</title>
        <?php
            require("./include/styles.php");
            require("./include/scripts.php");
        ?>
    </head>
    <body>
        <?php
            require("./include/fallback.php");
        ?>
        <div id="compatible">
            <?php
            require('./include/prerequisites.php');
            ?>
            <main id="main">
            </main>
        </div>
    </body>
</html>