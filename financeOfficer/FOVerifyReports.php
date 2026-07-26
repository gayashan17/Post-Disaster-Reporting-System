<?php
// ================================================================
//   FOVerifyReports.php  -  Backend AJAX handler (Part 1)
//   Handles: DS Approved reports list, report details, process
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/FinancialOfficer.php';
include_once '../classes/Notification.php';

function foSendResponse($success, $message = '', $data = null)
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data
    ]);
    exit();
}

// Helper function to fetch Citizen User_ID for notifications
function getCitizenUserIdByReportId($con, $reportID)
{
    $getUserQuery = "SELECT User_ID FROM disaster_report WHERE Report_ID = ?";
    if ($stmtUser = mysqli_prepare($con, $getUserQuery))
    {
        mysqli_stmt_bind_param($stmtUser, "i", $reportID);
        mysqli_stmt_execute($stmtUser);
        $userResult = mysqli_stmt_get_result($stmtUser);

        if ($userRow = mysqli_fetch_assoc($userResult))
        {
            mysqli_stmt_close($stmtUser);
            return (int) $userRow['User_ID'];
        }
        mysqli_stmt_close($stmtUser);
    }
    return null;
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
        // LIST: All DS Approved reports
        // ------------------------------------------------------
        case 'list':
        {
            $reports = $financialOfficer->getDSApprovedReports($con);
            foSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // DETAILS: Full details of a single report
        // ------------------------------------------------------
        case 'details':
        {
            $reportID = isset($_GET['report_id']) ? (int) $_GET['report_id'] : 0;

            if ($reportID <= 0)
            {
                foSendResponse(false, 'Invalid Report ID.');
            }

            $details = $financialOfficer->getDSApprovedReportDetails($con, $reportID);
            foSendResponse(true, '', $details);
            break;
        }

        // ------------------------------------------------------
        // PROCESS: Create compensation report + move to FO Pending
        // ------------------------------------------------------
        case 'process':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                foSendResponse(false, 'Invalid request method.');
            }

            $reportID = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;

            if ($reportID <= 0)
            {
                foSendResponse(false, 'Invalid Report ID.');
            }

            // 1. Get Citizen User ID first
            $citizenUserID = getCitizenUserIdByReportId($con, $reportID);

            if (!$citizenUserID)
            {
                foSendResponse(false, 'Unable to find citizen linked to this report.');
            }

            // 2. Perform DB updates
            $financialOfficer->addCompensationReport($con, $reportID, $financialOfficerUserID);
            $financialOfficer->updateReportStatusToFOPending($con, $reportID);

            // 3. Send Notification with all 6 parameters
            Notification::createCitizenNotification(
                $con,
                $citizenUserID,
                $reportID,
                "Compensation Processing",
                "Your Compensation Claim Is Now Being Processed By Financial Officer",
                "FO Processing"
            );

            foSendResponse(true, 'Report has been moved to processing successfully.');
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