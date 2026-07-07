<?php
    session_start();
    include 'DBconnection.php';

    if(isset($_POST['login']))
    {
        $username = $_POST['username-input'];
        $password = $_POST['password-input'];
        $rem = isset($_POST['rememberMe']);

        try
        {
            $query = "SELECT User_ID, Username, Password, Role_ID, Email, Gender FROM users WHERE username = ?";

            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result))
            {
                if(password_verify($password, $row['Password']))
                {
                    $_SESSION['user_Id']  = $row['User_ID'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['role_Id']  = $row['Role_ID'];
                    $_SESSION['email']    = $row['Email'];
                    $_SESSION['gender']   = $row['Gender'];


                    switch ($row['Role_ID'])
                    {
                        case 1:
                            header("Location: AdmindashboardForm.php");
                            exit();
                        case 2:
                            header("Location: DMOdashboardForm.php");
                            exit();
                        case 3:
                            header("Location: dashboardForm.php");
                            exit();
                        case 4:
                            header("Location: LAOdashboardForm.php");
                            exit();
                        case 5:
                            header("Location: DSdashboardForm.php");
                            exit();
                        case 6:
                            header("Location: FOdashboardForm.php");
                            exit();
                        default:
                            $_SESSION['message'] = "Invalid user role";
                            header("Location: Error.php");
                            exit();
                    }
                }
                else
                {
                   $_SESSION['message'] = "Password Incorrect";
                    $_SESSION['icon'] = "error";
                    header("Location: LoginForm.php");
                    exit();
                }
            }
            else
            {
                $_SESSION['message'] = "Username Invalid";
                $_SESSION['icon'] = "error";
                header("Location: LoginForm.php");
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