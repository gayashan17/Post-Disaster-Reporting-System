<?php
session_start();

include '../DBconnection.php';
        try
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $otp = trim($_POST['otp']);

                if (empty($otp))
                {
                    $_SESSION['message'] = "Please enter your OTP.";
                    $_SESSION['icon'] = "error";
                    header("Location: VerifyOTPForm.php");
                    exit();
                }

                if(!isset($_SESSION['reset_user_id']))
                {
                    header("Location: ForgotPasswordForm.php");
                    exit();
                }

                $userId = $_SESSION['reset_user_id'];

                $query = "
                    SELECT otp_id,
                        otp_code,
                        expiry_time,
                        is_used
                    FROM password_reset_otp
                    WHERE user_id = ?
                    ORDER BY otp_id DESC
                    LIMIT 1
                ";

                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $userId);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);

                if($row = mysqli_fetch_assoc($result))
                {
                    // Check whether OTP already used
                    if($row['is_used'] == 1)
                    {
                        $_SESSION['message'] = 'OTP has already been used';
                        $_SESSION['icon'] = 'error';

                        header("Location: VerifyOTPForm.php");
                        exit();
                    }

                    // Check expiry
                    if(strtotime($row['expiry_time']) < time())
                    {
                        $_SESSION['message'] = 'OTP has expired';
                        $_SESSION['icon'] = 'error';

                        header("Location: VerifyOTPForm.php");
                        exit();
                    }

                    // Check OTP
                    if($otp == $row['otp_code'])
                    {
                        // Mark OTP as used
                        $updateQuery = "
                            UPDATE password_reset_otp
                            SET is_used = 1
                            WHERE otp_id = ?
                        ";

                        $updateStmt = mysqli_prepare($con, $updateQuery);
                        mysqli_stmt_bind_param(
                            $updateStmt,
                            "i",
                            $row['otp_id']
                        );

                        mysqli_stmt_execute($updateStmt);

                        $_SESSION['otp_verified'] = true;

                        $_SESSION['message'] = 'OTP verified successfully';
                        $_SESSION['icon'] = 'success';

                        header("Location: ResetPasswordForm.php");
                        exit();
                    }
                    else
                    {
                        $_SESSION['message'] = 'Invalid OTP';
                        $_SESSION['icon'] = 'error';

                        header("Location: VerifyOTPForm.php");
                        exit();
                    }
                }
                else
                {
                    $_SESSION['message'] = 'No OTP found';
                    $_SESSION['icon'] = 'error';

                    header("Location: ForgotPasswordForm.php");
                    exit();
                }

                mysqli_stmt_close($stmt);
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
mysqli_close($con);
?>