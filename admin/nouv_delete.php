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
if (array_key_exists("nid", $_GET)) {
    if ($_GET["nid"] != "") {
        $odbc = odbc_connect("depweb", "user" ,"user");
        $result1 = odbc_exec($odbc, "SELECT id_nouv FROM nouvelles ORDER BY id_nouv");
        $haver = false;
        // ceci permet de vérifier si la requete passé par GET est bien un nombre, sinon retourne une chaîne vide
        $id_nouv_delete = preg_replace("[^0-9]", "", $_GET["nid"]);
        if ($id_nouv_delete == "") {
            access_denied();
        }
        odbc_fetch_row($result1, 0);
        while (odbc_fetch_row($result1)) {
            $id_nouv = odbc_result($result1, "id_nouv");
            if ($id_nouv == $id_nouv_delete) {
                $result_delete = odbc_exec($odbc, "DELETE FROM nouvelles WHERE id_nouv = $id_nouv_delete;") || error("Erreur lors de l'exécution du module com.cfnt.si.depweb.admin_site_delete. \n Problème d'interaction avec la base de données.");
                header('Status: 301 Moved Permanently', false, 301);
                header('Location: /panel_nouvelles.php?delete=1');
                }
        }
    } else {
        access_denied();
    }
} else {
    access_denied();
}

