<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    require_once '../classes/DisasterReport.php';
    require_once '../classes/MissingPerson.php';
    require_once '../classes/EvidenceFile.php';
    require_once '../classes/Notification.php';
    include '../userData.php';
    include '../DBconnection.php';

    // ---------- AJAX: fetch DS list for a district ----------
    if (isset($_POST['action']) && $_POST['action'] === 'getDS')
    {
        header('Content-Type: application/json');

        $district = $_POST['district'] ?? null;

        if (!$district) {
            echo json_encode(['error' => 'No district provided']);
            exit;
        }

        try {
            $dsList = DisasterReport::getDivisionalSecretariat($con, $district);
            echo json_encode($dsList);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

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

            // DS_ID comes directly from the DS combo box the user picked
            $DSID = $_POST['ds-input'] ?? null;

            if (!$DSID || $DSID === 'default') {
                echo "Please select a Divisional Secretariat.";
                exit;
            }

            $report->setDSID($DSID);

            // Child Class Data
            $report->setFullName($mName);
            $report->setAge($mAge);
            $report->setGender($mGender);
            $report->setLastSeenLocation($mLastSeen);
            $report->setLastSeenDate($mLastDate);
            $report->setLastSeenTime($mLastTime);
            $report->setRelationshipToPerson($mRel);

            // Insert into disaster_report
            $reportId = $report->insertReport($con);

            // Insert into missing_person_record
            $report->insertMissingPersonRecord($con, $reportId);

            // Upload Evidence Files
            $evidence = new EvidenceFile();
            $evidence->uploadFiles($con, $reportId, $userId);

            Notification :: createLAONotification(
            $con,$DSID,$reportId,
            "New Missing Person Report",
            "A new Missing Person Report has been submitted for your Divisional Secretariat and requires review.",
            "Report Submitted");

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