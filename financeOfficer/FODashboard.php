<?php
// ================================================================
//   FODashboard.php  -  Backend AJAX handler (Part 4)
//   Handles: Dashboard summary statistics for Financial Officer
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/FinancialOfficer.php';

function foSendResponse($success, $message = '', $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data
    ]);
    exit();
}

// ---- Auth check (Financial Officer only, Role_ID = 6) ----
if (!isset($_SESSION['user_Id']) || !isset($_SESSION['role_Id']) || $_SESSION['role_Id'] != 6)
{
    foSendResponse(false, 'Unauthorized access.');
}

$financialOfficerUserID = $_SESSION['user_Id'];
$financialOfficer = new FinancialOfficer();

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
            $stats = $financialOfficer->getFODashboardStats($con, $financialOfficerUserID);
            foSendResponse(true, '', $stats);
            break;
        }

        default:
        {
            foSendResponse(false, 'Unknown action requested.');
        }
    }
}
catch (Exception $e)
{
    foSendResponse(false, $e->getMessage());
}
