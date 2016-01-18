<?php
require("verify_login.php");
if ($IS_LOGGED_IN) {
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
        } else {
            $uploadOk = 0;
        }
    } else {
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        header("Location: /panel_cours.php?notpdf=1&cid=$idc");
        die();
// if everything is ok, try to upload file
    } else {
        // Check if file already exists
        if (file_exists($target)) {
            if (!unlink($target)) {
                header("Location: /panel_cours.php?uploaderror=1&cid=$idc");
                die();
            } else {
                if (move_uploaded_file($_FILES["plan"]["tmp_name"], $target)) {
                    header("Location: /panel_cours.php?update=1");
                    die();
                } else {
                    header("Location: /panel_cours.php?uploaderror=1&cid=$idc");
                    die();
                }
            }
        }
    }
}