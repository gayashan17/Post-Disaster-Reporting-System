<?php
// ================================================================
//   DMOVerifyReports.php  -  Backend AJAX handler
//   Handles: LAO Approved reports list, full details, approve, reject
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/DisasterManagementOfficer.php';
include_once '../classes/Notification.php';

function dmoSendResponse($success, $message = '', $data = null)
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
        // LIST: All LAO Approved reports awaiting DMO verification
        // ------------------------------------------------------
        case 'list':
        {
            $reports = $dmo->getLAOApprovedReports($con, $dmoUserID);
            dmoSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // DETAILS: Full details + type-specific data + evidence files
        // ------------------------------------------------------
        case 'details':
        {
            $reportID = isset($_GET['report_id']) ? (int) $_GET['report_id'] : 0;

            if ($reportID <= 0)
            {
                dmoSendResponse(false, 'Invalid Report ID.');
            }

            $details       = $dmo->getLAOApprovedReportDetails($con, $reportID);
            $typeDetails   = $dmo->getReportTypeDetails($con, $reportID, $details['Report_Type']);
            $evidenceFiles = $dmo->getEvidenceFilesByReportID($con, $reportID);

            dmoSendResponse(true, '', [
                'report'          => $details,
                'type_details'    => $typeDetails,
                'evidence_files'  => $evidenceFiles
            ]);
            break;
        }

        // ------------------------------------------------------
        // APPROVE: Create verified verification report + move to DMO Approved
        // ------------------------------------------------------
        case 'approve':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                dmoSendResponse(false, 'Invalid request method.');
            }

            $reportID       = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
            $approvedAmount = isset($_POST['approved_amount']) ? (float) $_POST['approved_amount'] : 0;
            $description    = isset($_POST['description']) ? trim($_POST['description']) : '';

            if ($reportID <= 0)
            {
                dmoSendResponse(false, 'Invalid Report ID.');
            }
            if ($approvedAmount <= 0)
            {
                dmoSendResponse(false, 'Approved amount must be greater than zero.');
            }
            if ($description === '')
            {
                dmoSendResponse(false, 'Description is required.');
            }

            // 1. Get Citizen User ID first
            $citizenUserID = getCitizenUserIdByReportId($con, $reportID);

            if (!$citizenUserID)
            {
                dmoSendResponse(false, 'Unable to find citizen linked to this report.');
            }

            // 2. Perform DB updates
            $dmo->addVerifiedVerificationReport(
                $con,
                $reportID,
                $dmoUserID,
                $description,
                $approvedAmount
            );
            $dmo->updateReportStatusToDMOApproved($con, $reportID);

            // 3. Send Notification with all 6 parameters
            Notification::createCitizenNotification(
                $con,
                $citizenUserID,
                $reportID,
                "Report Approval",
                "Your Report Has Been Approved By Disaster Management Officer",
                "DMO Approval"
            );

            dmoSendResponse(true, 'Report has been approved successfully.');
            break;
        }

        // ------------------------------------------------------
        // REJECT: Create rejected verification report + move to DMO Rejected
        // ------------------------------------------------------
        case 'reject':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                dmoSendResponse(false, 'Invalid request method.');
            }

            $reportID    = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';

            if ($reportID <= 0)
            {
                dmoSendResponse(false, 'Invalid Report ID.');
            }
            if ($description === '')
            {
                dmoSendResponse(false, 'A reason for rejection is required.');
            }

            // 1. Get Citizen User ID first
            $citizenUserID = getCitizenUserIdByReportId($con, $reportID);

            if (!$citizenUserID)
            {
                dmoSendResponse(false, 'Unable to find citizen linked to this report.');
            }

            // 2. Perform DB updates
            $dmo->addRejectedVerificationReport(
                $con,
                $reportID,
                $dmoUserID,
                $description
            );
            $dmo->updateReportStatusToDMORejected($con, $reportID);

            // 3. Send Notification with all 6 parameters
            Notification::createCitizenNotification(
                $con,
                $citizenUserID,
                $reportID,
                "Report Rejection",
                "Your Report Has Been Rejected By Disaster Management Officer",
                "DMO Rejection"
            );

            dmoSendResponse(true, 'Report has been rejected.');
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