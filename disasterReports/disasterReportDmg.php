<?php
    require_once '../classes/DisasterReport.php';
    require_once '../classes/PropertyDamage.php';
    require_once '../classes/EvidenceFile.php';
    require_once '../classes/Notification.php';
    include '../userData.php';
    include '../DBconnection.php';

    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $desc = $_POST['prReportDesc-input'];

    $latitude = $_POST['latitude'] ?? null;
    $longitude = $_POST['longitude'] ?? null;

    $reportType = "Property Damage";
    $propertyType = $_POST['prType-input'];
    $damageLevel = $_POST['dmgLevel-input'];
    $damageEstCost = $_POST['cost-input'];
    $damageDescription = $_POST['prDmgDesc-input'];

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
            $report = new PropertyDamage();

            // Parent class data
            $report->setUserId($userId);
            $report->setDisasterTypeId($disasterTypeId);
            $report->setDistrict($_POST['district-input']);
            $report->setStreetAddress($_POST['stAdd-input']);
            $report->setDescription($_POST['prReportDesc-input']);
            $report->setReportType("Property Damage");

            // Child class data
            $report->setPropertyType($_POST['prType-input']);
            $report->setDamageLevel($_POST['dmgLevel-input']);
            $report->setDamageDescription($_POST['prDmgDesc-input']);
            $report->setEstimatedCost($_POST['cost-input']);
            $report->setLatitude($_POST['latitude'] ?? null);
            $report->setLongitude($_POST['longitude'] ?? null);

            // Insert main report
            $reportId = $report->insertReport($con);

            // Insert property damage details
            $report->insertPropertyDamage($con, $reportId);

            // Upload evidence
            $evidence = new EvidenceFile();
            $evidence->uploadFiles($con, $reportId, $userId);

            Notification::createNotification($con,$userId,$reportId,"New Report Requires Verification","A new property damage report has been submitted and requires authenticity verification.","Report Submitted");
            echo "success";
        }
        catch(Exception $e)
        {
            echo "Failed to Insert Report Data: ". $e->getMessage();
        }

    }
    else
    {
        echo "unauthorized";
    }

?>