<?php
    require_once '../classes/DisasterReports.php';
    require_once '../classes/EvidenceFile.php';
    include '../userData.php';
    include '../DBconnection.php';

    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $disasterDate = $_POST['date-input'];
    $desc = $_POST['prReportDesc-input'];

    $reportType = "Death Record";
    $dName = $_POST['name-input'];
    $dAge = $_POST['age-input'];
    $dGender = $_POST['gender-input'];
    $dCause = $_POST['cause-input'];

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
            $report = new DeathRecord();

            // Parent Class Data
            $report->setDisasterTypeID($disasterTypeId);
            $report->setReportType($reportType);
            $report->setDistrict($district);
            $report->setStreetAddress($streetAddress);
            $report->setDescription($desc);

            // Child Class Data
            $report->setFullName($dName);
            $report->setAge($dAge);
            $report->setGender($dGender);
            $report->setCauseOfDeath($dCause);

            // Insert into disaster_report
            $reportId = $report->insertReport($con,$userId);

            // Insert into death_record
            $report->insertDeathRecord($con, $reportId);

            // Upload Evidence Files
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