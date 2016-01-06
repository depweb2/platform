<?php if(isset($_GET['uploadprogress']))
{
    session_start();
    echo json_encode($_SESSION[ ini_get("session.upload_progress.prefix") . '123' ]);
 
    exit;
}
