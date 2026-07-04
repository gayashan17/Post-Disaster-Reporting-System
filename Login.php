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
            $query = "SELECT User_ID,Username,Password,Role_ID,Email,Gender From users WHERE username=?";

            $stmt = mysqli_prepare($con,$query);
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result))
            {
                if(password_verify($password,$row['Password']))
                {
                    $_SESSION['user_Id'] =$row['User_ID'];
                    $_SESSION['username'] =$row['Username'];
                    $_SESSION['role_Id'] =$row['Role_ID'];
                    $_SESSION['email'] =$row['Email'];
                    $_SESSION['gender'] =$row['Gender'];

                    if($row['Role_ID'] == 3)
                    {
                        header("Location:dashboardForm.php");
                        exit();
                    }
                    else if($row['Role_ID'] == 2)
                    {
                        header("Location:DMOdashboardForm.php");
                        exit();
                    }
                    else if($row['Role_ID'] == 4)
                    {
                        header("Location:LAOdashboardForm.php");
                        exit();
                    }
                    else
                    {
                        $_SESSION['message'] = "Invalid user role";
                        header("Location:Error.php");
                        die("Invalid user role");
                    }
                }
                else
                {
                    $_SESSION['message'] = "Wrong Password!";
                    header("Location:Error.php");
                    die("Wrong Password!");
                }
            }
            else
            {
                $_SESSION['message'] = "Invalid Username";
                header("Location:Error.php");
                die("Invalid Username");
            }
        }
        catch(Exception $e)
        {
            header("Location:Error.php");
            die("this");
        }
        finally
        {
            mysqli_close($con);
        }
    }








?>