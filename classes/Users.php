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

// ================================================================//
//                          Citizen CLASS                          //
// ================================================================//

class Citizen extends User
{
    private $beneficiaryName;
    private $beneficiaryBank;
    private $beneficiaryBankAccountNo;

    //// Setters

    public function setBeneficiaryName($beneficiaryName)
    {
        $this->beneficiaryName = $beneficiaryName;
    }

    public function setBeneficiaryBank($beneficiaryBank)
    {
        $this->beneficiaryBank = $beneficiaryBank;
    }

    public function setBeneficiaryBankAccountNo($beneficiaryBankAccountNo)
    {
        $this->beneficiaryBankAccountNo = $beneficiaryBankAccountNo;
    }

    //// Getters

    public function getBeneficiaryName()
    {
        return $this->beneficiaryName;
    }

    public function getBeneficiaryBank()
    {
        return $this->beneficiaryBank;
    }

    public function getBeneficiaryBankAccountNo()
    {
        return $this->beneficiaryBankAccountNo;
    }

    //// Insert userID to citizen table

    public function addCitizen($con)
    {
        try
        {
            $query = "INSERT INTO citizen (User_ID)
                    VALUES (?)";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "i",
                $this->userID
            );

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw new Exception("failed: " . $e->getMessage());
        }

    }

    ///// Insert Users bank details to Citizen table

    public function updateBankDetails($con)
    {
        try
        {
            $query = "UPDATE citizen
                    SET Beneficiary_Name = ?,
                        Beneficiary_Bank = ?,
                        Beneficiary_Bank_Account_No = ?
                    WHERE User_ID = ?";

            $stmt = mysqli_prepare($con, $query);

            mysqli_stmt_bind_param(
                $stmt,
                "sssi",
                $this->beneficiaryName,
                $this->beneficiaryBank,
                $this->beneficiaryBankAccountNo,
                $this->userID
            );

            return mysqli_stmt_execute($stmt);
        }
        catch(Exception $e)
        {
            throw new Exception("failed: " . $e->getMessage());
        }

    }
}

// ================================================================//
//                          Admin CLASS                            //
// ================================================================//

class Admin extends User
{
    private $adminRole;

    //// Setters

    public function setAdminRole($adminRole)
    {
        $this->adminRole = $adminRole;
    }

    //// Getters

    public function getAdminRole()
    {
        return $this->adminRole;
    }

    ////// Insert Admin table

    public function addAdmin($con)
    {
        try
        {
            $query = "INSERT INTO admin (User_ID, Admin_Role)
                    VALUES (?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "is",
                $this->userID,
                $this->adminRole
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert admin record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Admin registration failed: " . $e->getMessage());
        }
    }
}

// ================================================================//
//                  LocalAuthorityOfficer CLASS                    //
// ================================================================//

class LocalAuthorityOfficer extends User
{
    private $localOfficerID;
    private $position;

    //// Setters

    public function setLocalOfficerID($localOfficerID)
    {
        $this->localOfficerID = $localOfficerID;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    //// Getters

    public function getLocalOfficerID()
    {
        return $this->localOfficerID;
    }

    public function getPosition()
    {
        return $this->position;
    }

    ///// Insert into Local Authority Officer table

    public function addLocalAuthorityOfficer($con)
    {
        try
        {
            $query = "INSERT INTO local_authority_officer
                    (User_ID, Local_Officer_ID, Position)
                    VALUES (?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "iss",
                $this->userID,
                $this->localOfficerID,
                $this->position
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Local Authority Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Local Authority Officer registration failed: " . $e->getMessage());
        }
    }
}

// ================================================================//
//               DisasterManagementOfficer CLASS                   //
// ================================================================//

class DisasterManagementOfficer extends User
{
    private $managementOfficerID;
    private $department;
    private $regionAssigned;

    //// Setters

    public function setManagementOfficerID($managementOfficerID)
    {
        $this->managementOfficerID = $managementOfficerID;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setRegionAssigned($regionAssigned)
    {
        $this->regionAssigned = $regionAssigned;
    }

    //// Getters

    public function getManagementOfficerID()
    {
        return $this->managementOfficerID;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getRegionAssigned()
    {
        return $this->regionAssigned;
    }

    /////// Inset intom Disaster management officer

    public function addDisasterManagementOfficer($con)
    {
        try
        {
            $query = "INSERT INTO disaster_management_officer
                    (User_ID, Management_Officer_ID, Department, Region_Assigned)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "isss",
                $this->userID,
                $this->managementOfficerID,
                $this->department,
                $this->regionAssigned
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Disaster Management Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Disaster Management Officer registration failed: " . $e->getMessage());
        }
    }
}

// ================================================================//
//                   DistrictSecretary CLASS                       //
// ================================================================//

class DistrictSecretary extends User
{
    private $secretaryOfficerID;
    private $officeName;
    private $officeLocation;

    //// Setters

    public function setSecretaryOfficerID($secretaryOfficerID)
    {
        $this->secretaryOfficerID = $secretaryOfficerID;
    }

    public function setOfficeName($officeName)
    {
        $this->officeName = $officeName;
    }

    public function setOfficeLocation($officeLocation)
    {
        $this->officeLocation = $officeLocation;
    }

    //// Getters

    public function getSecretaryOfficerID()
    {
        return $this->secretaryOfficerID;
    }

    public function getOfficeName()
    {
        return $this->officeName;
    }

    public function getOfficeLocation()
    {
        return $this->officeLocation;
    }

    ////// Insrrt into District secretary table

    public function addDistrictSecretary($con)
    {
        try
        {
            $query = "INSERT INTO district_secretary
                    (User_ID, Secretary_Officer_ID, Office_Name, Office_Location)
                    VALUES (?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "isss",
                $this->userID,
                $this->secretaryOfficerID,
                $this->officeName,
                $this->officeLocation
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert District Secretary record.");
        }
        catch(Exception $e)
        {
            throw new Exception("District Secretary registration failed: " . $e->getMessage());
        }
    }
}

// ================================================================//
//                    FinancialOfficer CLASS                       //
// ================================================================//

class FinancialOfficer extends User
{
    private $financialOfficerID;
    private $department;
    private $bankName;
    private $bankAccountNo;

    //// Setters

    public function setFinancialOfficerID($financialOfficerID)
    {
        $this->financialOfficerID = $financialOfficerID;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;
    }

    //// Getters

    public function getFinancialOfficerID()
    {
        return $this->financialOfficerID;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function getBankName()
    {
        return $this->bankName;
    }

    public function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    ///// insert into fianacila officer table

    public function addFinancialOfficer($con)
    {
        try
        {
            $query = "INSERT INTO financial_officer
                    (User_ID, Financial_Officer_ID, Department, Bank_Name, Bank_Account_No)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($con, $query);

            if(!$stmt)
            {
                throw new Exception("Failed to prepare statement.");
            }

            mysqli_stmt_bind_param(
                $stmt,
                "issss",
                $this->userID,
                $this->financialOfficerID,
                $this->department,
                $this->bankName,
                $this->bankAccountNo
            );

            if(mysqli_stmt_execute($stmt))
            {
                return true;
            }

            throw new Exception("Failed to insert Financial Officer record.");
        }
        catch(Exception $e)
        {
            throw new Exception("Financial Officer registration failed: " . $e->getMessage());
        }
    }
}

?>