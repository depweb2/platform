<?php

header('Cache-Control: no-cache, no-store, must-revalidate');

function access_denied() {
    header("Location: /admin/logout.php");
}

function erreur($msg) {
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

function appostrophe($chaine) {
    //double les appostrophes pour les chaines de caractères   
    $chaine = str_replace("'", "''", $chaine);
    return $chaine;
}

$odbc = odbc_connect("depweb", "user", "user");
$cours = $_POST["cours"];
$dir_doc = "";
if (isset($_FILES["doc"]) && basename($_FILES["doc"]["name"]) != "") {
    $nidc = odbc_result(odbc_exec($odbc, "SELECT nid_cours FROM cours WHERE id_cours=$cours;"), "nid_cours");
    $target_dir = "../var/docs/documents_notes/cours/$nidc/";
    if (isset($_POST["dir_doc2"]) && $_POST["dir_doc2"] != "") {
        $target_name = $_POST["dir_doc2"];
    } else {
        $target_name = basename($_FILES["doc"]["name"]);
        if ($target_name == "") {
            header("Location: /panel_documents.php?missing=1");
            die();
        }
    }
    $target_file = "$target_dir" . "$target_name";
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    if (isset($_POST["submit"])) {
        $check = $_FILES["doc"]["tmp_name"];
        if ($check) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        header("Location: /panel_documents.php?filealreadyexists=1");
        die();
        $uploadOk = 0;
    }
// Check file size
    if ($_FILES["doc"]["size"] > 10000000) {
        header("Location: /panel_documents.php?filetoolarge=1");
        die();
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: /panel_documents.php?missing=1");
        die();
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["doc"]["tmp_name"], utf8_decode($target_file))) {
            $dir_doc = utf8_decode(appostrophe($target_name));
        } else {
            header("Location: /panel_documents.php?uploaderror=1");
            die();
        }
    }
} else {
    if (isset($_POST["dir_doc2"])) {
        $dir_doc = utf8_decode(appostrophe($_POST["dir_doc2"]));
        if ($dir_doc == "") {
            header("Location: /panel_documents.php?missing=1");
        }
    } else {
        $dir_doc = utf8_decode(appostrophe($_POST["dir_doc"]));
        if ($dir_doc == "") {
            header("Location: /panel_documents.php?missing=1");
        }
    }
}
$nom_doc = utf8_decode(appostrophe($_POST["nom_doc"]));
$type_doc = $_POST["type"];
odbc_exec($odbc, "INSERT INTO documents(nom_doc, type_doc, cours, dir_doc)values ('$nom_doc', $type_doc , $cours, '$dir_doc')");
header("Location: /panel_documents.php?add=1");

