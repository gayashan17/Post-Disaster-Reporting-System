<?php
// ================================================================
//   FOPaymentHistory.php  -  Backend AJAX handler (Part 3)
//   Handles: Paid compensation reports list for this officer
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
        // LIST: All Paid compensation reports for this officer
        // ------------------------------------------------------
        case 'list':
        {
            $reports = $financialOfficer->getPaidCompensationReports($con, $financialOfficerUserID);
            foSendResponse(true, '', $reports);
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
