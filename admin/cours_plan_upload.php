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
$nidc = $_POST["nidc"];
$idc = $_POST["idc"];
$source = basename($_FILES["plan"]["name"]);
$target = "../var/docs/plans_cours/$nidc.pdf";
$uploadOk = 1;
$imageFileType = pathinfo($source, PATHINFO_EXTENSION);
if ($imageFileType == "pdf") {
    if (isset($_POST["submit2"])) {
        $check = $_FILES["plan"]["tmp_name"];
        if ($check) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }else{
        $uploadOk = 0;
    }
}else{
    $uploadOk = 0;
}
// Check if file already exists
if (file_exists($target)) {
    if(!unlink($target)){
        header("Location: /panel_cours.php?uploaderror=1&cid=$idc");
        die();
    }
}
if ($uploadOk == 0) {
    header("Location: /panel_cours.php?notpdf=1&cid=$idc");
    die();
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["plan"]["tmp_name"], $target)) {
        header("Location: /panel_cours.php?update=1");
        die();
    } else {
        header("Location: /panel_cours.php?uploaderror=1&cid=$idc");
        die();
    }
}
