<?php
// ================================================================
//   DMODashboard.php  -  Backend AJAX handler
//   Handles: Dashboard summary statistics for Disaster Management Officer
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/DisasterManagementOfficer.php';

function dmoSendResponse($success, $message = '', $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data
    ]);
    exit();
}

// ---- Auth check (Disaster Management Officer only, Role_ID = 2) ----
if (!isset($_SESSION['user_Id']) || !isset($_SESSION['role_Id']) || $_SESSION['role_Id'] != 2)
{
    dmoSendResponse(false, 'Unauthorized access.');
}

$dmoUserID = $_SESSION['user_Id'];
$dmo = new DisasterManagementOfficer();

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
            $stats = $dmo->getDMODashboardStats($con, $dmoUserID);
            dmoSendResponse(true, '', $stats);
            break;
        }

        default:
        {
            dmoSendResponse(false, 'Unknown action requested.');
        }
    }
}
catch (Exception $e)
{
    dmoSendResponse(false, $e->getMessage());
}
