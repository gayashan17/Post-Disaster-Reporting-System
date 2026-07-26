<?php
// ================================================================
//   DSVerifyReports.php  -  Backend AJAX handler (Part 1)
//   Handles: DMO Approved reports list, full details, approve, reject
// ================================================================

session_start();
header('Content-Type: application/json');

include_once '../DBconnection.php';
include_once '../classes/DistrictSecretary.php';
include_once '../classes/Notification.php';

function dsSendResponse($success, $message = '', $data = null)
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
        // LIST: All DMO Approved reports awaiting DS verification
        // ------------------------------------------------------
        case 'list':
        {
            $reports = $districtSecretary->getDMOApprovedReports($con, $districtSecretaryUserID);
            dsSendResponse(true, '', $reports);
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
                dsSendResponse(false, 'Invalid Report ID.');
            }

            $details       = $districtSecretary->getDMOApprovedReportDetails($con, $reportID);
            $typeDetails   = $districtSecretary->getReportTypeDetails($con, $reportID, $details['Report_Type']);
            $evidenceFiles = $districtSecretary->getEvidenceFilesByReportID($con, $reportID);

            dsSendResponse(true, '', [
                'report'         => $details,
                'type_details'   => $typeDetails,
                'evidence_files' => $evidenceFiles
            ]);
            break;
        }

        // ------------------------------------------------------
        // APPROVE: Create verified verification report + move to DS Approved
        // ------------------------------------------------------
        case 'approve':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                dsSendResponse(false, 'Invalid request method.');
            }

            $reportID       = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
            $approvedAmount = isset($_POST['approved_amount']) ? (float) $_POST['approved_amount'] : 0;
            $description    = isset($_POST['description']) ? trim($_POST['description']) : '';

            if ($reportID <= 0)
            {
                dsSendResponse(false, 'Invalid Report ID.');
            }
            if ($approvedAmount <= 0)
            {
                dsSendResponse(false, 'Approved amount must be greater than zero.');
            }
            if ($description === '')
            {
                dsSendResponse(false, 'Description is required.');
            }

            // 1. Get Citizen User ID first
            $citizenUserID = getCitizenUserIdByReportId($con, $reportID);

            if (!$citizenUserID)
            {
                dsSendResponse(false, 'Unable to find citizen linked to this report.');
            }

            // 2. Perform DB updates
            $districtSecretary->addVerifiedVerificationReport(
                $con,
                $reportID,
                $districtSecretaryUserID,
                $description,
                $approvedAmount
            );
            $districtSecretary->updateReportStatusToDSApproved($con, $reportID);

            // 3. Send Notification with all 6 parameters
            Notification::createCitizenNotification(
                $con,
                $citizenUserID,
                $reportID,
                "Report Approval",
                "Your Report Has Been Approved By District Secretary",
                "DS Approval"
            );

            dsSendResponse(true, 'Report has been approved successfully.');
            break;
        }

        // ------------------------------------------------------
        // REJECT: Create rejected verification report + move to DS Rejected
        // ------------------------------------------------------
        case 'reject':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                dsSendResponse(false, 'Invalid request method.');
            }

            $reportID    = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';

            if ($reportID <= 0)
            {
                dsSendResponse(false, 'Invalid Report ID.');
            }
            if ($description === '')
            {
                dsSendResponse(false, 'A reason for rejection is required.');
            }

            // 1. Get Citizen User ID first
            $citizenUserID = getCitizenUserIdByReportId($con, $reportID);

            if (!$citizenUserID)
            {
                dsSendResponse(false, 'Unable to find citizen linked to this report.');
            }

            // 2. Perform DB updates
            $districtSecretary->addRejectedVerificationReport(
                $con,
                $reportID,
                $districtSecretaryUserID,
                $description
            );
            $districtSecretary->updateReportStatusToDSRejected($con, $reportID);

            // 3. Send Notification with all 6 parameters
            Notification::createCitizenNotification(
                $con,
                $citizenUserID,
                $reportID,
                "Report Rejection",
                "Your Report Has Been Rejected By District Secretary",
                "DS Rejected"
            );

            dsSendResponse(true, 'Report has been rejected.');
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