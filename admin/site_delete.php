<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
function access_denied() {
    header("Location: /admin/logout.php");
}
function erreur($msg){
    echo "<script>alert(\"$msg\")</script>";
}
session_start();
$now = time(); // Checking the time now when home page starts.
if ($now > $_SESSION['expire']) {
    access_denied();
}
$login = $_SESSION["login"];
if (!$login == "yes") {
    access_denied();
}
if (array_key_exists("sid", $_GET)) {
    if ($_GET["sid"] != "") {
        $odbc = odbc_connect("depweb", "user" ,"user");
        $result1 = odbc_exec($odbc, "SELECT id_site FROM sites_eleves ORDER BY id_site");
        $haver = false;
        // ceci permet de vérifier si la requete passé par GET est bien un nombre, sinon retourne une chaîne vide
        $id_site_delete = preg_replace("[^0-9]", "", $_GET["sid"]);
        if ($id_site_delete == "") {
            access_denied();
        }
        odbc_fetch_row($result1, 0);
        while (odbc_fetch_row($result1)) {
            $id_site = odbc_result($result1, "id_site");
            if ($id_site == $id_site_delete) {
                $result_delete = odbc_exec($odbc, "DELETE FROM sites_eleves WHERE id_site = $id_site_delete;") || error("Erreur lors de l'exécution du module com.cfnt.si.depweb.admin_site_delete. \n Problème d'interaction avec la base de données.");
                header('Status: 301 Moved Permanently', false, 301);
                header('Location: /panel_sites.php?delete=1');
            }
        }
    } else {
        access_denied();
    }
} else {
    access_denied();
}

