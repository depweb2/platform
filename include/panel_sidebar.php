<div class="sidebar-block panel-sidebar-block"></div>
<div id="sidebar" class="sideclosed w3-sidenav panel_sidebar w3-white">
    <header class='w3-container w3-white'>
        <h2 onclick="w3_toggle()" >
            <img class="icon30" src="/images/ic_arrow_back_black_18dp.png" alt=""/>
            Menu
        </h2>
    </header>
    <form name="verify_sites" method="post" hidden action="sites_eleves.php">
        <input type="hidden" name="verify" value="yes"/>
    </form>
    <div class="classes">
        <div class="classes-container">
            <ul class="w3-ul">
                <li><a href="/panel.php">Accueil administrateur</a></li>
                <li><a href='/panel_documents.php'>Documents de cours</a></li>
                <li><a href='/panel_cours.php'>Modules et stages</a></li>
                <li><a href='/panel_profs.php'>Enseignants</a></li>
                <li><a href='/panel_nouvelles.php'>Blogue de nouvelles</a></li>
                <li><a href='/panel_sites.php'>Sites Web des élèves</a></li>
                <li><a href="javascript:void(0)" onclick="verify_sites.submit()">Test des sites Web</a></li>
                <li><a href='/admin/logout.php'>Déconnexion</a></li>
            </ul>
        </div>
    </div>
</div>
<script>
    is_panel = true;
</script>