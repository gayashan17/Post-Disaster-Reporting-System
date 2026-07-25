<?php
// ================================================================
//   DSDashboard.php  -  Backend AJAX handler (Part 4)
//   Handles: Dashboard summary statistics for District Secretary
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/DistrictSecretary.php';

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
if (!isset($_SESSION['user_Id']) || !isset($_SESSION['role_Id']) || $_SESSION['role_Id'] != 5)
{
    dsSendResponse(false, 'Unauthorized access.');
}

$districtSecretaryUserID = $_SESSION['user_Id'];
$districtSecretary = new DistrictSecretary();

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
            $stats = $districtSecretary->getDSDashboardStats($con, $districtSecretaryUserID);
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
