<?php

require_once '../classes/Admin.php';

header('Content-Type: application/json');

try {

    $admin = new Admin();

    $result = $admin->getAllUsers();

    echo json_encode($result);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}

?>