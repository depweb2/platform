<?php
header('Cache-Control: no-cache, no-store, must-revalidate');

function access_denied() {
    header("Location: /admin/logout.php");
    exit();
}

function erreur($msg) {
    echo "<script>alert(\"$msg\")</script>";
}

function verify_login() {
    session_start();
    $login = $_SESSION["login"];
    if (!$login) {
        access_denied();
        return false;
    }
    $now = time(); // Checking the time now when home page starts.
    if ($now > $_SESSION['expire']) {
        access_denied();
        return false;
    } else {
        $_SESSION['start'] = time(); // Taking now logged in time.
        // Ending a session in 60 minutes from the starting time.
        $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
        return true;
    }
}

$IS_LOGGED_IN = verify_login();
