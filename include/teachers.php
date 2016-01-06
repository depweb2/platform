<div id="teachers" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-animate-bottom">
            <header class="w3-container w3-theme">
                <a href="#" class="w3-closebtn">&times;</a>
                <h2>
                    <a class="nou arrow-link" href="#">
                        <img class="icon30" src="images/ic_arrow_back_white_18dp.png" alt=""/>
                        Enseignants
                    </a>                              
                </h2>
            </header>
            <div id="tc" class="w3-container w3-padding w3-modal-main-container">
                <?php
                    require("./include/teacherslist.php");
                ?>
            </div>
        </div>
    </div>
</div>
<!-- le fameux easter egg d'André Boutin :D -->
<div id="tcr" class="w3-modal">
    <div class="w3-modal-dialog">
        <div class="w3-modal-content w3-android-modal w3-padding-8">
            <div class="w3-container">
                <h2>Il y a un petit problème...</h2>
            </div>
            <div class='w3-container'>
                Cet enseignant ne désire pas recevoir de courriels. Vous devez le contacter en personne.
            </div>
            <footer class='w3-container w3-right-align w3-padding-8'>
                <a href="#teacher" class='w3-modal-button'>J'ai compris.</a>
            </footer>
        </div>
    </div>
</div>
