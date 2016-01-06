<div id="topbar">
    <div class="topbar-inner">
        <div class="title w3-theme-d1">
            <?php
            // the April fool prank
            $pa = date_format(date_create("2016-04-01"), "m-d");
            $pan = date("m-d");
            if ($pa == $pan) {
                ?>
            <h1>deep.web<sub>&nbsp;2.0</sub></h1>
                <?php
            } else {
                ?>
            <h1>dep.web<sub>&nbsp;2.0</sub></h1>
                <?php
            }
            ?>
            <div class="datetime">
                <span id="time">
                    <h2>Chargement...</h2>
                </span>
            </div>
        </div>
        <nav class="nav w3-topnav">
            <a href="/" class="nav-home nav-element" title="Accueil de dep.web">
                Accueil
            </a>
            <a href="javascript:w3_toggle()" class="nav-courses nav-element" title="Liste des cours et programmes, plans de cours, notes de cours, etc.">
                Modules
            </a>
            <a class="nav-element nav-teachers" href="#teachers" title="Liste des enseignants et informations de contact">
                Profs
            </a>
            <a title="Autres liens" id="menumore" class="nav-more nav-element" href="javascript:w3_more_menu();">
                Plus
            </a>
            <div id="dropmore" class="dropnav w3-theme">
                <?php
                require("./include/more_links.php");
                ?>
            </div>
        </nav>
    </div>
</div>