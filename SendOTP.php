<?php
session_start();

include 'DBconnection.php';

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['sendOTP']))
{
    $email = trim($_POST['email']);
    
    if (empty($email))
    {
        $_SESSION['message'] = "Please enter your email address.";
        $_SESSION['icon'] = "error";
        header("Location: ForgotPasswordForm.php");
        exit();
    }

        try
        {    
            $query = "SELECT User_ID, Username, Email
                    FROM users
                    WHERE Email = ?";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result))
            {

                $userId = $user['User_ID'];

                // Generate OTP
                $otp = rand(100000, 999999);

                // Expires in 5 minutes
                $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

                // Save OTP
                $insertQuery = "INSERT INTO password_reset_otp
                                (user_id, otp_code, expiry_time)
                                VALUES (?, ?, ?)";

                $insertStmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param(
                    $insertStmt,
                    "iss",
                    $userId,
                    $otp,
                    $expiry
                );

                mysqli_stmt_execute($insertStmt);

                try
                {
                    $mail = new PHPMailer(true);

                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;

                    // YOUR EMAIL
                    $mail->Username   = 'postdisasterreporting@gmail.com';

                    // YOUR APP PASSWORD
                    $mail->Password   = 'pzsp ibxw ieyf mrzv';

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom(
                        'postdisasterreporting@gmail.com',
                        'Post Disaster Reporting System'
                    );

                    $mail->addAddress($email);

                    $mail->isHTML(true);

                    $mail->Subject = 'Password Reset OTP - Post Disaster Reporting System';

                    $mail->Body = '
                    <div style="
                        max-width:600px;
                        margin:auto;
                        font-family:Arial,sans-serif;
                        border:1px solid #e5e5e5;
                        border-radius:10px;
                        overflow:hidden;
                    ">

                        <div style="
                            background:#2563eb;
                            color:white;
                            padding:20px;
                            text-align:center;
                        ">
                            <h2>Post Disaster Reporting System</h2>
                        </div>

                        <div style="padding:30px;">

                            <h3>Password Reset Request</h3>

                            <p>Hello '.$user['Username'].',</p>

                            <p>
                                We received a request to reset your password.
                                Use the OTP below to continue.
                            </p>

                            <div style="
                                background:#f4f7fc;
                                border:2px dashed #2563eb;
                                padding:20px;
                                text-align:center;
                                margin:25px 0;
                            ">
                                <h1 style="
                                    margin:0;
                                    letter-spacing:8px;
                                    color:#2563eb;
                                ">
                                    '.$otp.'
                                </h1>
                            </div>

                            <p>
                                This OTP will expire in <b>5 minutes</b>.
                            </p>

                            <p>
                                If you did not request a password reset,
                                please ignore this email.
                            </p>

                            <hr>

                            <small style="color:gray;">
                                This is an automated email from the
                                Post Disaster Reporting System.
                            </small>

                        </div>

                    </div>';

                    $mail->send();

                    $_SESSION['reset_user_id'] = $userId;
                    $_SESSION['reset_email'] = $email;

                    $_SESSION['message'] = 'OTP sent successfully';
                    $_SESSION['icon'] = 'success';

                    header("Location: VerifyOTPForm.php");
                    exit();
                }
                catch (Exception $e)
                {
                    $_SESSION['message'] = 'Failed to send OTP';
                    $_SESSION['icon'] = 'error';

                    header("Location: ForgotPasswordForm.php");
                    exit();
                }
            }
            else
            {
                $_SESSION['message'] = 'Email address not found';
                $_SESSION['icon'] = 'error';
                header("Location: ForgotPasswordForm.php");
                exit();
            }
        }
        catch(Exception $e)
        {
            $_SESSION['message'] = "System exception: " . $e->getMessage();
            header("Location: Error.php");
            exit();
        }
        finally
        {
            if(isset($stmt) && $stmt !== false) {
                mysqli_stmt_close($stmt);
            }
            mysqli_close($con);
        }
}
?>