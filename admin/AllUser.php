<?php

require_once '../classes/Admin.php';

header('Content-Type: application/json');

try {

    $admin = new Admin();

    // Update status request
    if (isset($_POST['action']) && $_POST['action'] === 'updateStatus') {

        $userId = $_POST['user_id'] ?? 0;
        $status = $_POST['status'] ?? '';

        $result = $admin->updateUserStatus($userId, $status);

        echo json_encode($result);
        exit;
    }

    // View UserData
    if (isset($_POST['action']) && $_POST['action'] === 'viewUser') {

        $userId = $_POST['user_id'];

        $result = $admin->getUserById($userId);

        echo json_encode($result);
        exit;
    }

    $result = $admin->getAllUsers();

    echo json_encode($result);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}

?>