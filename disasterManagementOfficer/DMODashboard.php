<?php

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/DisasterManagementOfficer.php';

function dsSendResponse($success, $message = '', $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data
    ]);
    exit();
}

// ---- Auth check (District Secretary only, Role_ID = 5) ----
if (!isset($_SESSION['user_Id']) || !isset($_SESSION['role_Id']) || $_SESSION['role_Id'] != 2)
{
    dsSendResponse(false, 'Unauthorized access.');
}

$districtSecretaryUserID = $_SESSION['user_Id'];
$DisasterManagementOfficer = new DisasterManagementOfficer();

$action = $_REQUEST['action'] ?? '';

try
{
    switch ($action)
    {
        // ------------------------------------------------------
        // STATS: Dashboard summary statistics
        // ------------------------------------------------------
        case 'stats':
        {
            $stats = $DisasterManagementOfficer->getDSDashboardStats($con, $districtSecretaryUserID);
            dsSendResponse(true, '', $stats);
            break;
        }

        default:
        {
            dsSendResponse(false, 'Unknown action requested.');
        }
    }
}
catch (Exception $e)
{
    dsSendResponse(false, $e->getMessage());
}
