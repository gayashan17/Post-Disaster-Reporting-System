<?php
    session_start();

    if(isset($_SESSION['username']))
    {
        $userId = $_SESSION['user_Id'];
        $roleId = $_SESSION['role_Id'];
        $username = $_SESSION['username'];
        $gender = $_SESSION['gender'];
        $email = $_SESSION['email'];

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