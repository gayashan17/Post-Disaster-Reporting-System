<?php
session_start();

require_once '../DBconnection.php';
require_once '../classes/User.php';
require_once '../classes/Citizen.php';

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

        if($citizen->emailExists($con, $email))
        {
           throw new Exception("Email already exists!");
        }

        $citizen->setUserName($username);
        $citizen->setPassword($hashedPassword);
        $citizen->setFullName($fullname);
        $citizen->setGender($gender);
        $citizen->setNIC($nic);
        $citizen->setEmail($email);
        $citizen->setPhoneNo($phoneNo);
        $citizen->setAddress($address);
        $citizen->setRoleID(3);

        // Insert into Users table
        $userID = $citizen->addUser($con);

        if(!$userID)
        {
            throw new Exception("User registration failed.");
        }

        // Insert into Citizen table
        if(!$citizen->addCitizen($con))
        {
            throw new Exception("Citizen record creation failed.");
        }

        $_SESSION['message'] = "Registration Successful!";
        $_SESSION['icon'] = "success";

        header("Location: ../LoginForm.php");
        exit();
    }
    catch(Exception $e)
    {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['icon'] = "error";

        header("Location: SignupForm.php");
        exit();
    }
    finally
    {
        mysqli_close($con);
    }
}
?>