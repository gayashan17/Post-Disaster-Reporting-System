<?php
    if (session_status() === PHP_SESSION_NONE) // to fix session already started error
    {
        session_start();
    }

    include_once __DIR__ . '/classes/User.php';

    if(isset($_SESSION['username']))
    {
        if(isset($_SESSION['user_Id']) || $_SESSION['user_Id'] != null)
        {
            $userId = $_SESSION['user_Id'];
        }
        else
        {
            die("unauthorized");
        }
        $roleId = $_SESSION['role_Id'];
        $username = $_SESSION['username'];
        $gender = $_SESSION['gender'];
        $email = $_SESSION['email'];

        // --- Profile picture, now that $userId is available ---
        $userForPic = new User();
        $profilePicResult = $userForPic->getUserProfilePicture($userId);
        $profilePicFile = (is_array($profilePicResult) && isset($profilePicResult['success']) && $profilePicResult['success'] === false)
            ? null
            : $profilePicResult;

        if(isset($_SESSION['role_Id']))
        {
            switch($roleId)
            {
                case 1:
                $role = "Admin";
                break;

                case 2:
                $role = "Disaster Management Officer";
                break;

                case 3:
                $role = "Citizen";
                break;

                case 4:
                $role = "Local Authority Officer";
                break;

                case 5:
                $role= "District Secretary";
                break;

                case 6:
                $role= "Finance Officer";
                break;
            }
        }
        else
        {
            header('Location:LoginForm.php');
            die();

        }
    }
    else
    {
         header("Location:LoginForm.php") ;
         exit();
    }
?>