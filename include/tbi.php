<a href="javascript:void(0)" onclick="gototop()" title="Haut de la page" class="w3-animate-bottom w3-card-2 short top w3-btn-floating-large w3-theme-dark">
    <img src="images/ic_expand_less_white_18dp.png" alt=""/>
</a>
<!--<a title="Cours" href="#sidebar" onclick="w3_open();" class="w3-animate-bottom w3-card-2 cor short w3-btn-floating-large w3-theme-dark">
    <img src="images/ic_folder_white_18dp.png" alt=""/>
</a>-->
<a href="javascript:w3_crop()" title="Étirer ou étendre le contenu" class="w3-animate-bottom w3-card-2 w3-btn-floating-large short crp w3-theme-dark">
    <img src="images/ic_swap_horiz_white_18dp.png" alt=""/>
</a>
<!--<a title="Enseignants" href="#teachers" onclick="load_teachers();" class="w3-btn-floating-large short w3-animate-bottom ts w3-theme-dark w3-card-2">
    <img src="images/ic_group_white_18dp.png" alt=""/>
</a>-->
<a title="Menu" href="javascript:w3_menu_toggle_shortcut()" class="w3-btn-floating-large short more w3-theme-dark w3-card-2 w3-animate-bottom">
    <img src="images/ic_menu_white_18dp.png" alt=""/>
</a>
<!--<a title="Autres liens" href="javascript:w3_menu_toggle_shortcut()" class="w3-btn-floating-large short more w3-theme-dark w3-card-2 w3-animate-bottom">
    <img src="images/ic_more_vert_white_18dp.png" alt=""/>
</a>-->
<a title="Fermer le menu" href="javascript:w3_toggle()" class="w3-animate-bottom w3-btn-floating-large short sideclose w3-theme-dark w3-card-2">
    <img src="images/ic_close_white_18dp.png" alt=""/>
</a>
<div class="blockUI"></div>
<div id="dropmore2" class="nav shortcut dropnav w3-theme-d3 w3-card-4 w3-topnav">
    <a href="/" class="nav-home nav-element" title="Accueil de dep.web">
        Accueil
    </a>
    <a class='nav-element nav-courses' title="Liste des cours et programmes, plans de cours, notes de cours, etc." href="javascript:w3_toggle()">Modules</a>
    <a class='nav-element nav-teachers' title="Liste des enseignants et informations de contact" href="#teachers">Profs</a>
    <?php
    require("./include/more_links.php");
    ?>
</div>
