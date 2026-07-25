<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/Citizen.php';

// --- Auth Check -------------------------------------------------
if (!isset($_SESSION['username']) || !isset($_SESSION['user_Id']) || $_SESSION['user_Id'] == null) {
    header('Location: ../LoginForm.php');
    exit();
}

// --- Process Bank Details Submission -----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_bank_details'])) {

    include '../DBconnection.php';

    $userId                 = intval($_POST['citizenID'] ?? $_SESSION['user_Id']);
    $beneficiaryName        = trim($_POST['accountHolderName'] ?? '');
    $beneficiaryBank        = trim($_POST['bankName'] ?? '');
    $beneficiaryBankAccount = trim($_POST['accountNumber'] ?? '');

    // Server-side validation
    if (empty($beneficiaryName) || empty($beneficiaryBank) || empty($beneficiaryBankAccount)) {
        $_SESSION['flash_error'] = "All bank detail fields are required.";
        header("Location: CitizenprofileForm.php");
        exit();
    }

    try {
        $citizen = new Citizen();

        // Execute updateBankDetails with $con and positional arguments
        $success = $citizen->updateBankDetails(
            $con,
            $userId,
            $beneficiaryName,
            $beneficiaryBank,
            $beneficiaryBankAccount
        );

        if ($success) {
            $_SESSION['bankMessage'] = true;
            $_SESSION['flash_success'] = "Bank details updated successfully!";
        } else {
            $_SESSION['flash_error'] = "Failed to update bank details. Please try again.";
        }

    } catch (Exception $e) {
        $_SESSION['flash_error'] = "Error updating bank details: " . $e->getMessage();
    }

    mysqli_close($con);
    header("Location: CitizenprofileForm.php");
    exit();
} else {
    // If accessed directly without submitting the form
    header("Location: CitizenprofileForm.php");
    exit();
}