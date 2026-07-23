<?php
session_start();

require_once '../DBconnection.php';
require_once '../classes/User.php';
require_once '../classes/Admin.php';
require_once '../classes/Citizen.php';
require_once '../classes/DisasterManagementOfficer.php';
require_once '../classes/DistrictSecretary.php';
require_once '../classes/FinancialOfficer.php';
require_once '../classes/LocalAuthorityOfficer.php';

// Role_ID mapping — matches the roles table (1 Admin, 2 DMO, 3 Citizen, 4 LAO, 5 DS, 6 FO)
$roleIdMap = [
    'admin'   => 1,
    'dmo'     => 2,
    'citizen' => 3,
    'lao'     => 4,
    'ds'      => 5,
    'fo'      => 6,
];

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $type = $_POST['userType'] ?? '';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $fullName = $_POST['fullName'] ?? '';
    $gender   = $_POST['gender'] ?? '';
    $nic      = $_POST['nic'] ?? '';
    $email    = $_POST['email'] ?? '';
    $phone    = $_POST['phone'] ?? '';
    $address  = $_POST['address'] ?? '';
    $status   = $_POST['status'] ?? '';

    try
    {
        if (!array_key_exists($type, $roleIdMap))
        {
            throw new Exception("Invalid user type.");
        }

        if ($username === '' || $password === '' || $fullName === '' || $gender === '' ||
            $nic === '' || $email === '' || $phone === '' || $address === '' || $status === '')
        {
            throw new Exception("Please fill all required fields.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Build the correct child object based on role type
        switch ($type)
        {
            case 'citizen': $user = new Citizen(); break;
            case 'admin':   $user = new Admin(); break;
            case 'lao':     $user = new LocalAuthorityOfficer(); break;
            case 'dmo':     $user = new DisasterManagementOfficer(); break;
            case 'ds':      $user = new DistrictSecretary(); break;
            case 'fo':      $user = new FinancialOfficer(); break;
        }

        if ($user->emailExists($con, $email))
        {
            throw new Exception("Email already exists!");
        }

        if ($user->userNameExists($con, $username))
        {
            throw new Exception("Username already exists!");
        }

        // Common User fields
        $user->setUserName($username);
        $user->setPassword($hashedPassword);
        $user->setFullName($fullName);
        $user->setGender($gender);
        $user->setNIC($nic);
        $user->setEmail($email);
        $user->setPhoneNo($phone);
        $user->setAddress($address);
        $user->setRoleID($roleIdMap[$type]);
        $user->setStatus($status);

        // Insert into users table
        $userID = $user->addUser($con);

        if (!$userID)
        {
            throw new Exception("User registration failed.");
        }

        // Insert into role-specific table
        switch ($type)
        {
            case 'citizen':
                $user->setBeneficiaryName($_POST['beneficiaryName'] ?? '');
                $user->setBeneficiaryBank($_POST['beneficiaryBank'] ?? '');
                $user->setBeneficiaryBankAccountNo($_POST['beneficiaryBankAccountNo'] ?? '');
                if (!$user->addFullCitizen($con))
                {
                    throw new Exception("Citizen record creation failed.");
                }
                break;

            case 'admin':
                $adminRole = $_POST['adminRole'] ?? '';
                if ($adminRole === '') throw new Exception("Admin Role is required.");
                $user->setAdminRole($adminRole);
                $user->addAdmin($con);
                break;

            case 'lao':
                $localOfficerID = $_POST['localOfficerID'] ?? '';
                $position = $_POST['position'] ?? '';
                $assignedDS = $_POST['assignedDivisionalSecretariat'] ?? '';
                if ($localOfficerID === '' || $position === '' || $assignedDS === '')
                {
                    throw new Exception("All Local Authority Officer fields are required.");
                }
                $user->setLocalOfficerID($localOfficerID);
                $user->setPosition($position);
                $user->setAssigned_divisional_secretariat($assignedDS);
                $user->addLocalAuthorityOfficer($con);
                break;

            case 'dmo':
                $managementOfficerID = $_POST['managementOfficerID'] ?? '';
                $dmoDepartment = $_POST['department'] ?? '';
                $regionAssigned = $_POST['regionAssigned'] ?? '';
                if ($managementOfficerID === '' || $dmoDepartment === '' || $regionAssigned === '')
                {
                    throw new Exception("All Disaster Management Officer fields are required.");
                }
                $user->setManagementOfficerID($managementOfficerID);
                $user->setDepartment($dmoDepartment);
                $user->setRegionAssigned($regionAssigned);
                $user->addDisasterManagementOfficer($con);
                break;

            case 'ds':
                $secretaryOfficerID = $_POST['secretaryOfficerID'] ?? '';
                $officeName = $_POST['officeName'] ?? '';
                $officeLocation = $_POST['officeLocation'] ?? '';
                if ($secretaryOfficerID === '' || $officeName === '' || $officeLocation === '')
                {
                    throw new Exception("All District Secretary fields are required.");
                }
                $user->setSecretaryOfficerID($secretaryOfficerID);
                $user->setOfficeName($officeName);
                $user->setOfficeLocation($officeLocation);
                $user->addDistrictSecretary($con);
                break;

            case 'fo':
                $financialOfficerID = $_POST['financialOfficerID'] ?? '';
                $foDepartment = $_POST['department'] ?? '';
                $bankName = $_POST['bankName'] ?? '';
                $bankAccountNo = $_POST['bankAccountNo'] ?? '';
                if ($financialOfficerID === '' || $foDepartment === '' || $bankName === '' || $bankAccountNo === '')
                {
                    throw new Exception("All Financial Officer fields are required.");
                }
                $user->setFinancialOfficerID($financialOfficerID);
                $user->setDepartment($foDepartment);
                $user->setBankName($bankName);
                $user->setBankAccountNo($bankAccountNo);
                $user->addFinancialOfficer($con);
                break;
        }

        $_SESSION['message'] = "User created successfully!";
        $_SESSION['icon'] = "success";

        header("Location: AdmindashboardForm.php");
        exit();
    }
    catch (Exception $e)
    {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['icon'] = "error";

        header("Location: AdminAddUserForm.php?type=" . urlencode($type));
        exit();
    }
    finally
    {
        mysqli_close($con);
    }
}
?>
