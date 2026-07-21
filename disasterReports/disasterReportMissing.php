<?php
    require_once '../classes/DisasterReports.php';
    require_once '../classes/EvidenceFile.php';
    include '../userData.php';
    include '../DBconnection.php';

    $district = $_POST['district-input'];
    $streetAddress = $_POST['stAdd-input'];
    $disasterDate = $_POST['date-input'];
    $desc = $_POST['prReportDesc-input'];

    $reportType = "Missing Person Record";
    $mName = $_POST['name-input'];
    $mAge = $_POST['age-input'];
    $mGender = $_POST['gender-input'];
    $mRel = $_POST['rel-input'];
    $mLastSeen = $_POST['lastSeen-input'];
    $mLastDate = $_POST['lastDate-input'];
    $mLastTime = $_POST['lastTime-input'];

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
            $report = new MissingPerson();

            // Parent Class Data
            $report->setUserID($userId);
            $report->setDisasterTypeID($disasterTypeId);
            $report->setReportType($reportType);
            $report->setDistrict($district);
            $report->setStreetAddress($streetAddress);
            $report->setDescription($desc);

            // Child Class Data
            $report->setFullName($mName);
            $report->setAge($mAge);
            $report->setGender($mGender);
            $report->setLastSeenLocation($mLastSeen);
            $report->setLastSeenDate($mLastDate);
            $report->setLastSeenTime($mLastTime);
            $report->setRelationshipToPerson($mRel);

            // Insert into disaster_report
            $reportId = $report->insertReport($con,$userId);

            // Insert into missing_person_record
            $report->insertMissingPersonRecord($con, $reportId);

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