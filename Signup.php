<?php
session_start();

include 'DBconnection.php';
include 'classes/Users.php'; // File containing User and Citizen classes

if(isset($_POST['register']))
{
    $username = $_POST['username-input'];
    $fullname = $_POST['fullname-input'];
    $nic = $_POST['nic-input'];
    $address = $_POST['address-input'];
    $phoneNo = $_POST['phoneNo-input'];
    $email = $_POST['email-input'];
    $password = $_POST['password-input'];
    $confPassword = $_POST['confPassword-input'];
    $gender = $_POST['gender-input'];

    if($password != $confPassword)
    {
        die("Passwords do not match!");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try
    {
        $citizen = new Citizen();

        $citizen->setUserName($username);
        $citizen->setPassword($hashedPassword);
        $citizen->setFullName($fullname);
        $citizen->setGender($gender);
        $citizen->setNIC($nic);
        $citizen->setEmail($email);
        $citizen->setPhoneNo($phoneNo);
        $citizen->setAddress($address);
        $citizen->setRoleID(3);

        ////// check duplicakte email.....

        if($citizen->emailExists($con, $email))
        {
            throw new Exception("This email address is already registered.");
        }

        
        $userID = $citizen->addUser($con);

        if(!$userID)
        {
            throw new Exception("User registration failed.");
        }

        if(!$citizen->addCitizen($con))
        {
            throw new Exception("Citizen record creation failed.");
        }

        $_SESSION['message'] = "Registration Successful!";
        $_SESSION['icon'] = "success";

        header("Location: LoginForm.php");
        exit();
    }
    catch(Exception $e)
    {
        $_SESSION['message'] = $e->getMessage();

        header("Location: SignupForm.php");
        exit();
    }
    finally
    {
        mysqli_close($con);
    }
}
?>