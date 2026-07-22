<?php
session_start();

include '../DBconnection.php';

if (!isset($_SESSION['otp_verified']) || !isset($_SESSION['reset_user_id']))
{
    header("Location: ForgotPasswordForm.php");
    exit();
}

    try
    {
        if (isset($_POST['resetPassword']))
        {
            $newPassword = trim($_POST['newPassword']);
            $confirmPassword = trim($_POST['confirmPassword']);

            // Empty validation
            if (empty($newPassword) || empty($confirmPassword))
            {
                $_SESSION['message'] = "All fields are required";
                $_SESSION['icon'] = "warning";

                header("Location: ResetPasswordForm.php");
                exit();
            }
            
            // Match validation
            if ($newPassword !== $confirmPassword)
            {
                $_SESSION['message'] = "Passwords do not match";
                $_SESSION['icon'] = "error";

                header("Location: ResetPasswordForm.php");
                exit();
            }

            $userId = $_SESSION['reset_user_id'];

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = "
                UPDATE users
                SET Password = ?
                WHERE User_ID = ?
            ";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param(
                $stmt,
                "si",
                $hashedPassword,
                $userId
            );

            if (mysqli_stmt_execute($stmt))
            {
                // Clear reset sessions
                unset($_SESSION['otp_verified']);
                unset($_SESSION['reset_user_id']);
                unset($_SESSION['reset_email']);

                $_SESSION['message'] = "Password Reset Successful";
                $_SESSION['icon'] = "success";

                header("Location: ../LoginForm.php");
                exit();
            }
            else
            {
                $_SESSION['message'] = "Failed to Reset Password";
                $_SESSION['icon'] = "error";

                header("Location: ResetPasswordForm.php");
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

?>
