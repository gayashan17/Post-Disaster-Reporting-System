<?php

session_start();

include "DBconnection.php";
include "classes/Notification.php";

$data = json_decode(file_get_contents("php://input"), true);

$notificationIDs = $data['notificationIDs'] ?? [];

try
{
    Notification::isReadNotification($con, $notificationIDs);

    echo "success";
}
catch(Exception $e)
{
    echo "error";
}