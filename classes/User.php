<?php

// ================================================================//
//                          USER CLASS                             //
// ================================================================//

class User  
{
    protected $userID;
    protected $userName;
    protected $password;
    protected $fullName;
    protected $gender;
    protected $NIC;
    protected $email;
    protected $phoneNo;
    protected $address;
    protected $roleID;

    //// Setters

    public function setUserID($userID) { $this->userID = $userID; }
    public function setUserName($userName) { $this->userName = $userName; }
    public function setPassword($password) { $this->password = $password; }
    public function setFullName($fullName) { $this->fullName = $fullName; }
    public function setGender($gender) { $this->gender = $gender; }
    public function setNIC($NIC) { $this->NIC = $NIC; }
    public function setEmail($email) { $this->email = $email; }
    public function setPhoneNo($phoneNo) { $this->phoneNo = $phoneNo; }
    public function setAddress($address) { $this->address = $address; }
    public function setRoleID($roleID) { $this->roleID = $roleID; }

    //// Getters

    public function getUserID() { return $this->userID; }
    public function getUserName() { return $this->userName; }
    public function getPassword() { return $this->password; }
    public function getFullName() { return $this->fullName; }
    public function getGender() { return $this->gender; }
    public function getNIC() { return $this->NIC; }
    public function getEmail() { return $this->email; }
    public function getPhoneNo() { return $this->phoneNo; }
    public function getAddress() { return $this->address; }
    public function getRoleID() { return $this->roleID; }

    ///// Insert data to USer table

    public function addUser($con)
    {
        try
        {
            $query = "INSERT INTO users
                    (Username, Password, Full_Name, Gender, NIC, Email, Phone_Number, Address, Role_ID)
                    VALUES (?,?,?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssi",
                $this->userName,
                $this->password,
                $this->fullName,
                $this->gender,
                $this->NIC,
                $this->email,
                $this->phoneNo,
                $this->address,
                $this->roleID
            );

            if(mysqli_stmt_execute($stmt))
            {
                $this->userID = mysqli_insert_id($con);
                return $this->userID;
            }

            return false;
        }
        catch(Exception $e)
        {
            throw new Exception("User registration failed: " . $e->getMessage());
        }
    }

    /////// check email already exists
    public function emailExists($con, $email)
    {
        $query = "SELECT User_ID FROM users WHERE Email = ?";

        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    }

    /////// get data from Users table  (FIXED: $conn -> $con to match DBconnection.php)
    public function getUserById($userID)
    {
        try {
            include '../DBconnection.php'; // creates $con via mysqli_connect

            $sql = "SELECT User_ID, Username, Full_Name, Gender, NIC,
                        Email, Phone_Number, Address, Role_ID
                    FROM users
                    WHERE User_ID = ?";

            $stmt = mysqli_prepare($con, $sql);

            if (!$stmt) {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            } else {
                throw new Exception("User not found.");
            }

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        } finally {
            if (isset($stmt)) {
                mysqli_stmt_close($stmt);
            }
            if (isset($con)) {
                mysqli_close($con);
            }
        }
    }

    ///// Update existing user's profile (new method, mirrors addUser style)
    public function updateUser($con)
    {
        try
        {
            // If a new password was set, update it too; otherwise leave password untouched
            if ($this->password !== null && $this->password !== '') {
                $query = "UPDATE users SET
                            Full_Name = ?, Gender = ?, NIC = ?, Email = ?,
                            Phone_Number = ?, Address = ?, Password = ?
                        WHERE User_ID = ?";

                $stmt = mysqli_prepare($con, $query);

                mysqli_stmt_bind_param(
                    $stmt,
                    "sssssssi",
                    $this->fullName,
                    $this->gender,
                    $this->NIC,
                    $this->email,
                    $this->phoneNo,
                    $this->address,
                    $this->password,
                    $this->userID
                );
            } else {
                $query = "UPDATE users SET
                            Full_Name = ?, Gender = ?, NIC = ?, Email = ?,
                            Phone_Number = ?, Address = ?
                        WHERE User_ID = ?";

                $stmt = mysqli_prepare($con, $query);

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssssi",
                    $this->fullName,
                    $this->gender,
                    $this->NIC,
                    $this->email,
                    $this->phoneNo,
                    $this->address,
                    $this->userID
                );
            }

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                return true;
            }

            mysqli_stmt_close($stmt);
            return false;
        }
        catch(Exception $e)
        {
            throw new Exception("Profile update failed: " . $e->getMessage());
        }
    }
}


?>