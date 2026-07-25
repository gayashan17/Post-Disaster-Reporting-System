<?php
session_start();

ob_start();

require_once 'classes/Notification.php';
include 'userData.php';
include 'DBconnection.php';
ob_clean();
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['notification_ids']) && is_array($input['notification_ids'])) {
    try {
        $notificationIDs = $input['notification_ids'];

        $success = Notification::isReadNotification($con, $notificationIDs);

        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Could not update records']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input array']);
}
exit;