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
                      VALUES (:username, :password, :fullname, :gender, :nic, :email, :phoneNo, :address)";

                    $stmt = $conn->prepare($query);

                    $query_execute = $stmt->execute([
                        ':username' => $username,
                        ':password' => $hashedPassword,
                        ':fullname' => $fullname,
                        ':gender'   => $gender,
                        ':nic'      => $nic,
                        ':email'    => $email,
                        ':phoneNo'  => $phoneNo,
                        ':address'  => $address
                    ]);

                    if($query_execute)
                    {
                        $_SESSION['message'] = "Registration Successful!";
                        header("Location: Login.html");
                        die();
                    }
                    else
                    {
                        $_SESSION['message'] = "Registration failed!";
                        header("Location: Signup.html");
                        die();
                    }

        }
        catch(Exception $e)
        {
            header("Location:Error.html");
            die();
        }
    }
?>