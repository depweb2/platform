<?php
session_start();
$_SESSION = array();
session_unset();
session_destroy();
header('Status: 301 Moved Permanently', false, 301);
header('Location: /index.php');
exit();

