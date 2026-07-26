<?php
// ================================================================
//   DMOProcessedHistory.php  -  Backend AJAX handler
//   Handles: Approved list, Rejected list, details, process(reject->approve)
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
        // LIST APPROVED
        // ------------------------------------------------------
        case 'list_approved':
        {
            $reports = $dmo->getDMOVerifiedReports($con, $dmoUserID);
            dmoSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // LIST REJECTED
        // ------------------------------------------------------
        case 'list_rejected':
        {
            $reports = $dmo->getDMORejectedReports($con, $dmoUserID);
            dmoSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // DETAILS: Full details + type-specific data + evidence files
        // ------------------------------------------------------
        case 'details':
        {
            $reportID     = isset($_GET['report_id']) ? (int) $_GET['report_id'] : 0;
            $reportStatus = isset($_GET['status']) ? strtolower(trim($_GET['status'])) : 'approved';

            if ($reportID <= 0)
            {
                dmoSendResponse(false, 'Invalid Report ID.');
            }

            if ($reportStatus === 'rejected')
            {
                $details = $dmo->getDMORejectedReportForProcessing($con, $reportID);
            }
            elseif ($reportStatus === 'process')
            {
                // Re-approving a rejected report: pull the LAO's original
                // estimate (the DMO's own rejected record has a NULL amount).
                $details = $dmo->getDMORejectedReportForProcessing($con, $reportID);
            }
            else
            {
                $details = $dmo->getDMOApprovedReportDetails($con, $reportID);
            }

            $typeDetails   = $dmo->getReportTypeDetails($con, $reportID, $details['Report_Type']);
            $evidenceFiles = $dmo->getEvidenceFilesByReportID($con, $reportID);

            dmoSendResponse(true, '', [
                'report'         => $details,
                'type_details'   => $typeDetails,
                'evidence_files' => $evidenceFiles
            ]);
            break;
        }

        // ------------------------------------------------------
        // PROCESS (Rejected -> Approved): reuses the same approve logic
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

            $dmo->addVerifiedVerificationReport(
                $con,
                $reportID,
                $dmoUserID,
                $description,
                $approvedAmount
            );
            $dmo->updateReportStatusToDMOApproved($con, $reportID);

            dmoSendResponse(true, 'Report has been processed and approved successfully.');
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
