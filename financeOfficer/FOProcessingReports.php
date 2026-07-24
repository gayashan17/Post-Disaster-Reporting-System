<?php
// ================================================================
//   FOProcessingReports.php  -  Backend AJAX handler (Part 2)
//   Handles: FO Pending reports list, report details, mark as paid
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
        // LIST: All FO Pending reports for this officer
        // ------------------------------------------------------
        case 'list':
        {
            $reports = $financialOfficer->getFOPendingReports($con, $financialOfficerUserID);
            foSendResponse(true, '', $reports);
            break;
        }

        // ------------------------------------------------------
        // DETAILS: Full details of a single report (view popup)
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
        // PAY: Mark compensation as paid (with receipt upload)
        // ------------------------------------------------------
        case 'pay':
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST')
            {
                foSendResponse(false, 'Invalid request method.');
            }

            $compensationID = isset($_POST['compensation_id']) ? (int) $_POST['compensation_id'] : 0;
            $reportID       = isset($_POST['report_id']) ? (int) $_POST['report_id'] : 0;
            $paidAmount     = isset($_POST['paid_amount']) ? (float) $_POST['paid_amount'] : 0;
            $description    = isset($_POST['description']) ? trim($_POST['description']) : '';

            if ($compensationID <= 0 || $reportID <= 0)
            {
                foSendResponse(false, 'Invalid Compensation ID or Report ID.');
            }

            if ($paidAmount <= 0)
            {
                foSendResponse(false, 'Paid amount must be greater than zero.');
            }

            if ($description === '')
            {
                foSendResponse(false, 'Description is required.');
            }

            if (!isset($_FILES['receipt_file']) || $_FILES['receipt_file']['error'] !== UPLOAD_ERR_OK)
            {
                foSendResponse(false, 'Receipt file is required.');
            }

            // ---- Validate file type (PDF / image only) ----
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            $originalName = $_FILES['receipt_file']['name'];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExtensions))
            {
                foSendResponse(false, 'Only PDF, JPG, JPEG, or PNG files are allowed.');
            }

            // ---- Build upload directory (absolute path on server) ----
            $uploadDirAbsolute = realpath(__DIR__ . '/..') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'Receipt';

            if (!is_dir($uploadDirAbsolute))
            {
                mkdir($uploadDirAbsolute, 0777, true);
            }

            // ---- Build filename: Compensation_ID + Report_ID + current name ----
            $sanitizedOriginalName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
            $newFileName = $compensationID . '_' . $reportID . '_' . time() . '_' . $sanitizedOriginalName . '.' . $ext;

            $destinationAbsolute = $uploadDirAbsolute . DIRECTORY_SEPARATOR . $newFileName;
            $destinationRelative = '../uploads/Receipt/' . $newFileName; // stored in DB

            if (!move_uploaded_file($_FILES['receipt_file']['tmp_name'], $destinationAbsolute))
            {
                foSendResponse(false, 'Failed to upload receipt file.');
            }

            // ---- Update DB ----
            $financialOfficer->markAsPaid($con, $compensationID, $paidAmount, $description, $destinationRelative);
            $financialOfficer->updateReportStatusToFOPaid($con, $reportID);

            foSendResponse(true, 'Payment has been processed successfully.');
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
