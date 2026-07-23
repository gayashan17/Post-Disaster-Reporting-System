<?php
    require_once '../classes/DisasterReport.php';
    require_once '../classes/InjuredPerson.php';
    require_once '../classes/EvidenceFile.php';
    include '../userData.php';
    include '../DBconnection.php';

// ================================================================
// LOAD DIVISIONAL SECRETARIATS BY DISTRICT
// ================================================================

if (isset($_POST['action']) && $_POST['action'] === 'getDSByDistrict')
{
    header('Content-Type: application/json');

    try
    {
        $district = $_POST['district'] ?? '';

        if (empty($district))
        {
            throw new Exception("District is required.");
        }

        $report = new DisasterReport();

        $dsList = $report->getDSByDistrict($con, $district);

        echo json_encode([
            "success" => true,
            "data" => $dsList
        ]);
    }
    catch (Exception $e)
    {
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }

    exit;
}


// ================================================================
// GET FORM DATA
// ================================================================

    $district = $_POST['district-input'] ?? '';
    $DS_ID = $_POST['ds-input'] ?? '';
    $streetAddress = $_POST['stAdd-input'];
    $disasterDate = $_POST['date-input'];
    $desc = $_POST['prReportDesc-input'];

    $reportType = "Injured Person";
    $injName = $_POST['name-input'];
    $injAge = $_POST['age-input'];
    $injGender = $_POST['gender-input'];
    $injLevel = $_POST['injuryLevel-input'];

    $dlec   = $_POST['declaration-input'];

    switch ($_POST['disaster-input']) {
            case 'flood':
                $disasterTypeId = 22;
                break;
            case 'landslide':
                $disasterTypeId = 23;
                break;
            case 'cyclone':
                $disasterTypeId = 24;
                break;
            case 'earthquake':
                $disasterTypeId = 25;
                break;
            case 'fire':
                $disasterTypeId = 26;
                break;
            case 'tsunami':
                $disasterTypeId = 27;
                break;
            case 'other':
            default:
                $disasterTypeId = 28;
                break;
        }

    if(isset($_POST['declaration-input']))
    {
        try
        {
            $report = new InjuredPerson();

            // Parent Class Data
            $report->setUserID($userId);
            $report->setDisasterTypeID($disasterTypeId);
            $report->setReportType($reportType);
            $report->setDistrict($district);
            $report->setDS_ID($DS_ID);
            $report->setStreetAddress($streetAddress);
            $report->setDescription($desc);

            // Child Class Data
            $report->setFullName($injName);
            $report->setAge($injAge);
            $report->setGender($injGender);
            $report->setInjuredLevel($injLevel);

            // Insert into disaster_report
            $reportId = $report->insertReport($con);

            // Insert into injured_person
            $report->insertInjuredPerson($con, $reportId);

            // Upload Evidence
            $evidence = new EvidenceFile();
            $evidence->uploadFiles($con, $reportId, $userId);

            echo "success";
        }
        catch(Exception $e)
        {
            echo "Failed to Insert Report Data: " . $e->getMessage();
        }
    }
    else
    {
        echo "unauthorized";
    }

?>