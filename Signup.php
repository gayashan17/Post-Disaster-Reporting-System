<?php
    session_start();
    include 'DBconnection.php';

    if(isset($_POST['register'])){
        $username = $_POST['username-input'];
        $fullname = $_POST['fullname-input'];
        $nic = $_POST['nic-input'];
        $address = $_POST['address-input'];
        $phoneNo = $_POST['phoneNo-input'];
        $email = $_POST['email-input'];
        $password = $_POST['password-input'];
        $confPassword = $_POST['confPassword-input'];
        $bday = $_POST['bDay-input'];
        $gender = $_POST['gender-input'];

        if ($password != $confPassword){die("Passwords does not match!");}

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try
        {
            $query = "INSERT INTO users (Username, Password, Full_name, Gender, NIC, Email, Phone_Number, Address)
                      VALUES (?,?,?,?,?,?,?,?)";

                    $stmt = mysqli_prepare($con, $query);

                    mysqli_stmt_bind_param($stmt,"ssssssss",$username,$hashedPassword,$fullname,$gender,$nic,$email,$phoneNo,$address);

                    $query_execute = mysqli_stmt_execute($stmt);

                    if($query_execute)
                    {
                        $_SESSION['message'] = "Registration Successful!";
                        header("Location: LoginForm.php");
                        die();
                    }
                    else
                    {
                        $_SESSION['message'] = "Registration failed!";
                        header("Location: SignupForm.php");
                        die();
                    }

        }
        catch(mysqli_sql_exception $e)
        {
            $_SESSION['message'] = "Database Connection failure";
            header("Location: Error.php");
            die();
        }
        finally
        {
            mysqli_close($con);
        }
    }
?>