<?php

session_start();

if(!isset($_SESSION['reset_email']))
{
    header("Location: ForgotPasswordForm.php");
    exit();
}

$_POST['email'] = $_SESSION['reset_email'];
$_POST['sendOTP'] = true;

include 'SendOTP.php';