<?php

require("verify_login.php");
if ($IS_LOGGED_IN) {
    require("../include/image_upload.php");

    function appostrophe($chaine) {
        //double les appostrophes pour les chaines de caractères   
        $chaine = str_replace("'", "''", $chaine);
        return $chaine;
    }

    $prenom = utf8_decode(appostrophe($_POST["prenom"]));
    $nom = utf8_decode(appostrophe($_POST["nom"]));
    $email = utf8_decode(appostrophe($_POST["email"]));
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (isset($_POST["perm_email"])) {
            $perm = 1;
        } else {
            $perm = 0;
        }
        $odbc = odbc_connect("depweb", "user", "user");
        $dir_photo = "";
        if (isset($_FILES["photo"]) && basename($_FILES["photo"]["name"]) != "") {
            $target_dir = "../images/profs/";
            $target_name = basename($_FILES["photo"]["name"]);
            if ($target_name == "") {
                header("Location: /panel_profs.php?uploaderror=1");
                die();
            }
            $target_file = "$target_dir" . "$target_name";
            $uploadOk = 1;
            if (isset($_POST["submit"])) {
                $check = $_FILES["photo"]["tmp_name"];
                if ($check) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }
// Check if file already exists
            if (file_exists($target_file)) {
                unlink($target_file);
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                header("Location: /panel_profs.php?uploaderror=1");
                die();
// if everything is ok, try to upload file
            } else {
                if (process_image_upload("photo")) {
                    $dir_photo = utf8_decode(appostrophe($target_name));
                } else {
                    header("Location: /panel_profs.php?uploaderror=1");
                    die();
                }
            }
        } else {
            $dir_photo = "nobody.jpg";
        }
        odbc_exec($odbc, "INSERT INTO enseignants(prenom_enseignant, nom_enseignant, email_enseignant, perm_email, photo_url)values ('$prenom', '$nom' , '$email', '$perm', '$dir_photo')");
        header("Location: /panel_profs.php?add=1");
    }else{
        header("Location: /panel_profs.php?uploaderror=1");
    }
}
