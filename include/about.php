<div id="about" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-animate-bottom">
            <header class="w3-container w3-theme">
                <h2>                             
                    <a class="nou arrow-link" href="#">
                        À propos
                    </a>
                    <a class="w3-right w3-modal-confirm no-text w3-context-open" onclick="open_context('.about_sub')" href="javascript:void(0)">
                        <img src="images/ic_more_vert_white_18dp.png" alt="plus"/>
                    </a>
                </h2>
                <div class="about_sub w3-context right">
                    <a href="javascript:void(0)" onclick="showCredits()">
                        Licences open-source
                    </a>
                    <a target='_blank' href="https://github.com/depweb2/platform">
                        Voir le projet sur GitHub
                    </a>
                    <a href='#hotkeys'>
                        Accessibilité
                    </a>
                    <a href="#tca">
                        Console d'admirnistation
                    </a>
                    <a href='#'>
                        Fermer la fenêtre À propos
                    </a>
                    <a href='javascript:void(0)' onclick='window.close()'>
                        Quitter dep.web 2.0
                    </a>
                </div>
            </header>
            <div id="credits" class="w3-modal-main-container w3-container w3-padding-8">
                <?php
                require("./include/credits.php");
                ?>
            </div>
        </div>
    </div>
</div>
<div id="tca" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-android-modal w3-padding-8">
            <div class="w3-container">
                <h2 class="">
                    Attention!
                </h2>
            </div>
            <div class="w3-container w3-padding">
                <img class="w3-left w3-margin-right" src="images/profs/andre.JPG" alt=""/>
                <div class="w3-margin-left">L'accès à cette section est réservé exclusivement aux administrateurs. L'accès aux élèves y est défendu pour des raisons de sécurité.</div>
            </div>
            <footer class="w3-container w3-right-align w3-padding-8">
                <a href="/admin.php" class="w3-modal-button">
                    OK, j'ai compris
                </a>
                <a href="#" class="w3-modal-button">
                    Annuler
                </a>
            </footer>
        </div> 
    </div>
</div>
