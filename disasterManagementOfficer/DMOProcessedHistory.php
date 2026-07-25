<?php
// ================================================================
//   DSProcessedHistory.php  -  Backend AJAX handler (Part 3)
//   Handles: Approved list, Rejected list, details, process(reject->approve)
// ================================================================

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
        // LIST APPROVED
        // ------------------------------------------------------
        case 'list_approved':
        {
            $reports = $DisasterManagementOfficer->getDSVerifiedReports($con, $districtSecretaryUserID);
            dsSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // LIST REJECTED
        // ------------------------------------------------------
        case 'list_rejected':
        {
            $reports = $DisasterManagementOfficer->getDSRejectedReports($con, $districtSecretaryUserID);
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

            $details       = $DisasterManagementOfficer->getDSApprovedReportDetails($con, $reportID);
            $typeDetails   = $DisasterManagementOfficer->getReportTypeDetails($con, $reportID, $details['Report_Type']);
            $evidenceFiles = $DisasterManagementOfficer->getEvidenceFilesByReportID($con, $reportID);

            dsSendResponse(true, '', [
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

            $DisasterManagementOfficer->addVerifiedVerificationReport(
                $con,
                $reportID,
                $districtSecretaryUserID,
                $description,
                $approvedAmount
            );
            $DisasterManagementOfficer->updateReportStatusToDSApproved($con, $reportID);

            dsSendResponse(true, 'Report has been processed and approved successfully.');
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
